<?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Retrieve form data and sanitize
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];  // Fixed the name to match the form

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Validate password length
    if (strlen($password) < 6) {
        die('Password must be at least 6 characters.');
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create connection to the database
    $conn = new mysqli('localhost', 'root', '', 'list');

    // Check for connection errors
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        // Prepare SQL statement with correctly spelled 'email' and 'confirm_password' fields
        $stmt = $conn->prepare("INSERT INTO registration (name, email, password, confirm_password) VALUES (?, ?, ?, ?)");

        // Check if preparation was successful
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        // Bind the parameters and execute the statement
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $hashed_password); // Store hashed passwords

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
?>
