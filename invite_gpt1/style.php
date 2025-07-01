body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background: #fefefe;
  color: #333;
  scroll-behavior: smooth;
}

.hero {
  background: url('assets/couple.jpg') no-repeat center/cover;
  height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.overlay {
  background-color: rgba(0,0,0,0.5);
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  color: white;
}

.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
}

.hero-names {
  font-size: 3.5rem;
  font-weight: bold;
  margin: 0.5rem 0;
}

.hero-date {
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
}

.btn-primary {
  background-color: #ff5c8d;
  color: white;
  padding: 12px 24px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.btn-primary:hover {
  background-color: #e24a79;
}

.navbar {
  background: white;
  padding: 10px 20px;
  position: sticky;
  top: 0;
  z-index: 999;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.navbar ul {
  display: flex;
  list-style: none;
  justify-content: center;
  gap: 30px;
  padding: 0;
}

.navbar a {
  text-decoration: none;
  color: #444;
  font-weight: 600;
}

section {
  padding: 60px 20px;
  max-width: 900px;
  margin: auto;
  text-align: center;
}

.event-boxes {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.event-box {
  background: #fff5f9;
  border-radius: 12px;
  padding: 20px;
  flex: 1 1 300px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.gallery-images {
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;
}

.gallery-images img {
  width: 250px;
  border-radius: 12px;
  transition: transform 0.3s;
}

.gallery-images img:hover {
  transform: scale(1.05);
}

form input, form button {
  padding: 10px;
  margin: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

form button {
  background-color: #ff5c8d;
  color: white;
  border: none;
  cursor: pointer;
}

footer {
  background-color: #fafafa;
  padding: 20px;
  font-size: 0.9rem;
}
