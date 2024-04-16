<?php
    try {
        // Establish database connection
        $servername = "localhost";
        $username = "RP09";
        $password = "RP09";
        $dbname = "RP09";

        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }  
?>