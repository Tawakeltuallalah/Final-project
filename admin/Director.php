<?php
session_start();
require 'dbconfig.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'School Director') {
   header("Location: login.php");
    exit();
}
 
$schools_query = $conn->query("SELECT School_id, School_name FROM school ORDER BY School_name ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Director Panel</title>
    <style>
        
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            min-height: 100vh;
        }

        
        .sidebar {
            width: 260px;
            background: #2a3f54;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -260px;
            padding-top: 25px;
            transition: left 0.3s ease-in-out;
            z-index: 1000;
            top: 57px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            transition: 0.3s;
            font-size: 18px;
            border-left: 4px solid transparent;
            cursor: pointer;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #00bcd4;
        }

        .logout-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px;
        }

        .logout-btn:hover {
            background: darkred;
        }

      
        .header {
            width: 100%;
            background: #2a3f54;
            color: white;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .menu-btn {
            font-size: 24px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .menu-btn:hover {
            transform: scale(1.1);
        }

        .notification {
            position: relative;
            font-size: 20px;
            cursor: pointer;
            margin-right: 40px;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 5px;
            border-radius: 50%;
        }

        
        .content {
            margin-top: 70px;
            padding: 30px;
            width: 100%;
            text-align: center;
            transition: margin-left 0.3s ease-in-out;
        }

       
        #dynamic-content {
            display: none;  

    
        .form-container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: #3498db;
            color: white;
        }

        .btn:hover {
            background: #2980b9;
        }

        
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

  
    <div class="header">
        <button class="menu-btn" id="menu-btn" onclick="toggleSidebar()">☰ School Director Dashboard</button>
        <div class="notification" onclick="showNotifications()">
            🔔 <span class="notification-badge" id="notification-count">0</span>
        </div>
    </div>

   
    <div class="sidebar" id="sidebar">
        <a onclick="loadContent('register_teacher.php')">📝 Register Teacher</a>
        <a onclick="loadContent('submit_data.php')">📩 Submit Data</a>
        <a onclick="loadContent('manage_data.php')">🔄 Manage Data</a>
        <a onclick="loadContent('generate_report.php')">📊 Generate Report</a>
        <a onclick="loadContent('request_resource.php')">📦 Request Resources</a>
        <a href="login.php" class="logout-btn">Logout</a>
    </div>

 
    <div class="content" id="content">
        <h2>Welcome, School Director!</h2>
        <p>Select an option from the menu to continue.</p>

       
        <div id="dynamic-content"></div>
    </div>

    <script>
        function toggleSidebar() { 
            var sidebar = document.getElementById("sidebar");
            sidebar.style.left = sidebar.style.left === "0px" ? "-260px" : "0px"; 
        }

        function showNotifications() {
            alert("You have new notifications!");
        }

        function loadContent(page) {
            var content = document.getElementById("dynamic-content");

             
            content.innerHTML = "<h2>Loading...</h2>";
            content.style.display = "block"; // Make it visible

            
            var xhr = new XMLHttpRequest();
            xhr.open("GET", page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    content.innerHTML = xhr.responseText;
                } else if (xhr.status !== 200) {
                    content.innerHTML = "<h2>Error loading content.</h2>";
                }
            };
            xhr.send();
        }
    </script>

</body>
</html>
