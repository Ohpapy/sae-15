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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bp.css">
    <title>Bonne Pratique</title>
</head>
<body>
    <div class="main">
        <div class="left">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi error laborum, provident molestiae praesentium nisi exercitationem nesciunt aut quis nostrum, doloribus corporis placeat accusamus fuga, esse maxime aspernatur natus cupiditate.
        </div>
        <div class="center">
            <form action="bp_creation.php" method="post">
                <label for="nom_bp">Nom de Bonne Pratique:</label>
                <input type="text" id="nom_bp" name="nom_bp" required>
                <label for="num_bp">Numéro de Bonne Pratique:</label>
                <input type="text" id="num_bp" name="num_bp" required>
                <label for="utilisation_bp">Utilisation de Bonne Pratique:</label>
                <input type="text" id="utilisation_bp" name="utilisation_bp" required>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
        <div class="right">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, voluptates incidunt sunt minima ex laborum laudantium provident similique sit labore aperiam unde atque eaque reprehenderit ab? Aperiam veritatis sit numquam.
        </div>
    </div>
</body>
</html>