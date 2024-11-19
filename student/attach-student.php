<?php
session_start();

// Initialize error message
$errorMessage = '';

// Fetch the student info based on ID
$studentID = $_GET['id'] ?? null;
$student = null;
if ($studentID) {
    // Fetch student data from session
    foreach ($_SESSION['students'] as $s) {
        if ($s['id'] === $studentID) {
            $student = $s;
            // Ensure that the 'subjects' key is set for the student
            if (!isset($student['subjects'])) {
                $student['subjects'] = [];  // Initialize subjects as an empty array if not set
            }
            break;
        }
    }
}

// Handle form submission to attach subjects
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['subjects'])) {
        $selectedSubjects = $_POST['subjects']; // Array of selected subject IDs

        if (empty($selectedSubjects)) {
            // Display error if no subjects are selected
            $errorMessage = 'System Errors: At least one subject should be selected';
        } else {
            // Attach the subjects to the student in session
            foreach ($_SESSION['students'] as $key => $s) {
                if ($s['id'] === $studentID) {
                    // Ensure the 'subjects' key exists for the student before using array_merge
                    if (!isset($_SESSION['students'][$key]['subjects'])) {
                        $_SESSION['students'][$key]['subjects'] = [];  // Initialize subjects as empty array
                    }
                    $_SESSION['students'][$key]['subjects'] = array_merge($_SESSION['students'][$key]['subjects'], $selectedSubjects);  // Add selected subjects
                    break;
                }
            }

            header("Location: attach-student.php?id=$studentID"); // Redirect back to prevent re-submission
            exit;
        }
    } else {
        // Handle the case where no subjects are selected
        $errorMessage = 'System Errors: At least one subject should be selected';
    }
}

// Handle subject removal
if (isset($_GET['remove_subject']) && isset($_GET['subject_code'])) {
    $subjectCode = $_GET['subject_code'];
    // Remove the subject from the student's attached subjects
    foreach ($_SESSION['students'] as $key => $s) {
        if ($s['id'] === $studentID) {
            $_SESSION['students'][$key]['subjects'] = array_diff($_SESSION['students'][$key]['subjects'], [$subjectCode]);
            break;
        }
    }
    header("Location: attach-student.php?id=$studentID"); // Redirect after removal
    exit;
}

// Fetch the student's attached subjects
$attachedSubjects = $student ? $student['subjects'] : [];

// Available subjects to attach
$subjectNames = [
    "1001" => "English",
    "1002" => "Mathematics",
    "1003" => "Science"
];

// Filter the subjects that are not yet attached
$availableSubjects = array_diff(array_keys($subjectNames), $attachedSubjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attach Subject to Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Attach Subject to Student</h2>
    
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
        </ol>
    </nav>
    
    <!-- Error Message if No Subject Selected -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <!-- Selected Student Information -->
    <?php if ($student): ?>
    <div class="card mt-4 p-4">
        <h5>Selected Student Information</h5>
        <ul style="list-style-type: none; padding-left: 20px;">
            <li>• <strong>Student ID:</strong> <?php echo $student['id']; ?></li>
            <li>• <strong>Name:</strong> <?php echo $student['first_name'] . ' ' . $student['last_name']; ?></li>
        </ul>
        
        <!-- Horizontal Divider Line -->
        <hr>

        <!-- Subject Selection Checkboxes -->
        <?php if (empty($availableSubjects)): ?>
            <p>No subjects available to attach.</p>
        <?php else: ?>
            <form action="attach-student.php?id=<?php echo $studentID; ?>" method="POST">
                <div class="form-group">
                    <?php foreach ($availableSubjects as $subjectCode): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="<?php echo $subjectCode; ?>" id="subject<?php echo $subjectCode; ?>">
                            <label class="form-check-label" for="subject<?php echo $subjectCode; ?>">
                                <?php echo $subjectCode . " - " . $subjectNames[$subjectCode]; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">Attach Subjects</button>
            </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <!-- Subject List -->
    <div class="card mt-4 p-4">
        <h5>Attached Subjects</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($attachedSubjects)): ?>
                    <tr><td colspan="3" class="text-center">No subject attached.</td></tr>
                <?php else: ?>
                    <?php foreach ($attachedSubjects as $subjectCode): ?>
                        <tr>
                            <td><?php echo $subjectCode; ?></td>
                            <td><?php echo isset($subjectNames[$subjectCode]) ? $subjectNames[$subjectCode] : "Unknown Subject"; ?></td>
                            <td>
                                <!-- Detach Subject Button (Bootstrap btn-danger style) -->
                                <a href="attach-student.php?id=<?php echo $studentID; ?>&remove_subject=true&subject_code=<?php echo $subjectCode; ?>" 
                                   class="btn btn-danger btn-sm">
                                   Detach Subject
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
