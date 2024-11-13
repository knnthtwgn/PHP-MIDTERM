<?php
session_start();

// Initialize error messages
$errors = [];

// Check if a valid student ID is provided
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];
    // Find the student data by ID
    foreach ($_SESSION['students'] as $index => $student) {
        if ($student['id'] === $studentID) {
            $studentIndex = $index;
            $selectedStudent = $student;
            break;
        }
    }
    
    // If student data is not found, redirect back to register.php
    if (!isset($selectedStudent)) {
        header('Location: register.php');
        exit;
    }
} else {
    header('Location: register.php');
    exit;
}

// Handle the form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);

    // Validate form fields
    if (empty($firstName)) {
        $errors[] = 'First Name is required';
    }
    if (empty($lastName)) {
        $errors[] = 'Last Name is required';
    }

    // If no errors, update student data in session
    if (empty($errors)) {
        $_SESSION['students'][$studentIndex]['first_name'] = $firstName;
        $_SESSION['students'][$studentIndex]['last_name'] = $lastName;

        // Redirect back to register.php after updating
        header('Location: register.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Student</h2>
    
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
        </ol>
    </nav>
    
    <!-- Error Handling -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>System Errors:</h5>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Edit Form -->
    <form action="" method="POST" class="mt-4">
        <div class="form-group">
            <label for="studentID">Student ID</label>
            <input type="text" id="studentID" name="studentID" class="form-control" value="<?php echo htmlspecialchars($selectedStudent['id']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo htmlspecialchars($selectedStudent['first_name']); ?>">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo htmlspecialchars($selectedStudent['last_name']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
        <a href="register.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
