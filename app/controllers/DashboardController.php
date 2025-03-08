<?php

namespace App\Controllers;

use App\Dashboard\DatabaseConnection;
use PDO;

class DashboardController
{
    private $db;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->db = $dbConnection->getConnection();
    }

    public function index()
    {
        // Get total applications count
        $totalQuery = $this->db->query("SELECT COUNT(*) as total FROM applications");
        $totalApplications = $totalQuery->fetch()['total'] ?? 0;
        
        // Get pending applications count
        $pendingQuery = $this->db->query("SELECT COUNT(*) as total FROM applications WHERE status = 'pending'");
        $pendingApplications = $pendingQuery->fetch()['total'] ?? 0;
        
        // Get approved applications count
        $approvedQuery = $this->db->query("SELECT COUNT(*) as total FROM applications WHERE status = 'approved'");
        $approvedApplications = $approvedQuery->fetch()['total'] ?? 0;
        
        // Get recent applications
        $recentQuery = $this->db->query("
            SELECT id, name, created_at, status 
            FROM applications 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $recentApplications = $recentQuery->fetchAll();
        
        // Render the dashboard view with data
        include __DIR__ . '/../views/templates/base.php';
        
        // Set variables for the view
        $title = 'Dashboard';
        $content = $this->renderView('dashboard', [
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'approvedApplications' => $approvedApplications,
            'recentApplications' => $recentApplications
        ]);
        
        // Include the view
        include __DIR__ . '/../views/dashboard.php';
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