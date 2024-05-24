<?php
    // Function to create database connection
    function createConnection() {
        // Include database configuration
        include_once('config.php');
        try {
            // Get database connection parameters
            $servername = $bdd["servername"];
            $username = $bdd["username"];
            $password = $bdd["password"];
            $dbname = $bdd["dbname"];
    
            // Create PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
        }  

        // Return the connection object
        return $conn;
    }
?>