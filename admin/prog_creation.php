<?php
    include('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');      // Includes the log file
    try {
        $conn = createConnection();          // Creates a connection to the database
        $sqlGetprog = "SELECT nom_prog FROM programme";
        $stmt = $conn->prepare($sqlGetprog);
        $stmt->execute();
        $progs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        // Inserting a new best practice into the 'bonnespratique' table
        if (in_array($_POST['nom_prog'], $progs)) {     
            header('Location: ../admin/admin.php');     // Redirects if the best practice already exists
        } else {
            $sqlbp = "INSERT INTO programme (nom_prog) VALUES (?)";  
            $stmtbp = $conn->prepare($sqlbp);
            $stmtbp->execute([$_POST['nom_prog']]);
            $num_bp = $conn->lastInsertId();    // Retrieves the ID of the last insertion
            $mess ='Un nouveau programme a été créée avec cet ID' . $num_bp. ' son nom est: ' . $_POST['nom_prog'];
            logMessage($conn, $mess, 'CRÉATION PROGRAMME');
            header('Location: ../admin/admin.php');     // Redirects after successful operation         
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>