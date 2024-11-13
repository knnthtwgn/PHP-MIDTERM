<?php
session_start();

// Initialize error message
$errorMessage = '';

// Fetch student ID and subject code from URL parameters
$studentID = $_GET['id'] ?? null;
$subjectCode = $_GET['subject_code'] ?? null;

if ($studentID && $subjectCode) {
    // Find the student in the session
    foreach ($_SESSION['students'] as $key => $s) {
        if ($s['id'] === $studentID) {
            // Remove the subject from the student's subjects array
            $_SESSION['students'][$key]['subjects'] = array_diff($_SESSION['students'][$key]['subjects'], [$subjectCode]);
            // Redirect back to the attach-student.php page after removal
            header("Location: attach-student.php?id=$studentID");
            exit;
        }
    }

    $errorMessage = 'Student or Subject not found.';
} else {
    $errorMessage = 'Invalid request.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detach Subject from Student</title>
</head>
<body>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
</body>
</html>
