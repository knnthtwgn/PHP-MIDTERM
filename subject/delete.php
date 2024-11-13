<?php
session_start(); // Start the session to access stored subjects

// Check if the 'index' parameter exists in the URL and is valid
if (isset($_GET['index']) && isset($_SESSION['subjects'][$_GET['index']])) {
    $subjectIndex = $_GET['index']; // Get the index of the subject to delete
    $subject = $_SESSION['subjects'][$subjectIndex]; // Retrieve the subject details
} else {
    // If no valid index is found, redirect back to the subject list (add_subject.php)
    header('Location: add.php');
    exit;
}

// Handle the subject deletion when the form is submitted
if (isset($_POST['delete'])) {
    // Remove the subject from the session array
    unset($_SESSION['subjects'][$subjectIndex]);
    $_SESSION['subjects'] = array_values($_SESSION['subjects']); // Reindex the array after deletion
    
    // Redirect back to add_subject.php after deletion
    header('Location: add.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subject</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Delete Subject</h2>
    
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
        </ol>
    </nav>
    
    <div class="card mt-4 p-4">
        <p>Are you sure you want to delete the following subject record?</p>
        <ul>
            <li><strong>Subject Code:</strong> <?php echo htmlspecialchars($subject['subjectCode']); ?></li>
            <li><strong>Subject Name:</strong> <?php echo htmlspecialchars($subject['subjectName']); ?></li>
        </ul>
        <form action="delete.php?index=<?php echo $subjectIndex; ?>" method="POST" class="mt-3">
            <!-- Cancel button with direct link to add.php -->
            <button type="button" onclick="window.location.href='add.php';" class="btn btn-secondary">Cancel</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete Subject Record</button>
        </form>
    </div>
</div>

</body>
</html>
