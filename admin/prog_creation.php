<?php
    include_once('../outils/bd.php');       // Includes the database connection file

    try {
        $conn = createConnexion();          // Creates a connection to the database

        // Inserting a new best practice into the 'bonnespratique' table
        $sqlbp = "INSERT INTO programme (nom_prog) VALUES (?)";  
        $stmtbp = $conn->prepare($sqlbp);
        $stmtbp->execute([$_POST['nom_prog']]);
        $num_bp = $conn->lastInsertId();    // Retrieves the ID of the last insertion
        header('Location: ../admin/admin.php');     // Redirects after successful operation
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>