<?php

function getUsers() {
    return [
        ["email" => "ken@gmail.com", "password" => "user1"],
        ["email" => "alice@gmail.com", "password" => "user2"],
        ["email" => "peter@gmail.com", "password" => "user3"],
        ["email" => "bob@gmail.com", "password" => "user4"],
        ["email" => "jake@gmail.com", "password" => "user5"]
    ];
}

function validateLoginCredentials($email, $password) {
    $errors = [];

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check if email exists
    if (empty($errors)) {
        $users = getUsers();
        $emailExists = false;

        // Check if the email is in the users list
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $emailExists = true;
                break;
            }
        }

        if (!$emailExists) {
            $errors[] = "Invalid Email.";
        }
    }

    return $errors;
}

?>
<?php
function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

function checkUserSessionIsActive() {
    if (isset($_SESSION['email']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
        header("Location: dashboard.php");
        exit;
    }
}
function guard() {
    if (empty($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
        
        header("Location: index.php"); 
        exit;
    }
}
function displayErrors($errors) {

    $output = "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}
?>