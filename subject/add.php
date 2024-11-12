<?php
// add.php - located in the "subject" folder
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add a New Subject</h2>
        <form method="POST" action="process-add.php">
            <div class="mb-3">
                <label for="subjectName" class="form-label">Subject Name</label>
                <input type="text" id="subjectName" name="subjectName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="subjectCode" class="form-label">Subject Code</label>
                <input type="text" id="subjectCode" name="subjectCode" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="subjectDescription" class="form-label">Subject Description</label>
                <textarea id="subjectDescription" name="subjectDescription" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Subject</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
