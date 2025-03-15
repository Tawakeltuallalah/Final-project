<?php
session_start();
require 'dbconfig.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #1e3c72, rgb(49, 138, 138));
            display: flex;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: rgba(42, 63, 84, 0.9);
            height: 100vh;
            position: fixed;
            top: 57px;
            left: -260px;
            padding-top: 25px;
            color: white;
            box-shadow: 3px 0px 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            transition: left 0.3s ease-in-out;
            z-index: 1000;
            margin-left: 0px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            transition: 0.3s;
            font-size: 18px;
            border-left: 4px solid transparent;
            position:   padding-top: 25px;;
            margin-left: 2px;
            display: flex;
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
            font-weight: bold;
        }

        .logout-btn:hover {
            background: darkred;
        }

      
        .header {
            width: 100%;
            background: #2a3f54;
            color: white;
            padding: 15px 15px;
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
            display: flex;
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
            margin-left: 0;
            padding: 30px;
            width: 100%;
            color: white;
            text-align: center;
            transition: margin-left 0.3s ease-in-out;
        }

        h2 {
            font-size: 32px;
        }
 
        @media screen and (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

   
    <div class="header">
        <button class="menu-btn" id="menu-btn" onclick="toggleSidebar()">☰ Admin Dashboard</button>
        <div class="notification" onclick="showNotifications()">
            🔔 <span class="notification-badge" id="notification-count">0</span>
        </div>
    </div>

   
    <div class="sidebar" id="sidebar">
        <a href="#" onclick="loadContent('manage_accounts.php')">👤 Manage Accounts</a>
        <a href="#" onclick="loadContent('assign_roles.php')">🔄 Assign Roles</a>
        <a href="#" onclick="loadContent('add_role.php')">➕ Add Role</a>
        <a href="#" onclick="loadContent('view_data.php')">📊 View Data</a>
        <a href="login.php" class="logout-btn">Logout</a>
    </div>

 
    <div class="content" id="content">
        <h2>Welcome, Admin!</h2>
        <p>Select an option from the menu to manage the system.</p>
    </div>

     
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            var content = document.getElementById("content");

            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-260px";
                content.style.marginLeft = "0";
            } else {
                sidebar.style.left = "0px";
                content.style.marginLeft = "260px";
            }
        }

        function loadContent(page) {
            var content = document.getElementById("content");

             
            content.innerHTML = "<h2>Loading...</h2>";
 
            var xhr = new XMLHttpRequest();
            xhr.open("GET", page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    content.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function showNotifications() {
            alert("You have " + document.getElementById("notification-count").textContent + " new notifications.");
        }

        function fetchNotifications() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_notifications.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("notification-count").textContent = xhr.responseText;
                }
            };
            xhr.send();
        }
 
        setInterval(fetchNotifications, 10000);
        fetchNotifications();  
    </script>

</body>
</html>
