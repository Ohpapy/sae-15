<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    try {
        $conn = createConnexion();          // Creates a connection to the database
        $sqlGetprog = "SELECT * FROM programme";
        $stmt = $conn->prepare($sqlGetprog);
        $stmt->execute();
        $progs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['delete'])) {
            $sqlDelete = "DELETE FROM programme WHERE num_prog = ?";
            $stmt = $conn->prepare($sqlDelete);
            $stmt->execute([$_POST['num_prog']]);
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