<?php
require 'dbconfig.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to database: " . $database;
    
     
    $result = $conn->query("SHOW TABLES");
    echo "<h4>Database Tables:</h4>";
    while ($row = $result->fetch_row()) {
        echo $row[0] . "<br>";
    }
}
?>