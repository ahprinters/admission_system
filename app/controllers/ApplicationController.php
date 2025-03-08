<?php

namespace App\Controllers;

use App\Database\DatabaseConnection; // Updated namespace to match your actual DatabaseConnection class
use PDO;

class ApplicationController
{
    private $db;

    public function __construct()
    {
        // Updated to use the static method from your DatabaseConnection class
        $this->db = DatabaseConnection::getConnection();
    }
    
    public function index()
    {
        // Get status filter if provided
        $status = $_GET['status'] ?? null;
        
        // Build query based on status filter
        $query = "SELECT * FROM applications";
        $params = [];
        
        if ($status) {
            $query .= " WHERE status = :status";
            $params[':status'] = $status;
        }
        
        $query .= " ORDER BY created_at DESC";
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $applications = $stmt->fetchAll();
        
        // Render the applications list view
        $title = 'Applications';
        $content = $this->renderView('applications/index', [
            'applications' => $applications,
            'status' => $status
        ]);
        
        include __DIR__ . '/../views/templates/base.php';
    }
    
    public function view($id)
    {
        // Get application details
        $stmt = $this->db->prepare("SELECT * FROM applications WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $application = $stmt->fetch();
        
        if (!$application) {
            // Application not found, redirect to applications list
            header('Location: /applications');
            exit;
        }
        
        // Get documents for this application
        $docStmt = $this->db->prepare("SELECT * FROM documents WHERE application_id = :app_id");
        $docStmt->execute([':app_id' => $id]);
        $documents = $docStmt->fetchAll();
        
        // Get notes for this application
        $noteStmt = $this->db->prepare("SELECT * FROM notes WHERE application_id = :app_id ORDER BY created_at DESC");
        $noteStmt->execute([':app_id' => $id]);
        $notes = $noteStmt->fetchAll();
        
        // Render the application view
        $title = 'View Application';
        $content = $this->renderView('applications/view', [
            'application' => $application,
            'documents' => $documents,
            'notes' => $notes
        ]);
        
        include __DIR__ . '/../views/templates/base.php';
    }
    
    public function create()
    {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $dob = $_POST['dob'] ?? '';
            $address = $_POST['address'] ?? '';
            $previous_school = $_POST['previous_school'] ?? '';
            $qualification = $_POST['qualification'] ?? '';
            $year_completed = $_POST['year_completed'] ?? '';
            $program = $_POST['program'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $start_date = $start_date . '-01'; // Make sure the day is set to the 1st of the month when only month precision is needed.
            
            // Basic validation
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Name is required';
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email is required';
            }
            
            // If no errors, save the application
            if (empty($errors)) {
                $stmt = $this->db->prepare("
                    INSERT INTO applications (
                        name, email, phone, dob, address, 
                        previous_school, qualification, year_completed, 
                        program, start_date, status, created_at, updated_at
                    ) VALUES (
                        :name, :email, :phone, :dob, :address,
                        :previous_school, :qualification, :year_completed,
                        :program, :start_date, 'pending', NOW(), NOW()
                    )
                ");
                
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':dob' => $dob,
                    ':address' => $address,
                    ':previous_school' => $previous_school,
                    ':qualification' => $qualification,
                    ':year_completed' => $year_completed,
                    ':program' => $program,
                    ':start_date' => $start_date
                ]);
                
                $applicationId = $this->db->lastInsertId();
                
                // Handle photo upload
                if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../uploads/photos/';
                    
                    // Create directory if it doesn't exist
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $tmpName = $_FILES['photo']['tmp_name'];
                    $fileName = $applicationId . '_' . uniqid() . '_' . basename($_FILES['photo']['name']);
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($tmpName, $filePath)) {
                        // Update the application with the photo path
                        $photoStmt = $this->db->prepare("
                            UPDATE applications 
                            SET photo_path = :photo_path 
                            WHERE id = :id
                        ");
                        
                        $photoStmt->execute([
                            ':id' => $applicationId,
                            ':photo_path' => $filePath
                        ]);
                    }
                }
                
                // Handle document uploads
                if (!empty($_FILES['documents']['name'][0])) {
                    $uploadDir = __DIR__ . '/../../uploads/';
                    
                    // Create directory if it doesn't exist
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    foreach ($_FILES['documents']['name'] as $key => $name) {
                        if ($_FILES['documents']['error'][$key] === UPLOAD_ERR_OK) {
                            $tmpName = $_FILES['documents']['tmp_name'][$key];
                            $fileName = uniqid() . '_' . basename($name);
                            $filePath = $uploadDir . $fileName;
                            
                            if (move_uploaded_file($tmpName, $filePath)) {
                                // Save document info to database
                                $docStmt = $this->db->prepare("
                                    INSERT INTO documents (
                                        application_id, name, file_path, uploaded_at
                                    ) VALUES (
                                        :app_id, :name, :file_path, NOW()
                                    )
                                ");
                                
                                $docStmt->execute([
                                    ':app_id' => $applicationId,
                                    ':name' => $name,
                                    ':file_path' => $filePath
                                ]);
                            }
                        }
                    }
                }
                
                // Redirect to the application view
                header("Location: /applications/view/{$applicationId}");
                exit;
            }
        }
        
        // Render the application form
        $title = 'New Application';
        $content = $this->renderView('applications/create', [
            'errors' => $errors ?? []
        ]);
        
        include __DIR__ . '/../views/templates/base.php';
    }
    
    public function approve($id)
    {
        $this->updateStatus($id, 'approved');
        header("Location: /applications/view/{$id}");
        exit;
    }
    
    public function reject($id)
    {
        $this->updateStatus($id, 'rejected');
        header("Location: /applications/view/{$id}");
        exit;
    }
    
    public function addNote($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $note = $_POST['note'] ?? '';
            
            if (!empty($note)) {
                $stmt = $this->db->prepare("
                    INSERT INTO notes (
                        application_id, content, created_by, created_at
                    ) VALUES (
                        :app_id, :content, :created_by, NOW()
                    )
                ");
                
                $stmt->execute([
                    ':app_id' => $id,
                    ':content' => $note,
                    ':created_by' => 'Admin' // You can replace with actual user info when you implement authentication
                ]);
            }
        }
        
        // Redirect back to the application view
        header("Location: /applications/view/{$id}");
        exit;
    }
    
    private function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE applications 
            SET status = :status, updated_at = NOW() 
            WHERE id = :id
        ");
        
        $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
    
    private function renderView($view, $data = [])
    {
        // Extract data to make variables available in the view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include __DIR__ . "/../views/{$view}.php";
        
        // Get the contents of the buffer and clean it
        $content = ob_get_clean();
        
        return $content;
    }
}