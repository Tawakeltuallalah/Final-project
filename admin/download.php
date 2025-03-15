<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biiroo Barnootaa Bulchiinsa Magaalaa Maayaa</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 10px 20px;
            border-bottom: 4px solid #0056b3;
        }

        .header .logo {
            width: 120px; /* Adjust as needed */
            margin-left: 60px;
             
        }

        .header-text {
            text-align: left;
            flex-grow: 1;
            margin-left: 20px;
        }

        .header-text h1 {
            color: #0056b3;
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }

        .header-text h2 {
            color: #007bff;
            font-size: 20px;
            margin: 0;
        }

        /* Language Selector */
        .language-select {
            margin-right: 20px;
        }

        select {
            padding: 5px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #0056b3;
        }

        /* Navigation */
        nav {
            background: #0056b3;
            padding: 10px 0;
            text-align: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

    
        /* Footer */
        .footer {
            background: #002b5e;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 10px;
        }

        .footer-section {
            flex: 1;
            margin: 10px;
        }

        .footer-section h3 {
            color: #ffd700;
        }

        .newsletter input {
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-top: 10px;
        }

        .newsletter button {
            padding: 10px;
            background: #ffd700;
            border: none;
            color: black;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
    <script>
        function changeLanguage(lang) {
            // Implement language change logic here
            // For example, you can redirect to a different page or update content dynamically
            if (lang === 'or') {
                // Redirect or update content for Afaan Oromoo
                alert("Afaan Oromoo selected (Implementation needed)");
            } else if (lang === 'am') {
                // Redirect or update content for Amharic
                alert("Amharic selected (Implementation needed)");
            } else if (lang === 'en') {
                // Redirect or update content for English
                alert("English selected (Implementation needed)");
            }
        }
    </script>
</head>
<body>

    <header class="header">
        <img src="image/logo.jpg" alt="Education Bureau Logo" class="logo">
        <div class="header-text">
            <h1>Biiroo Barnootaa Bulchiinsa Magaalaa Maayaa</h1>
            <h2>City Government of Maya Bureau Of Education</h2>
        </div>
        <div class="language-select">
            <select onchange="changeLanguage(this.value)">
                <option value="or">Afaan Oromoo</option>
                <option value="am">Amharic</option>
                <option value="en">English</option>
            </select>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="downloads.php">Downloadable</a></li>
            <li><a href="info.php">Information</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

     

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="about.php" style="color: white;">About Us</a></p>
                <p><a href="contact.php" style="color: white;">Contact Us</a></p>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>3200 Maya City, Oromia, Ethiopia</p>
                <p>Phone: 0939911345</p>
                <p>Email: mayaedu@info.com</p>
            </div>
            <div class="footer-section">
                <h3>Gallery</h3>
                <img src="gallery1.jpg" alt="Gallery Image" width="50">
                <img src="gallery2.jpg" alt="Gallery Image" width="50">
                <img src="gallery2.jpg" alt="Gallery Image" width="50">
                <img src="gallery2.jpg" alt="Gallery Image" width="50">
            </div>
            <div class="footer-section newsletter">
                <h3>Newsletter</h3>
                <input type="email" placeholder="Your email">
                <button>Sign Up</button>
            </div>
        </div>
        <h1><marquee direction="left" style="font-family: serif; font-size: 50px;font-weight: bold;">&copy; 2025 Maya City Education Bureau. Designed by IT Students.</h1> 
    </footer>

</body>
</html>