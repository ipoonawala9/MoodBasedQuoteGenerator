<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "You must be logged in to save quotes.";
  exit();
}

$conn = new mysqli("localhost", "root", "", "moodquotes");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$quote = $conn->real_escape_string($_POST['quote']);
$mood = $conn->real_escape_string($_POST['mood']);

if (empty($quote)) {
  echo "No quote to save.";
  exit();
}

$sql = "INSERT INTO favorites (user_id, quote, mood) VALUES ('$user_id', '$quote', '$mood')";
if ($conn->query($sql)) {
  echo "<h3>Quote saved successfully!</h3>";
  echo "<a href='favorites.php'>View My Favorites</a>";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
