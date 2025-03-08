<?php include __DIR__ . '/../templates/base.php'; ?>

<div class="container mt-5">
    <h2>School Admission Appeal Form</h2>
    <form method="post" action="/applications/create">
        <div class="mb-3">
            <label for="application_id" class="form-label">Application ID</label>
            <input type="text" name="application_id" id="application_id" class="form-control">
        </div>
        <div class="mb-3">
            <label for="program_applied" class="form-label">Program Applied</label>
            <input type="text" name="program_applied" id="program_applied" class="form-control">
        </div>
        <div class="mb-3">
            <label for="term_year" class="form-label">Term/Year</label>
            <input type="text" name="term_year" id="term_year" class="form-control">
        </div>
        <div class="mb-3">
            <label for="admission_decision" class="form-label">Admission Decision</label