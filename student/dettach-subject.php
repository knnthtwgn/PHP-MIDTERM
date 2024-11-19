<?php
session_start();

// Initialize error message
$errorMessage = '';

// Fetch student ID and subject code from URL parameters
$studentID = $_GET['id'] ?? null;
$subjectCode = $_GET['subject_code'] ?? null;
$student = null;
$subjectName = '';

// Fetch the student data from session if both student ID and subject code are provided
if ($studentID && $subjectCode) {
    // Find the student in the session
    foreach ($_SESSION['students'] as $s) {
        if ($s['id'] === $studentID) {
            $student = $s;
            break;
        }
    }

    // Find the subject details
    if ($student && isset($_SESSION['subjects'])) {
        foreach ($_SESSION['subjects'] as $subject) {
            if ($subject['subjectCode'] === $subjectCode) {
                $subjectName = $subject['subjectName'];
                break;
            }
        }
    }

    if (!$student) {
        $errorMessage = 'Student not found.';
    } elseif (!$subjectName) {
        $errorMessage = 'Subject not found.';
    }
} else {
    $errorMessage = 'Invalid request.';
}

// Handle form submission to detach the subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['detach'])) {
    if ($studentID && $subjectCode) {
        // Find the student and detach the subject
        foreach ($_SESSION['students'] as $key => $s) {
            if ($s['id'] === $studentID) {
                // Remove the subject from the student's subjects array
                $_SESSION['students'][$key]['subjects'] = array_values(array_diff($_SESSION['students'][$key]['subjects'], [$subjectCode]));
                // Redirect back to the attach-student.php page after removal
                header("Location: attach-student.php?id=$studentID");
                exit;
            }
        }
        $errorMessage = 'Student or Subject not found.';
    } else {
        $errorMessage = 'Invalid request.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detach Subject from Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Detach Subject from Student</h2>

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item"><a href="attach-student.php?id=<?php echo htmlspecialchars($studentID); ?>">Attach Subject to Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detach Subject</li>
        </ol>
    </nav>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php else: ?>
        <div class="card mt-4 p-4">
            <h5>Are you sure you want to detach this subject from this student's record?</h5>
            <ul style="list-style-type: none; padding-left: 20px;">
                <li>• <strong>Student ID:</strong> <?php echo htmlspecialchars($student['id']); ?></li>
                <li>• <strong>First Name:</strong> <?php echo htmlspecialchars($student['first_name']); ?></li>
                <li>• <strong>Last Name:</strong> <?php echo htmlspecialchars($student['last_name']); ?></li>
                <li>• <strong>Subject Code:</strong> <?php echo htmlspecialchars($subjectCode); ?></li>
                <li>• <strong>Subject Name:</strong> <?php echo htmlspecialchars($subjectName); ?></li>
            </ul>
            <hr>
            <div class="mt-3">
                <!-- Form to handle detachment -->
                <form method="POST" action="">
                    <a href="attach-student.php?id=<?php echo htmlspecialchars($studentID); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="detach" class="btn btn-danger ml-2">Dettach Subject from Student</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
