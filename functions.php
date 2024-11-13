<?php

// Sample users data
function getUsers() {
    return [
        ["email" => "user1@gmail.com", "password" => "user1"],
        ["email" => "user2@gmail.com", "password" => "user2"],
        ["email" => "user3@gmail.com", "password" => "user3"],
        ["email" => "user4@gmail.com", "password" => "user4"],
        ["email" => "user5@gmail.com", "password" => "user5"]
    ];
}

// Validate login credentials
function validateLoginCredentials($email, $password) {
    $errors = [];

    // Check for empty fields and email format
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    return $errors;
}

// Check if the email and password match any user in the list
function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

// Display errors as a bulleted list
function displayErrors($errors) {
    $output = "<ul class='mb-0'>";
    foreach ($errors as $error) {
        $output .= "<li>• " . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}

?>
