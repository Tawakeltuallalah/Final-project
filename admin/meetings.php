<?php
session_start();
require 'dbconfig.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM meetings WHERE host_id='$user_id' OR participant_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetings</title>
</head>
<body>
    <h2>Your Meetings</h2>
    <table border="1">
        <tr>
            <th>Meeting Code</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['meeting_code'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <a href="join_meeting.php?code=<?= $row['meeting_code'] ?>">Join Meeting</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
