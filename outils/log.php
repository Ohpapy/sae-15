
<?php
        function logMessage($conn, $message, $type) {
            // SQL query
            $sqllog = "INSERT INTO logs (message, type) VALUES (:message, :type)";

            // Prepare the SQL statement
            $stmtlog = $conn->prepare($sqllog);

            // Bind parameters
            $stmtlog->bindParam(':message', $message);
            $stmtlog->bindParam(':type', $type);

            // Execute the statement
            $stmtlog->execute();
        }
?>
