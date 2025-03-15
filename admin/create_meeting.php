<?php
session_start();
require 'dbconfig.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host_id = $_SESSION['user_id'];
    $participant_id = $_POST['participant_id']; // School Director's ID
    $meeting_code = uniqid("meeting_");

    $sql = "INSERT INTO meetings (host_id, participant_id, meeting_code) VALUES ('$host_id', '$participant_id', '$meeting_code')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "meeting_code" => $meeting_code]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error scheduling meeting."]);
    }
    exit();
}
?>
