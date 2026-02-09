const quotes = {
  happy: [
    "Happiness is not something ready-made. It comes from your own actions.",
    "The purpose of our lives is to be happy.",
    "Happiness is a warm puppy.",
    "Do more of what makes you happy.",
    "Happiness is only real when shared."
  ],
  sad: [
    "Tears come from the heart and not from the brain.",
    "Every human walks around with a certain kind of sadness.",
    "Sadness flies away on the wings of time.",
    "Even the darkest night will end and the sun will rise.",
    "Behind every sweet smile, there is a bitter sadness that no one can see and feel."
  ],
  stressed: [
    "Almost everything will work again if you unplug it for a few minutes, including you.",
    "Give yourself a break. You’re doing better than you think.",
    "Breathe. It’s just a bad day, not a bad life.",
    "Stress is caused by being ‘here’ but wanting to be ‘there’.",
    "In the middle of chaos lies opportunity."
  ],
  motivated: [
    "Don’t watch the clock; do what it does. Keep going.",
    "Push yourself, because no one else is going to do it for you.",
    "Success is what comes after you stop making excuses.",
    "Your limitation—it’s only your imagination.",
    "Dream it. Wish it. Do it."
  ]
};

  
  const images = {
    happy: "https://images.unsplash.com/photo-1540206395-68808572332f?auto=format&fit=crop&w=1350&q=80",
    sad: "https://images.unsplash.com/photo-1483794344563-d27a8d18014e?auto=format&fit=crop&w=1350&q=80",
    stressed: "https://images.unsplash.com/photo-1506806732259-39c2d0268443?auto=format&fit=crop&w=1350&q=80",
    motivated: "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1350&q=80"
  };
  
  const audioTracks = {
    happy: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3",
    sad: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3",
    stressed: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3",
    motivated: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3"
  };
  
  let quoteIndex = 0;
  
  async function showQuote() {
    const mood = document.getElementById("moodSelect").value;
    localStorage.setItem("lastMood", mood);
  
    const quoteEl = document.getElementById("quote");
    try {
      const response = await fetch(`https://api.quotable.io/random?tags=${mood}`);
      const data = await response.json();
      quoteEl.innerText = data.content || quotes[mood][0];
    } catch (error) {
      console.warn("API failed. Using fallback quote.");
      quoteEl.innerText = quotes[mood][0];
    }
  
    // Change background
    document.body.style.backgroundImage = `url('${images[mood]}')`;
  
    // Change audio
    const audio = document.getElementById("bgAudio");
    audio.src = audioTracks[mood];
    audio.load(); // Important
    audio.play().catch((e) => {
      console.log("Autoplay blocked, will play after interaction.");
    });
  }
  
  function nextQuote() {
    const mood = document.getElementById("moodSelect").value;
    quoteIndex = (quoteIndex + 1) % quotes[mood].length;
    document.getElementById("quote").innerText = quotes[mood][quoteIndex];
  }
  
  // Auto-load mood and quote
  window.onload = () => {
    const lastMood = localStorage.getItem("lastMood");
    if (lastMood) {
      document.getElementById("moodSelect").value = lastMood;
      showQuote();
    }
  };
  