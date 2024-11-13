<?php
session_start(); // Start the session to store the subjects

// Check if the 'index' parameter exists for the subject to be edited
if (isset($_GET['index']) && isset($_SESSION['subjects'][$_GET['index']])) {
    $subjectIndex = $_GET['index'];
    $subject = $_SESSION['subjects'][$subjectIndex];
} else {
    // Redirect back to the subject list if no subject index is provided or invalid
    header('Location: add.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['subjectName'])) {
        $errors[] = 'Subject name is required';
    } else {
        // Update the subject details in session
        $_SESSION['subjects'][$subjectIndex]['subjectName'] = $_POST['subjectName'];
        // Redirect back to add.php after updating
        header('Location: add.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container border p-4 mt-5">
    <h2>Edit Subject</h2>
    
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li> <!-- Link back to add.php -->
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <!-- Error Messages (if any) -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>System Errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="mt-4 border p-4">
        <div class="form-group">
            <label for="subjectID">Subject ID</label>
            <!-- Disable the subject ID input field -->
            <input type="text" id="subjectID" name="subjectID" class="form-control" value="<?php echo htmlspecialchars($subject['subjectCode']); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="subjectName">Subject Name</label>
            <input type="text" id="subjectName" name="subjectName" class="form-control" value="<?php echo htmlspecialchars($subject['subjectName']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Subject</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
