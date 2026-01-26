<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>My Website</title>

  <!-- Multiple unnecessary fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;700;800;900&family=Open+Sans:wght@300;400;600;700;800&family=Lato:wght@100;300;400;700;900&display=block"
    rel="stylesheet">

  <!-- Render-blocking CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Welcome to My Website</h1>
    <nav>
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>About Our Company</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat.</p>

      <!-- Large unoptimized image without alt text -->
      <img src="large-image.jpg">

      <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>
    </section>

    <section>
      <h2>Our Services</h2>
      <div class="services">
        <div class="service-card">
          <h3>Web Design</h3>
          <p>Beautiful and modern website designs.</p>
        </div>
        <div class="service-card">
          <h3>Development</h3>
          <p>Fast and reliable web development.</p>
        </div>
        <div class="service-card">
          <h3>SEO</h3>
          <p>Optimize your website for search engines.</p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 My Website. All rights reserved.</p>
  </footer>
</body>

</html>
