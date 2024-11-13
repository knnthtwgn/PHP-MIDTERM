<?php
// Start the session to use error handling and store student data
session_start();

// Initialize error messages
$errors = [];

// Initialize students array in the session if it doesn't exist
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $studentID = htmlspecialchars($_POST['studentID']);
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);

    // Validate form fields
    if (empty($studentID)) {
        $errors[] = 'Student ID is required';
    }
    if (empty($firstName)) {
        $errors[] = 'First Name is required';
    }
    if (empty($lastName)) {
        $errors[] = 'Last Name is required';
    }

    // Check for duplicate Student ID if there are no other validation errors
    if (empty($errors)) {
        foreach ($_SESSION['students'] as $student) {
            if ($student['id'] === $studentID) {
                $errors[] = 'Duplicate Student ID';
                break;
            }
        }
    }

    // If no errors, add student to the session data
    if (empty($errors)) {
        $newStudent = [
            'id' => $studentID,
            'first_name' => $firstName,
            'last_name' => $lastName
        ];
        $_SESSION['students'][] = $newStudent;
        
        // Clear the form data to prevent re-submission
        header('Location: register.php');
        exit;
    }
}

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($_SESSION['students'] as $key => $student) {
        if ($student['id'] === $id) {
            unset($_SESSION['students'][$key]);
            $_SESSION['students'] = array_values($_SESSION['students']); // Reindex the array
            break;
        }
    }
    header('Location: register.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Register a New Student</h2>
    
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Register Student</li>
        </ol>
    </nav>
    
    <!-- Error Handling -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h5>System Errors:</h5>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <div class="card mt-4 p-4">
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="studentID">Student ID</label>
                <input type="text" id="studentID" name="studentID" class="form-control" placeholder="Enter Student ID" value="<?php echo isset($_POST['studentID']) ? htmlspecialchars($_POST['studentID']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-control" placeholder="Enter First Name" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Enter Last Name" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
    
    <!-- Student List -->
    <div class="card mt-4 p-4">
        <h5>Student List</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($_SESSION['students'])): ?>
                    <tr>
                        <td colspan="4" class="text-center">No student records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($_SESSION['students'] as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="register.php?action=delete&id=<?php echo $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                <a href="attach-student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-secondary">Attach Subject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
