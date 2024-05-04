<?php
    function createConnexion() {
        try {
            // Establish database connection
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "RP09";
    
            // Create connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }  
    
        return $conn;
    }
?>