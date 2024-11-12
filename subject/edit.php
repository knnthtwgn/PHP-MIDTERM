<?php
// edit.php - located in the "subject" folder

// Fetch subject data by ID (assume a function getSubjectById exists)
$subjectId = $_GET['subjectId'] ?? '';
$subject = getSubjectById($subjectId); // Replace with actual function to fetch data

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subjectId'])) {
    $subjectId = $_POST['subjectId'];
    $subjectName = $_POST['subjectName'];
    $subjectCode = $_POST['subjectCode'];
    $subjectDescription = $_POST['subjectDescription'];

    // Code to update the subject in the database goes here

    header("Location: subject-list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Subject</h2>
        <form method="POST" action="">
            <input type="hidden" name="subjectId" value="<?php echo htmlspecialchars($subject['id'] ?? ''); ?>">
            <div class="mb-3">
                <label for="subjectName" class="form-label">Subject Name</label>
                <input type="text" id="subjectName" name="subjectName" class="form-control" value="<?php echo htmlspecialchars($subject['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="subjectCode" class="form-label">Subject Code</label>
                <input type="text" id="subjectCode" name="subjectCode" class="form-control" value="<?php echo htmlspecialchars($subject['code'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="subjectDescription" class="form-label">Subject Description</label>
                <textarea id="subjectDescription" name="subjectDescription" class="form-control" rows="3" required><?php echo htmlspecialchars($subject['description'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
