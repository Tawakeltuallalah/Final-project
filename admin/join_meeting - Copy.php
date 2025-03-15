<?php
session_start();
require 'dbconfig.php';

$meeting_code = $_GET['code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Meeting</title>
</head>
<body>
    <h2>Meeting Code: <?= $meeting_code ?></h2>
    <video id="localVideo" autoplay playsinline></video>
    <video id="remoteVideo" autoplay playsinline></video>

    <script>
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(stream => {
            document.getElementById("localVideo").srcObject = stream;
        }).catch(error => console.error("Error accessing camera:", error));

        // WebRTC signaling & connection code goes here (use WebSockets for signaling)
    </script>
</body>
</html>
