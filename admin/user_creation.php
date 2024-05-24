<?php
    include_once('../outils/bd.php');       // Includes the database connection file

    try {
        $conn = createConnection();          // Creates a connection to the database
        $password = password_hash($_POST['mdp_ut'], PASSWORD_DEFAULT);    // Hashes the password
        // Inserting a new best practice into the 'bonnespratique' table
        $sqluser = "INSERT INTO utilisateur (login_ut, nom_ut, mdp_ut, acces_ut, bloque_ut, tentative_ut, presence_ut) VALUES (?,?,?,?,0,0,0)";  
        $stmtbp = $conn->prepare($sqluser);
        $stmtbp->execute([$_POST['login_ut'], $_POST['nom_ut'], $password, $_POST['acces_ut']]);
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