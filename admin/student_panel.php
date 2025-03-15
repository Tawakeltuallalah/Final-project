<?php
session_start();
require 'dbconfig.php'; 

// Ensure only Manager can access
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
//    header("Location: login.php");
//    exit();
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

 
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <div class="header">
        <button class="menu" id="menu" onclick="toggleSidebar()">☰ Student Dashboard</button>
        <div class="notification" onclick="showNotifications()">
            🔔 <span class="notification-badge" id="notification-count">0</span>
        </div>
    </div>

    
    <div id="sidebar" class="bg-gray-900 text-white w-64 min-h-screen fixed top-0 left-0 transform -translate-x-full transition-transform duration-300 lg:translate-x-0">
        <div class="text-center p-5 border-b border-gray-700">
            <h2 class="text-xl font-bold">Student Panel</h2>
        </div>
        <nav class="mt-5">
            <a href="#" onclick="loadContent('register_st.php')" class="sidebar">📝 Register</a>
        
            <a href="#" onclick="loadContent('download_mat.php')" class="sidebar">📂 Download material</a>
      
            <a href="login.php" class="block text-center bg-red-500 py-3 mt-4 hover:bg-red-700 transition">Logout</a>
        </nav>
    </div>

   
    <div id="main-content" class="flex-1 mt-16 lg:ml-64 p-6 transition-all duration-300">
        <h2 class="text-2xl font-bold">Welcome, Student!</h2>
        <p class="text-gray-600">Select an option from the menu to continue.</p>
        <div id="dynamic-content" class="mt-4">
       
        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
             var menuBtn = document.getElementById("menu-btn")
             

            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-260px";
                content.style.marginLeft = "0";
            } else {
                sidebar.style.left = "0px";
                content.style.marginLeft = "260px";
            }
        }
        function loadContent(page) {
            var content = document.getElementById("dynamic-content");

            
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
        fetchNotifications(); // Initial load
    </script>

    <style>
         
        .sidebar {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        .sidebar:hover {
            background: rgba(255, 255, 255, 0.1);
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

        .menu {
            font-size: 20px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            display: flex;
        }

        .menu:hover {
            transform: scale(1.1);
        }

        .notification {
            position: relative;
            font-size: 20px;
            cursor: pointer;
            margin-right: 20px;
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
    </style>
</body>
    </html>