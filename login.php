<?php
session_start();

$conn = new mysqli("localhost", "root", "", "moodquotes");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($conn->real_escape_string($_POST["email"]));
    $password = $_POST["password"];

    // Basic Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // If no validation errors
    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // ✅ Save user session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];

                echo "<h3>Login successful! Welcome, {$user['name']}!</h3>";
                echo "<p><a href='mood.html'>Go to Mood Generator</a></p>";

                // Optional: Redirect instead of showing message
                header("Location: mood.html");
                exit();
            } else {
                echo "<h3>Incorrect password.</h3><a href='login.html'>Try Again</a>";
            }
        } else {
            echo "<h3>Email not registered.</h3><a href='register.html'>Register Now</a>";
        }
    } else {
        echo "<h3>Login Errors:</h3><ul>";
        foreach ($errors as $e) {
            echo "<li>$e</li>";
        }
        echo "</ul><a href='login.html'>Try again</a>";
    }
}

$conn->close();
?>
