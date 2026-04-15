<?php
$conn = new mysqli("localhost", "root", "", "moodquotes");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($conn->real_escape_string($_POST["name"]));
    $email = trim($conn->real_escape_string($_POST["email"]));
    $password = $_POST["password"];

    if (empty($name)) $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $checkQuery = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            echo "<h3>Email already registered. Try logging in.</h3>";
            echo "<a href='login.html'>Login Here</a>";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
            if ($conn->query($sql)) {
                echo "<h3>Registration successful!</h3>";
                echo "<a href='login.html'>Login now</a>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "<h3>Errors:</h3><ul>";
        foreach ($errors as $e) echo "<li>$e</li>";
        echo "</ul><a href='register.html'>Go back</a>";
    }
}
$conn->close();
?>
