<?php $title = 'New Application'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1>New Application</h1>
            <a href="/applications" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Application Form</h5>
    </div>
    <div class="card-body">
        <form action="/applications/create" method="post" enctype="multipart/form-data">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Personal Information</h4>
                    <hr>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Educational Background</h4>
                    <hr>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="previous_school" class="form-label">Previous School</label>
                    <input type="text" class="form-control" id="previous_school" name="previous_school">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="qualification" class="form-label">Highest Qualification</label>
                    <input type="text" class="form-control" id="qualification" name="qualification">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="year_completed" class="form-label">Year Completed</label>
                    <input type="text" class="form-control" id="year_completed" name="year_completed">
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Program Information</h4>
                    <hr>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="program" class="form-label">Program Applied For <span class="text-danger">*</span></label>
                    <select class="form-select" id="program" name="program" required>
                        <option value="">Select Program</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Business Administration">Business Administration</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Medicine">Medicine</option>
                        <option value="Law">Law</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Intended Start Date</label>
                    <input type="month" class="form-control" id="start_date" name="start_date">
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Supporting Documents</h4>
                    <hr>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="documents" class="form-label">Upload Documents (Transcripts, Certificates, etc.)</label>
                    <input type="file" class="form-control" id="documents" name="documents[]" multiple>
                    <div class="form-text">You can upload multiple files. Maximum size: 5MB per file.</div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </div>
        </form>
    </div>
</div>