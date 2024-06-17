<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');

    try {
        $conn = createConnection();          // Creates a connection to the database
        $password = password_hash($_POST['mdp_ut'], PASSWORD_DEFAULT);    // Hashes the password
        // Inserting a new best practice into the 'bonnespratique' table
        $sqluser = "DELETE FROM utilisateur WHERE login_ut = ?";  
        $stmtuser = $conn->prepare($sqluser);
        $stmtuser->execute([$_POST['usersupp']]);
        $num_user = $conn->lastInsertId();    // Retrieves the ID of the last insertion
        $mess ='Un utilisateur a été supprimé avec cet ID: ' . $num_user. ' son login était: ' . $_POST['usersupp'];
        logMessage($conn, $mess, 'SUPPRESSION UTILISATEUR');
        header('Location: ../admin/admin.php');     // Redirects after successful operation
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>