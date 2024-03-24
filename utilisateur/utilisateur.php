<?php   
    try {
        // Establish database connection
        $servername = "localhost";
        $username = "RP09";
        $password = "RP09";
        $dbname = "RP09";

        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM BonnesPratique";
        $stmt = $conn->query($sql);

        $result = $stmt->fetchAll();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/utilistateur.css">
    <title>Utilisateur</title>
</head>
<body>
    <div class="haut">
        <div class="child">
            <div class="filtre">
                <div class="dropdown">
                    <button class="button-filtre"><h2>FILTRE</h2></button>
                    <div class="dropdown-content">
                        <select class="filtre-select">
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="child">
            <div class="rechercher">
                <input type="text" placeholder="Mot-clé">
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/utilistateur.css">
    <title>Utilisateur</title>
</head>
<body>
    <div class="haut">
        <div class="child">
            <div class="filtre">
                <div class="dropdown">
                    <button class="button-filtre"><h2>FILTRE</h2></button>
                    <div class="dropdown-content">
                        <select class="filtre-select">
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="child">
            <div class="rechercher">
                <input type="text" placeholder="Mot-clé">
                <button>Rechercher</button>
            </div>
            <div class="content1">
                <button class="button-bp"><h2>Créer une bonne pratique</h2></button>
            </div>
        </div>
        <div class="child">
            <div class="admin">
                <button class="button-admin"><h2>ADMIN</h2></button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="BP">
            <?php

            $sql = "SELECT * FROM BonnePratique";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<div class='bonne-pratique'>";
                    echo "<h2>" . $row["title"] . "</h2>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "No results found";
            }
            $conn->close();
            ?>
        </div>
        <div class="valider">
            <button class="button-valider"><H2>valider</H2></button>
        </div>
    </div>
</body>
</html>