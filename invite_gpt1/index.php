<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Andi & Bunga Wedding Invitation</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      background: #fff5f8;
      overflow-x: hidden;
      color: #333;
      scroll-behavior: smooth;
    }
    header {
      height: 100vh;
      background: url('https://images.unsplash.com/photo-1526045478516-99145907023c?auto=format&fit=crop&w=1950&q=80') no-repeat center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      text-align: center;
    }
    header::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }
    .hero-text {
      position: relative;
      color: white;
      z-index: 1;
    }
    .hero-text h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
    }
    .hero-text h2 {
      font-size: 2rem;
      margin-top: 0.5rem;
    }
    .hero-text p {
      margin-top: 1rem;
      font-size: 1.1rem;
    }
    .scroll-down {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      color: white;
      animation: bounce 2s infinite;
    }
    @keyframes bounce {
      0%, 100% { transform: translate(-50%, 0); }
      50% { transform: translate(-50%, -10px); }
    }
    section {
      padding: 100px 20px;
      text-align: center;
    }
    .couple, .love-story, .photo-carousel, .gift, .quotes, .testimonials {
      max-width: 900px;
      margin: auto;
    }
    .couple img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #ff5c8d;
    }
    .couple h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
    }
    .timeline-box {
      background: #fff0f5;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      width: 250px;
      margin: 10px;
    }
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      max-width: 1000px;
      margin: auto;
    }
    .rsvp input, .rsvp textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .rsvp button {
      padding: 10px 20px;
      background: #ff5c8d;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .countdown span {
      font-size: 2rem;
      margin: 0 10px;
      display: inline-block;
    }
    .quotes blockquote {
      font-style: italic;
      font-size: 1.3rem;
    }
    .gift p {
      font-size: 1rem;
    }
    footer {
      background: #fafafa;
      padding: 40px 20px;
      text-align: center;
      font-size: 0.9rem;
    }
    .falling-flower {
      position: fixed;
      top: -50px;
      width: 30px;
      height: 30px;
      z-index: 999;
      pointer-events: none;
      animation: fall linear infinite;
    }
    @keyframes fall {
      to {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <audio autoplay loop>
    <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>
  <header>
    <div class="hero-text" data-aos="fade-up">
      <h1>Andi & Bunga</h1>
      <h2>Wedding Invitation</h2>
      <p>25 April 2025</p>
    </div>
    <div class="scroll-down">▼</div>
  </header>

  <section class="couple" data-aos="fade-up">
    <h2>Meet the Couple</h2>
    <p>Kisah cinta yang bermula dari pertemuan tak terduga hingga akhirnya kami memutuskan untuk bersatu.</p>
    <!-- Add couple photos & names here -->
  </section>

  <section class="love-story" data-aos="fade-up">
    <h2>Our Love Story</h2>
    <p>Cerita perjalanan kami dari awal bertemu, menjadi sahabat, hingga memutuskan untuk menikah.</p>
  </section>

  <section class="photo-carousel" data-aos="fade-up">
    <h2>Memories</h2>
    <div class="gallery">
      <!-- Add photos -->
    </div>
  </section>

  <section class="quotes" data-aos="fade-up">
    <h2>Quote</h2>
    <blockquote>"Love is not about how many days, months, or years you've been together. Love is about how much you love each other every single day."</blockquote>
  </section>

  <section class="gift" data-aos="fade-up">
    <h2>Wedding Gift</h2>
    <p>Doa restu Anda merupakan hadiah terbaik, namun jika ingin memberikan kado, silakan transfer ke rekening berikut: <strong>123456789 (Bank Bunga)</strong></p>
  </section>

  <section class="rsvp" data-aos="fade-up">
    <h2>RSVP</h2>
    <form>
      <input type="text" placeholder="Nama Anda" required />
      <textarea placeholder="Ucapan & Doa"></textarea>
      <button type="submit">Kirim</button>
    </form>
  </section>

  <footer>
    <p>Terima kasih atas doa dan kehadiran Anda.</p>
  </footer>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000 });
    const totalFlowers = 30;
    const flowerEmoji = "🌸";
    for (let i = 0; i < totalFlowers; i++) {
      const flower = document.createElement("div");
      flower.classList.add("falling-flower");
      flower.style.left = Math.random() * 100 + "vw";
      flower.style.animationDuration = (5 + Math.random() * 5) + "s";
      flower.style.fontSize = (20 + Math.random() * 10) + "px";
      flower.innerHTML = flowerEmoji;
      document.body.appendChild(flower);
    }
  </script>
</body>
</html>