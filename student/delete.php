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
        
        <!-- Form for deleting a student -->
        <form>
            <div class="mb-3">
                <label for="student" class="form-label">Select Student to Delete</label>
                <select id="student" class="form-select">
                    <option value="">-- Select Student --</option>
                    <option value="1">John Doe</option>
                    <option value="2">Jane Smith</option>
                    <option value="3">Alice Johnson</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-danger">Delete Student</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
