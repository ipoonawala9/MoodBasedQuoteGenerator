<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "Please <a href='login.html'>login</a> to view saved quotes.";
  exit();
}

$conn = new mysqli("localhost", "root", "", "moodquotes");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT quote, mood FROM favorites WHERE user_id = $user_id");

echo "<h2>{$_SESSION['name']}'s Favorite Quotes</h2>";
if ($result->num_rows > 0) {
  echo "<ul>";
  while ($row = $result->fetch_assoc()) {
    echo "<li><b>[{$row['mood']}]</b> {$row['quote']}</li>";
  }
  echo "</ul>";
} else {
  echo "<p>No saved quotes yet.</p>";
}

$conn->close();
?>
