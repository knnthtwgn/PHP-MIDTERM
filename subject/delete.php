<?php
// Include necessary files (e.g., database connection, functions)
include('../config.php'); // Assuming you have a config file for DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['studentId'];

    // Query to delete student
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);

    // Redirect to a page after deletion
    header('Location: student-list.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Delete Student</h2>

        <!-- Deletion Form -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="studentId" class="form-label">Student ID</label>
                <input type="number" id="studentId" name="studentId" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Delete Student</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
