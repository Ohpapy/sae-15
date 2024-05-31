<?php 
    // Include database connection script
    include_once('../outils/bd.php');
    try {
        // Create database connection
        $conn = createConnection();
        $sqlGETlog = "SELECT * FROM logs";
        $stmtGETlog = $conn->prepare($sqlGETlog);
        $stmtGETlog->execute();
        $logs = $stmtGETlog->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // Display error message if connection fails
        echo "Connection failed: " . $e->getMessage();
    }
    // Set error reporting settings
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/logs.css">
    <?php include_once('../outils/header.php'); ?>
    <title>Logs</title>
</head>
<body>
    <div class="container">
        <div class="BP">
            <h2>Logs</h2>
            
            <?php
                echo "<table style='width:100%;'>";
                echo "<tr><th>Date</th><th>Nom</th><th>Message</th><th>Type</th></tr>";
                foreach ($logs as $log) {
                    echo "<tr>";
                    echo "<td style='width:20%; overflow-x: auto; text-align: center;'>" . $log['date'] . "</td>";
                    echo "<td style='width:20%; overflow-x: auto; text-align: center;'>" . $log['nom'] . "</td>";
                    echo "<td style='width:40%; overflow-x:auto; text-align: center;'>" . $log['message'] . "</td>";
                    echo "<td style='width:20%; overflow-x: auto; text-align: center;'>" . $log['type'] . "</td>";
                    echo "</tr>";
                }   
                echo "</table>";
            ?>
        </div>
    </div>
    <div class="bas">
        <a href="../admin/admin.php" class="home">Retour</a>
    </div>
</body>
</html>