<?php 
    // Include database connection script
    include_once('../outils/bd.php');
    
    try {
        // Create database connection
        $conn = createConnection();
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
    <title>Utilisateur</title>
</head>
<body>
    <div class="container">
        <div class="BP">
            <h2>Logs</h2>
            <?php
                date_default_timezone_set('Europe/Paris');
                $adresseIP = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user
                $adresseIPv4 = inet_ntop(inet_pton($adresseIP)); // Convert an IPv6 address to an IPv4 address
                $heureActivite = date('Y-m-d H:i:s'); // Get the date and time of the user's activity
                $action = "Utilisateur connecté"; // Action performed by the user
                $messageLog = "Adresse IP : $adresseIP - Heure d'activité : $heureActivite - Action : $action\n";// Log message
                echo($messageLog); // Display log message
            ?>
        </div>
        <a href="../admin/admin.php" class="logs-container">Retour</a>
    </div>
</body>
</html>