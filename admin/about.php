<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Biiroo Barnootaa Bulchiinsa Magaalaa Maayaa</title>
    
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

        /* Main Section */
        .main-section {
            padding: 50px;
            text-align: center;
        }

        .about-features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .feature-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 280px;
            margin: 20px;
            text-align: center;
        }

        .feature-box h3 {
            color: #0056b3;
            margin-bottom: 15px;
        }

        .feature-box p {
            line-height: 1.6;
        }

        .about-message {
            background: #e9ecef;
            padding: 40px;
            margin-top: 50px;
            border-radius: 10px;
        }

        .about-message h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        .about-message p {
            line-height: 1.8;
            text-align: left;
        }

        /* Team Leaders */
        .team-leaders {
            padding: 50px;
            text-align: center;
            background: #fff;
            margin-top: 50px;
        }

        .team-leaders h2 {
            color: #0056b3;
            margin-bottom: 30px;
        }

        .leader-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .leader-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px;
            width: 200px;
        }

        .leader-box h4 {
            color: #007bff;
            margin-top: 10px;
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
        .social-links a{
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(255,255,255,0.2);
            margin:0 10px 10px 0;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            color: #ffffff;
        }
        .social-links a:hover{
            color: #24262b;
            background-color: #ffffff;
        }
    </style>
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
            <li><a href="download.php">Downloadable</a></li>
            <li><a href="info.php">Information</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <section class="main-section">
        <h2>About Us</h2>
        <div class="about-features">
            <div class="feature-box">
                <h3>Skilled Teachers</h3>
                <p>Our experienced and certified instructors are dedicated to providing top-quality education and guidance.</p>
            </div>
            <div class="feature-box">
                <h3>Adults Education</h3>
                <p>We offer flexible and comprehensive education programs tailored to help adults continue learning and developing new skills.</p>
            </div>
            <div class="feature-box">
                <h3>Schools Standard</h3>
                <p>Our curriculum meets national and international education standards, ensuring quality learning for all students.</p>
            </div>
            <div class="feature-box">
                <h3>Book Library</h3>
                <p>Our extensive library offers a vast collection of books and resources to support students' learning and research.</p>
            </div>
        </div>
        

        <div class="about-message">
            <h2>Welcome to Maya City Education Bureau</h2>
            <p>We are honored to have you join us. We are a vital force in shaping the future of education in our capital city. As a well-respected organization, the MCER team is at the forefront, ensuring that every student in Maya City receives a world-class learning experience.</p>
        </div>

        <div class="team-leaders">

            <h2>TEAM LEADERS</h2>
            <div class="leader-grid">
                <div class="leader-box" >
                    <img src="image/logo.jpg" alt="">
                    <h4>Tariku Zewdu</h4>
                </div>
                <div class="leader-box">
                    <h4>Aliyyi Hussien</h4>
                </div>
                <div class="leader-box">
                    <h4>Sara Kedir</h4>
                </div>
                <div class="leader-box">
                    <h4>Ahmed Aliyyi</h4>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="about.php" style="color: white;">About Us</a></p>
                <p><a href="contact.php" style="color: white;">Contact Us</a></p>
                <p><a href="#" style="color: white;">Privacy Policy</a></p>
                <p><a href="#" style="color: white;">Term Condition</a></p>
                <p><a href="#" style="color: white;">FAQs & Help</a></p>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Ethiopia 3200 Maya City, Oromia</p>
                <p>Phone: 0939911345</p>
                <p>Email: mayaedu@info.com</p>
            </div>