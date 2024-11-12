<?php
// delete.php - located in the "subject" folder
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subjectId'])) {
    $subjectId = $_POST['subjectId'];
    // Code to delete the subject from the database goes here

    // Redirect after deletion (change URL as needed)
    header("Location: subject-list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Delete Subject</h2>
        <form method="POST" action="">
            <input type="hidden" name="subjectId" value="<?php echo htmlspecialchars($_GET['subjectId'] ?? ''); ?>">
            <p>Are you sure you want to delete this subject?</p>
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="subject-list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
