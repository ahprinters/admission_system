<?php $title = 'Dashboard'; ?>

<div class="row">
    <div class="col-md-12 mb-4">
        <h1>Dashboard</h1>
        <p class="lead">Welcome to the Admission System Dashboard</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Applications</h5>
                <p class="card-text display-4"><?= $totalApplications ?? 0 ?></p>
                <a href="/applications" class="btn btn-primary">View All</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Applications</h5>
                <p class="card-text display-4"><?= $pendingApplications ?? 0 ?></p>
                <a href="/applications?status=pending" class="btn btn-warning">View Pending</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Approved Applications</h5>
                <p class="card-text display-4"><?= $approvedApplications ?? 0 ?></p>
                <a href="/applications?status=approved" class="btn btn-success">View Approved</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                Recent Applications
            </div>
            <div class="card-body">
                <?php if (!empty($recentApplications)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Applicant</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentApplications as $app): ?>
                                <tr>
                                    <td><?= $app['id'] ?></td>
                                    <td><?= $app['name'] ?></td>
                                    <td><?= date('M d, Y', strtotime($app['created_at'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $app['status'] === 'approved' ? 'success' : ($app['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                            <?= ucfirst($app['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/applications/view/<?= $app['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No recent applications found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/applications/create" class="btn btn-primary">New Application</a>
                    <a href="/reports" class="btn btn-info">Generate Reports</a>
                    <a href="/settings" class="btn btn-secondary">System Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>