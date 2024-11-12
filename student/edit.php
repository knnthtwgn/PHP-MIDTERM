<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Student Information</h2>
        
        <!-- Form for editing student information -->
        <form method="POST" action="update-student.php">
            <div class="mb-3">
                <label for="studentName" class="form-label">Student Name</label>
                <input type="text" id="studentName" name="studentName" class="form-control" value="John Doe">
            </div>

            <div class="mb-3">
                <label for="studentEmail" class="form-label">Student Email</label>
                <input type="email" id="studentEmail" name="studentEmail" class="form-control" value="johndoe@example.com">
            </div>

            <div class="mb-3">
                <label for="assignedSubject" class="form-label">Assigned Subject</label>
                <select id="assignedSubject" name="assignedSubject" class="form-select">
                    <option value="1">Mathematics</option>
                    <option value="2">Science</option>
                    <option value="3">History</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
