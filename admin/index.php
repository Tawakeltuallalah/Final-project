<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Bureau - Maya City</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <div class="flex-1 flex flex-col">
            <!-- Header Section -->
            <div class="header bg-grey flex items-center p-5 shadow-md">
                <img src="logo.jpg" alt="Logo" class="h-16 w-16 mr-7">
                <div class="header-text">
                    <h1 class="text-xl font-bold">Biiroo Barnoota Bulchinsa Magaala Maayaa</h1>
                    <h2 class="text-lg text-gray-700">Maya City Education Bureau</h2>
                </div>
            </div>
            <nav>
                <ul class="flex space-x-6" bg-green>
                    <li><a href="#" class="hover:underline">Home</a></li>
                    <li><a href="about.php" class="hover:underline">About</a></li>
                    <li><a href="#" class="hover:underline">Services</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                    <li><a href="#" class="hover:underline">Downloadable</a></li>
                    <li><a href="#" class="hover:underline">Location</a></li>
                    <li><a href="#" class="hover:underline">Information</a></li>
                    <li><a href="login.php" class="hover:underline">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-64 text-white flex items-center justify-center" style="background-image: url('your-image.jpg');">
        <div class="bg-black bg-opacity-50 p-8 rounded-lg">
            <h2 class="text-3xl font-bold">Welcome to the Education Bureau</h2>
            <p class="mt-2 text-lg">Ensuring quality education for all students in Mayaya City.</p>
        </div>
    </section>
    
    <!-- News Section -->
    <section class="container mx-auto mt-8 px-6">
        <h2 class="text-2xl font-bold mb-4">Latest News</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="news1.jpg" alt="News 1" class="rounded-md mb-2">
                <h3 class="font-semibold text-lg">School Renovations Begin</h3>
                <p class="text-gray-600 mt-1">Construction has started in 10 schools...</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="news2.jpg" alt="News 2" class="rounded-md mb-2">
                <h3 class="font-semibold text-lg">New Teachers Assigned</h3>
                <p class="text-gray-600 mt-1">Over 50 new teachers joined this year...</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="news3.jpg" alt="News 3" class="rounded-md mb-2">
                <h3 class="font-semibold text-lg">Tech in Education</h3>
                <p class="text-gray-600 mt-1">Introducing smart learning in 2025...</p>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-4 mt-8">
        <p>&copy; 2025 Mayaya City Education Bureau. All rights reserved.</p>
    </footer>
</body>
</html>
