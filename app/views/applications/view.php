<?php $title = 'View Application'; ?>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Application Details</h1>
            <div>
                <a href="/applications" class="btn btn-secondary">Back to List</a>
                <?php if ($application['status'] === 'pending'): ?>
                    <a href="/applications/approve/<?= $application['id'] ?>" class="btn btn-success">Approve</a>
                    <a href="/applications/reject/<?= $application['id'] ?>" class="btn btn-danger">Reject</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Application ID:</div>
                    <div class="col-md-8"><?= $application['id'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Full Name:</div>
                    <div class="col-md-8"><?= $application['name'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Email:</div>
                    <div class="col-md-8"><?= $application['email'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Phone:</div>
                    <div class="col-md-8"><?= $application['phone'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Date of Birth:</div>
                    <div class="col-md-8"><?= date('F d, Y', strtotime($application['dob'])) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Address:</div>
                    <div class="col-md-8"><?= $application['address'] ?></div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Educational Background</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Previous School:</div>
                    <div class="col-md-8"><?= $application['previous_school'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Qualification:</div>
                    <div class="col-md-8"><?= $application['qualification'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Year Completed:</div>
                    <div class="col-md-8"><?= $application['year_completed'] ?></div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Program Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Applied Program:</div>
                    <div class="col-md-8"><?= $application['program'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Start Date:</div>
                    <div class="col-md-8"><?= date('F Y', strtotime($application['start_date'])) ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Application Status</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">Status:</div>
                    <div>
                        <span class="badge bg-<?= $application['status'] === 'approved' ? 'success' : ($application['status'] === 'rejected' ? 'danger' : 'warning') ?> fs-6">
                            <?= ucfirst($application['status']) ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-5 fw-bold">Submitted:</div>
                    <div class="col-md-7"><?= date('M d, Y', strtotime($application['created_at'])) ?></div>
                </div>
                <?php if ($application['updated_at'] !== $application['created_at']): ?>
                <div class="row mb-3">
                    <div class="col-md-5 fw-bold">Last Updated:</div>
                    <div class="col-md-7"><?= date('M d, Y', strtotime($application['updated_at'])) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Documents</h5>
            </div>
            <div class="card-body">
                <?php if (empty($documents)): ?>
                    <p class="text-muted">No documents uploaded.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($documents as $doc): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-text me-2"></i>
                                    <?= $doc['name'] ?>
                                </div>
                                <a href="/documents/download/<?= $doc['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Add Note</h5>
            </div>
            <div class="card-body">
                <form action="/applications/add-note/<?= $application['id'] ?>" method="post">
                    <div class="mb-3">
                        <textarea name="note" class="form-control" rows="3" placeholder="Enter your note here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
            </div>
        </div>
        
        <?php if (!empty($notes)): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Notes History</h5>
            </div>
            <div class="card-body">
                <?php foreach ($notes as $note): ?>
                <div class="border-bottom mb-3 pb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="fw-bold"><?= $note['created_by'] ?></div>
                        <div class="text-muted small"><?= date('M d, Y H:i', strtotime($note['created_at'])) ?></div>
                    </div>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>