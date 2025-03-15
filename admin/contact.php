<?php
session_start();

 
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

 
$lang = $_SESSION['lang'];
$texts = [
    'en' => [
        'title' => "Contact Us",
        'bureau_head' => "BUREAU HEAD",
        'audit' => "Audit Department",
        'curriculum' => "Curriculum Preparation & Implementation",
        'ict' => "Information Communication Technology",
        'name' => "Name",
        'tel' => "Tel",
        'email' => "E-mail",
    ],
    'or' => [
        'title' => "Nu qunnamu",
        'bureau_head' => "Biiroo Ittii Aanaa",
        'audit' => "Qaama Xiinxala",
        'curriculum' => "Qopheessuu fi Hojii Irratti Jijjiiruu",
        'ict' => "Teekinooloojii Odeeffannoo",
        'name' => "Maqaa",
        'tel' => "Bilbila",
        'email' => "E-mailii",
    ],
    'am' => [
        'title' => "አግኙን",
        'bureau_head' => "የቢሮ ርዕሰ መስሪያ",
        'audit' => "የኦዲት መምሪያ",
        'curriculum' => "የትምህርት ሥርዓት",
        'ict' => "ቴክኖሎጂ የመረጃና ኮምዩኒኬሽን",
        'name' => "ስም",
        'tel' => "ስልክ",
        'email' => "ኢሜይል",
    ]
];
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $texts[$lang]['title']; ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function changeLanguage(lang) {
            fetch('change_language.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'lang=' + lang
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    location.reload();  
                }
            });
        }
    </script>
</head>
<body class="bg-gray-100">

    <header class="bg-teal-700 text-white flex items-center justify-between px-6 py-4 shadow-md">
        <img src="image/logo.jpg" alt="Education Bureau Logo" class="w-28 h-auto"> 
        <div class="text-left">
            <h1 class="text-xl font-bold uppercase">Biiroo Barnootaa Bulchiinsa Magaalaa Maayaa</h1>
            <h2 class="text-lg text-gray-300">City Government of Maya Bureau Of Education</h2>
        </div>
        <div>
            <select onchange="changeLanguage(this.value)" class="px-3 py-2 border border-gray-300 rounded-md text-black">
                <option value="en" <?php if($lang == 'en') echo 'selected'; ?>>English</option>
                <option value="or" <?php if($lang == 'or') echo 'selected'; ?>>Afaan Oromoo</option>
                <option value="am" <?php if($lang == 'am') echo 'selected'; ?>>Amharic</option>
            </select>
        </div>
    </header>

    <nav class="bg-blue-800 shadow-md">
        <ul class="flex justify-center space-x-6 py-3">
            <li><a href="home.php" class="text-white hover:text-yellow-300 transition">Home</a></li>
            <li><a href="about.php" class="text-white hover:text-yellow-300 transition">About</a></li>
            <li><a href="services.php" class="text-white hover:text-yellow-300 transition">Services</a></li>
            <li><a href="contact.php" class="text-white hover:text-yellow-300 transition">Contact</a></li>
            <li><a href="downloads.php" class="text-white hover:text-yellow-300 transition">Downloadable</a></li>
            <li><a href="info.php" class="text-white hover:text-yellow-300 transition">Information</a></li>
            <li><a href="login.php" class="text-white hover:text-yellow-300 transition">Login</a></li>
        </ul>
    </nav>

    <section class="container mx-auto my-10 p-6 bg-white shadow-md rounded-lg w-3/4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center"><?php echo $texts[$lang]['title']; ?></h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-blue-800"><?php echo $texts[$lang]['bureau_head']; ?></h3>
                <p><strong><?php echo $texts[$lang]['name']; ?>:</strong> Aliyyi Hussien</p>
                <p><strong><?php echo $texts[$lang]['tel']; ?>:</strong> 0582264649</p>
                <p><strong><?php echo $texts[$lang]['email']; ?>:</strong> Tariku@gmail.com</p>
            </div>

            <div class="bg-green-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-green-800"><?php echo $texts[$lang]['audit']; ?></h3>
                <p><strong><?php echo $texts[$lang]['name']; ?>:</strong> Sara Kedir</p>
                <p><strong><?php echo $texts[$lang]['tel']; ?>:</strong> 0582208450</p>
                <p><strong><?php echo $texts[$lang]['email']; ?>:</strong> Tariku@gmail.com</p>
            </div>

            <div class="bg-purple-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-purple-800"><?php echo $texts[$lang]['curriculum']; ?></h3>
                <p><strong><?php echo $texts[$lang]['tel']; ?>:</strong> 0582204747 / 0582206525</p>
                <p><strong><?php echo $texts[$lang]['email']; ?>:</strong> Tariku@gmail.com</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-800"><?php echo $texts[$lang]['ict']; ?></h3>
                <p><strong><?php echo $texts[$lang]['name']; ?>:</strong> Tariku Zewdu</p>
                <p><strong><?php echo $texts[$lang]['tel']; ?>:</strong> 0910881653</p>
                <p><strong><?php echo $texts[$lang]['email']; ?>:</strong> Tariku@gmail.com</p>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        <h1><marquee direction="left" style="font-family: serif; font-size: 35px;font-weight: bold;">&copy; 2025 Maya City Education Bureau. Designed by IT Students.</marquee></h1> 
    </footer>

</body>
</html>