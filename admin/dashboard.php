<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Bureau</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url("images2.jpg");
        }

        /* Header Styles */
        .header {
            background: #00FFFF;
            padding: 20px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        .header-content {
            display: flex;
            align-items: center;
        }

        .header img {
            height: 80px;
            margin-right: 20px;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            text-align: left; /* Align text to the left */
        }

        .header-text h1 {
            color: #0056b3;
            font-size: 28px; /* Increased font size */
            white-space: nowrap;
            margin-bottom: 5px; /* Added spacing */
        }

        .header-text h2 {
            color: #003366;
            font-size: 20px; /* Increased font size */
            white-space: nowrap;
        }

        /* Navigation Styles */
        .nav {
            background: green;
            padding: 15px 0;
            width: 100%;
        }

        .nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        .nav ul li {
            margin: 0 20px;
        }

        .nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s; /* Smooth color transition */
        }

        .nav ul li a:hover {
            color: #ddd; /* Lighter color on hover */
        }

        /* Welcome Banner Styles */
        .welcome-banner {
            width: 100%;
            height: 50vh;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .welcome-banner h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 40px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        /* Content Styles */
        .content {
            padding: 20px;
            text-align: center;
            flex-grow: 1; /* Allow content to take up remaining space */
        }

        /* Footer Styles */
        .footer {
            background-color: #24262b;
            padding: 70px 0;
            width: 100%;
            color: white;
        }

        .container {
            max-width: 1170px;
            margin: auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-col {
            width: 25%;
            padding: 0 15px;
        }

        .footer-col h4 {
            font-size: 18px;
            color: #ffffff;
            text-transform: capitalize;
            margin-bottom: 35px;
            font-weight: 500;
            position: relative;
        }

        .footer-col h4::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            background-color: #e91e63;
            height: 2px;
            box-sizing: border-box;
            width: 50px;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
        }

        .footer-col ul li:not(:last-child) {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 16px;
            text-transform: capitalize;
            color: #bbbbbb;
            text-decoration: none;
            font-weight: 300;
            display: block;
            transition: all 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: #ffffff;
            padding-left: 8px;
        }

        .footer-col .social-links a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0 10px 10px 0;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            color: #ffffff;
            transition: all 0.5s ease;
        }

        .footer-col .social-links a:hover {
            color: #24262b;
            background-color: #ffffff;
        }

        /* Responsive Styles */
        @media (max-width: 767px) {
            .footer-col {
                width: 50%;
                margin-bottom: 30px;
            }

            .header-text h1 {
                font-size: 24px;
            }

            .header-text h2 {
                font-size: 18px;
            }

            .welcome-banner h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 574px) {
            .footer-col {
                width: 100%;
            }

            .header {
                flex-direction: column;
                align-items: center;
            }

            .header-content{
                flex-direction: column;
                align-items: center;
            }

            .header-text {
                text-align: center;
            }

            .header-text h1,
            .header-text h2 {
                white-space: normal;
            }

            .welcome-banner h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="logo.jpg" alt="Logo">
        <div class="header-text">
            <h1>Biiroo Barnoota Bulchinsa Magaala Maayaa</h1>
            <h2>Maya City Education Bureau</h2>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About the Education Office</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
              <li><a href="#">Downloadable</a></li>
            <li><a href="#">Login</a></li>
        </ul>
    </nav>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <img src=".jpg" alt="Welcome Image">
        <h1><marquee direction="left" style="font-family: serif; font-size: 50px;font-weight: bold;"> Well Come To  Maya City Education Bureau</marquee></h1>
            <p>
    </div>

    <!-- Content -->
    <div class="content">
        <p>
            <!-- Add your content here -->
        </p>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Affiliate Program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Get Help</h4>
                    <ul>
                        <li><a href="#">Documentation and Guides</a></li>
                        <li><a href="#">Support Portals or Help Centers</a></li>
                        <li><a href="#">Contact Channels</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>ADDRESS</h4>
                    <ul>
                        <li><a href="#">Maya City</a></li>
                        <li><a href="#">P.O.bOX.0</a></li>
                        <li><a href="#"> Ethiopia</a></li>
                        <li><a href="#">mayacity@mayacity.edu.et</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="www.facebook.com"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>