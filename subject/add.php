<?php
session_start(); // Start the session to store the subjects

$pageTitle = "Add Subject"; // Set the page title dynamically for the browser tab
$pageHeader = "Add a New Subject"; // Set the page header dynamically for the page content

// Initialize errors and subjects
$errors = [];
if (!isset($_SESSION['subjects'])) {
    $_SESSION['subjects'] = []; // Initialize an empty subjects array in session
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['subjectCode'])) {
        $errors[] = 'Subject Code is required';
    }
    if (empty($_POST['subjectName'])) {
        $errors[] = 'Subject Name is required';
    }

    // Check for duplicate Subject Code
    foreach ($_SESSION['subjects'] as $subject) {
        if ($subject['subjectCode'] === $_POST['subjectCode']) {
            $errors[] = 'Subject Code already exists';
            break;
        }
    }

    // Check for duplicate Subject Name
    foreach ($_SESSION['subjects'] as $subject) {
        if ($subject['subjectName'] === $_POST['subjectName']) {
            $errors[] = 'Subject Name already exists';
            break;
        }
    }

    // If no errors, add the subject to the session
    if (empty($errors)) {
        $subject = [
            'subjectCode' => $_POST['subjectCode'],
            'subjectName' => $_POST['subjectName']
        ];
        $_SESSION['subjects'][] = $subject; // Add subject to the session array
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Adjust the width of the container */
        .container-custom {
            max-width: 800px; /* Limit the width to 800px, or adjust to your preference */
            margin: 0 auto; /* Center the container */
        }

        /* Custom hover effect for buttons */
        .btn-edit:hover {
            background-color: green;
            color: white;
        }

        .btn-delete:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-custom mt-5">
        <h2 class="mb-4"><?php echo htmlspecialchars($pageHeader); ?></h2> <!-- Header with "Add a New Subject" -->

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($pageTitle); ?></li> <!-- Breadcrumb with "Add Subject" -->
            </ol>
        </nav>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>System Errors:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card mt-3">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="subjectCode" class="form-label">Subject Code</label>
                        <input type="text" id="subjectCode" name="subjectCode" class="form-control" placeholder="Enter Subject Code" value="<?php echo isset($_POST['subjectCode']) ? htmlspecialchars($_POST['subjectCode']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <input type="text" id="subjectName" name="subjectName" class="form-control" placeholder="Enter Subject Name" value="<?php echo isset($_POST['subjectName']) ? htmlspecialchars($_POST['subjectName']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </form>
            </div>
        </div>

        <!-- Subject List Container (inside a container with a border) -->
        <div class="container mt-4" style="border: 1px solid #ccc; padding: 20px; margin-bottom: 100px;">
            <h4>Subject List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($_SESSION['subjects'])): ?>
                        <?php foreach ($_SESSION['subjects'] as $index => $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['subjectCode']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subjectName']); ?></td>
                                <td>
                                    <!-- Edit and Delete buttons -->
                                    <a href="edit.php?index=<?php echo $index; ?>" class="btn btn-success btn-edit">Edit</a>
                                    <a href="delete.php?index=<?php echo $index; ?>" class="btn btn-danger btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No subject found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php
        // Handle delete action
        if (isset($_GET['delete'])) {
            $indexToDelete = $_GET['delete'];
            if (isset($_SESSION['subjects'][$indexToDelete])) {
                unset($_SESSION['subjects'][$indexToDelete]);
                $_SESSION['subjects'] = array_values($_SESSION['subjects']); // Re-index array after deletion
            }
            // Redirect back to the same page to avoid re-submitting the form after refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
