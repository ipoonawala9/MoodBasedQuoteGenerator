<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mood-Based Quote Generator</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header>
    <h1>Mood-Based Quote Generator</h1>
    <p style="text-align:center;">Welcome, <strong><?php echo $_SESSION['name']; ?></strong> | <a href="logout.php">Logout</a></p>
  </header>

  <nav>
    <a href="index.html">Home</a>
    <a href="about.html">About</a>
    <a href="mood.php">Quotes</a>
    <a href="blog.html">Blog</a>
    <a href="contact.html">Contact</a>
  </nav>

  <main>
    <section class="mood-select">
      <label for="moodSelect">Select your mood:</label>
      <select id="moodSelect">
        <option value="happy">Happy</option>
        <option value="sad">Sad</option>
        <option value="stressed">Stressed</option>
        <option value="motivated">Motivated</option>
      </select>
      <button onclick="showQuote()">Show Quote</button>
    </section>

    <div id="quote" class="quote-display">
      Choose a mood and get inspired!
    </div>

    <!-- ✅ Save to Favorites Button -->
    <form method="POST" action="save_favorite.php">
      <input type="hidden" id="quoteText" name="quote" value="">
      <input type="hidden" id="moodValue" name="mood" value="">
      <button type="submit">💾 Save to Favorites</button>
    </form>

    <button onclick="nextQuote()" class="next-button">Next Quote</button>

    <audio id="bgAudio" loop></audio>
  </main>

  <footer>
    <p>&copy; 2025 MoodQuotes. Designed for emotional connection through code ❤️</p>
  </footer>

  <script src="script.js"></script>
  <script>
    // Update hidden inputs when a quote is shown
    function updateHiddenInputs(quote, mood) {
      document.getElementById("quoteText").value = quote;
      document.getElementById("moodValue").value = mood;
    }

    // Modify your showQuote() function in script.js to include:
    // updateHiddenInputs(displayedQuote, selectedMood);
  </script>
</body>
</html>
