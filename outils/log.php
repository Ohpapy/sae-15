
<?php  
    session_start();
    function logMessage($conn, $message, $type) {
        // SQL query
        $sqllog = "INSERT INTO logs (message, type, date, nom) VALUES (:message, :type, NOW(), :nom)";

        // Prepare the SQL statement
        $stmtlog = $conn->prepare($sqllog);

        // Bind parameters
        $stmtlog->bindParam(':message', $message);
        $stmtlog->bindParam(':type', $type);
        $stmtlog->bindParam(':nom', $_SESSION['nom_ut']);

        // Execute the statement
        $stmtlog->execute();
    }
?>
