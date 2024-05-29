<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');
    try {
        $conn = createConnection();          // Creates a connection to the database
        $sqlGetprog = "SELECT * FROM programme";
        $stmt = $conn->prepare($sqlGetprog);
        $stmt->execute();
        $progs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['delete'])) {
            // Delete the corresponding rows from 'appartenance' first
            $sqlDeleteAppartenance = "DELETE FROM appartenance WHERE num_prog = ?";
            $stmtDeleteAppartenance = $conn->prepare($sqlDeleteAppartenance);
            $stmtDeleteAppartenance->execute([$_POST['num_prog']]);

            // Now delete the row from 'programme'
            $sqlDelete = "DELETE FROM programme WHERE num_prog = ?";
            $stmt = $conn->prepare($sqlDelete);
            $stmt->execute([$_POST['num_prog']]);
            $mess ='Un programme a été supprimé son nom est: ' . $_POST['nom_prog'];
            logMessage($conn, $mess, 'SUPPRESION PROGRAMME');
            header('Location: ../admin/admin.php');
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>