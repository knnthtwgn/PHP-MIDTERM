<?php
session_start(); // Start the session to access stored students

// Check if the 'index' parameter exists in the URL and is valid
if (isset($_GET['index']) && isset($_SESSION['students'][$_GET['index']])) {
    $studentIndex = $_GET['index']; // Get the index of the student to delete
    $student = $_SESSION['students'][$studentIndex]; // Retrieve the student details
} else {
    // If no valid index is found, redirect back to the student list (register.php)
    header('Location: register.php');
    exit;
}

// Handle the student deletion when the form is submitted
if (isset($_POST['delete'])) {
    // Remove the student from the session array
    unset($_SESSION['students'][$studentIndex]);
    $_SESSION['students'] = array_values($_SESSION['students']); // Reindex the array after deletion
    
    // Redirect back to register.php after deletion
    header('Location: register.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Delete a Student</h2>
    
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    
    <div class="card mt-4 p-4">
        <p>Are you sure you want to delete the following student record?</p>
        <ul>
            <li><strong>Student ID:</strong> <?php echo htmlspecialchars($student['id']); ?></li>
            <li><strong>First Name:</strong> <?php echo htmlspecialchars($student['first_name']); ?></li>
            <li><strong>Last Name:</strong> <?php echo htmlspecialchars($student['last_name']); ?></li>
        </ul>
        <form action="delete.php?index=<?php echo $studentIndex; ?>" method="POST" class="mt-3">
            <!-- Cancel button with direct link to register.php -->
            <button type="button" onclick="window.location.href='register.php';" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete Student Record</button>
        </form>
    </div>
</div>

</body>
</html>
