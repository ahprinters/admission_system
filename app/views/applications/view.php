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
            <div class