<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');
    try {
        $conn = createConnection();          // Creates a connection to the database
        $sqlgetprog = "SELECT * FROM programme";
        $stmt = $conn->prepare($sqlgetprog);
        $stmt->execute();
        $progs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['delete'])) {
            // Delete the corresponding rows from 'appartenance' first
            $sqldeleteappartenance = "DELETE FROM appartenance WHERE num_prog = ?";
            $stmtdeleteappartenance = $conn->prepare($sqldeleteappartenance);
            $stmtdeleteappartenance->execute([$_POST['num_prog']]);

            // Now delete the row from 'programme'
            $sqldelete = "DELETE FROM programme WHERE num_prog = ?";
            $stmt = $conn->prepare($sqldelete);
            $stmt->execute([$_POST['num_prog']]);
            $mess ='Un programme a été supprimé son num est: ' . $_POST['num_prog'];
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