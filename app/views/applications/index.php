<?php $title = 'Applications'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h1>Applications</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="/applications/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Application
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Filter Applications</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="btn-group mb-3" role="group">
            <a href="/applications" class="btn btn-outline-secondary <?= !isset($status) ? 'active' : '' ?>">All</a>
            <a href="/applications?status=pending" class="btn btn-outline-warning <?= $status === 'pending' ? 'active' : '' ?>">Pending</a>
            <a href="/applications?status=approved" class="btn btn-outline-success <?= $status === 'approved' ? 'active' : '' ?>">Approved</a>
            <a href="/applications?status=rejected" class="btn btn-outline-danger <?= $status === 'rejected' ? 'active' : '' ?>">Rejected</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Application List</h5>
    </div>
    <div class="card-body">
        <?php if (empty($applications)): ?>
            <div class="alert alert-info">
                No applications found.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= $app['id'] ?></td>
                            <td><?= $app['name'] ?></td>
                            <td><?= $app['program'] ?></td>
                            <td><?= date('M d, Y', strtotime($app['created_at'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $app['status'] === 'approved' ? 'success' : ($app['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                    <?= ucfirst($app['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="/applications/view/<?= $app['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>