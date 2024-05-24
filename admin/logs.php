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
        </div>
        <a href="../utilisateur/utilisateur.php">Retour</a>
    </div>
</body>
</html>