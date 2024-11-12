<?php
session_start();

$pageTitle = "Log In";

include("header.php");
include('functions.php');

// Redirect if user is already logged in
if (!empty($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$notification = null;

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate email and password
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If no validation errors, attempt login
    if (empty($errors)) {
        $users = getUsers();
        if (checkLoginCredentials($email, $password, $users)) {
            $_SESSION['email'] = $email;
            $_SESSION['current_page'] = 'dashboard.php';
            header("Location: dashboard.php");
            exit;
        } else {
            $notification = 'Invalid email or password.';
        }
    }
}
?>

<main>
    <div class="container">
        <?php if (!empty($errors) || !empty($notification)): ?>
            <div class="col-md-6 mb-3 mx-auto">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>System Errors:</strong>
                    <ul>
                        <?php if (!empty($notification)) echo "<li>" . htmlspecialchars($notification) . "</li>"; ?>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Close button (X) -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="p-4">
                <div class="card col-4 mx-auto">
                    <div class="card-header fs-3 fw-bold">Login</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include("footer.php"); ?>
