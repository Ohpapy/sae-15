<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');

    try {
        $conn = createConnection();          // Creates a connection to the database
        $item = htmlspecialchars($_POST['item']);

        // Inserting a new best practice into the 'bonnespratique' table
        $sqlbp = "INSERT INTO bonnespratique (test_bp) VALUES (?)";  
        $stmtbp = $conn->prepare($sqlbp);
        $stmtbp->execute([$item]);
        $num_bp = $conn->lastInsertId();    // Retrieves the ID of the last insertion
        $mess ='Une bonne pratique a été créée avec cet ID: ' . $num_bp;
        logMessage($conn, $mess, 'CRÉATION BONNE PRATIQUE');

        // Joining with the program and phase ownership in the 'appartenance' table
        $sqlapp = "INSERT INTO appartenance (num_prog, num_phase, num_bp) VALUES (?, ?, ?)";
        $stmtapp = $conn->prepare($sqlapp);
        $stmtapp->execute([$_POST['programme'], $_POST['phase'], $num_bp]);

        $keywords = explode(";", $_POST['motcles']);     // Splits the keywords by ';'

        // Creating keywords and joining keywords in the 'motcles' and 'bp_motcles' tables
        foreach ($keywords as $keyword) {
            $sqlselectkw = "SELECT * FROM motcles WHERE mot = ?";
            $stmtselectkw = $conn->prepare($sqlselectkw);
            $stmtselectkw->execute([trim($keyword)]);        // Searches if the keyword already exists
            $existkw = $stmtselectkw->fetch();
            $num_key = $existkw['num_cles'];           // Retrieves the ID of the existing keyword

            if (!$existkw) {              // If the keyword doesn't exist, inserts it into the 'motcles' table
                $sqlkw = "INSERT INTO motcles (mot) VALUES (?)";
                $stmtkw = $conn->prepare($sqlkw);
                $stmtkw->execute([trim($keyword)]);
                $num_key = $conn->lastInsertId();       // Retrieves the ID of the new keyword
            }

            // Inserts the relationship between the best practice and the keyword in the 'bp_motcles' table
            $sqlbpkw = "INSERT INTO bp_motcles (num_bp,num_cles) VALUES (?,?)";             
            $stmtbpkw = $conn->prepare($sqlbpkw);
            $stmtbpkw->execute([$num_bp, $num_key]);
        }

        header('Location: ../utilisateur/utilisateur.php');     // Redirects after successful operation
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>