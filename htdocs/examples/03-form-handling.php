<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Handling Example</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-forms me-2 text-warning"></i>
                        Form Handling Example
                    </h1>
                    <p class="text-muted">Learn how to handle form submissions with validation and sanitization.</p>
                </div>
            </div>

            <?php
            $formSubmitted = false;
            $errors = [];
            $formData = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $formSubmitted = true;
                
                // Validate and sanitize inputs
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $age = trim($_POST['age'] ?? '');
                $gender = $_POST['gender'] ?? '';
                $country = $_POST['country'] ?? '';
                $message = trim($_POST['message'] ?? '');
                $newsletter = isset($_POST['newsletter']);
                
                // Validation
                if (empty($name)) {
                    $errors['name'] = 'Name is required';
                } elseif (strlen($name) < 2) {
                    $errors['name'] = 'Name must be at least 2 characters';
                }
                
                if (empty($email)) {
                    $errors['email'] = 'Email is required';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Invalid email format';
                }
                
                if (empty($age)) {
                    $errors['age'] = 'Age is required';
                } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
                    $errors['age'] = 'Age must be between 1 and 120';
                }
                
                if (empty($gender)) {
                    $errors['gender'] = 'Please select a gender';
                }
                
                if (empty($country)) {
                    $errors['country'] = 'Please select a country';
                }
                
                if (empty($message)) {
                    $errors['message'] = 'Message is required';
                } elseif (strlen($message) < 10) {
                    $errors['message'] = 'Message must be at least 10 characters';
                }
                
                // If no errors, sanitize and store data
                if (empty($errors)) {
                    $formData = [
                        'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                        'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
                        'age' => (int)$age,
                        'gender' => htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'),
                        'country' => htmlspecialchars($country, ENT_QUOTES, 'UTF-8'),
                        'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
                        'newsletter' => $newsletter,
                        'submitted_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            ?>

            <?php if ($formSubmitted && empty($errors)): ?>
                <div class="alert alert-success alert-dismissible">
                    <i class="ti ti-check me-2"></i>
                    <strong>Form submitted successfully!</strong> All validation passed.
                </div>
                
                <div class="card mb-3 border-start border-success border-4">
                    <div class="card-header">
                        <h3 class="card-title">Submitted Data (Sanitized)</h3>
                    </div>
                    <div class="card-body">
                        <pre class="bg-dark text-white p-3 rounded mb-0"><code><?php echo json_encode($formData, JSON_PRETTY_PRINT); ?></code></pre>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <i class="ti ti-alert-circle me-2"></i>
                    <strong>Form validation failed!</strong> Please correct the errors below.
                </div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Sample Contact Form</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                                       name="name" placeholder="Enter your full name"
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['name']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Email Address</label>
                                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                       name="email" placeholder="email@example.com"
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Age</label>
                                <input type="number" class="form-control <?php echo isset($errors['age']) ? 'is-invalid' : ''; ?>" 
                                       name="age" min="1" max="120" placeholder="Age"
                                       value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>">
                                <?php if (isset($errors['age'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['age']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Gender</label>
                                <select class="form-select <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" name="gender">
                                    <option value="">-- Select --</option>
                                    <option value="male" <?php echo (($_POST['gender'] ?? '') === 'male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo (($_POST['gender'] ?? '') === 'female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo (($_POST['gender'] ?? '') === 'other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <?php if (isset($errors['gender'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['gender']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Country</label>
                                <select class="form-select <?php echo isset($errors['country']) ? 'is-invalid' : ''; ?>" name="country">
                                    <option value="">-- Select --</option>
                                    <option value="USA" <?php echo (($_POST['country'] ?? '') === 'USA') ? 'selected' : ''; ?>>USA</option>
                                    <option value="UK" <?php echo (($_POST['country'] ?? '') === 'UK') ? 'selected' : ''; ?>>UK</option>
                                    <option value="Canada" <?php echo (($_POST['country'] ?? '') === 'Canada') ? 'selected' : ''; ?>>Canada</option>
                                    <option value="Philippines" <?php echo (($_POST['country'] ?? '') === 'Philippines') ? 'selected' : ''; ?>>Philippines</option>
                                    <option value="Other" <?php echo (($_POST['country'] ?? '') === 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <?php if (isset($errors['country'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['country']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label required">Message</label>
                            <textarea class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                                      name="message" rows="4" placeholder="Enter your message (minimum 10 characters)"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['message']; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" name="newsletter" 
                                       <?php echo isset($_POST['newsletter']) ? 'checked' : ''; ?>>
                                <span class="form-check-label">Subscribe to newsletter</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-send me-1"></i>
                            Submit Form
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="02-crud-operations.php" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Previous: CRUD Operations
                </a>
                <a href="index.php" class="btn">
                    Back to Examples
                </a>
                <a href="04-session-management.php" class="btn btn-primary">
                    Next: Session Management
                    <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
