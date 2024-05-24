<?php   
    include_once('../outils/bd.php');       // Includes the database connection file

    try {
        $conn = createConnection();          // Creates a connection to the database 

        // Fetch all programs
        $sqlProg = "SELECT * FROM programme";
        $stmtProg = $conn->query($sqlProg);
        $programmes = $stmtProg->fetchAll();

        // Fetch all phases
        $sqlPhase = "SELECT * FROM phase";
        $stmtPhase = $conn->query($sqlPhase);
        $phases = $stmtPhase->fetchAll();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();     // Displays an error message in case of connection failure
    }
    ini_set('display_errors', 1);       // Sets the display error configuration
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/bp.css">
    <?php include_once('../outils/header.php'); ?>    <!-- Includes the header file -->
    <title>Bonne Pratique</title>
</head>
<body>
    <div class="main">
        <div class="left">
            <h2>
                Liste des Phases
            </h2>
            <ul>
                <?php foreach ($phases as $row) : ?>
                    <li><?= $row['nom_phase'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="center">
            <form action="bp_creation.php" method="post">
                <h2>
                    Ajouter une Bonne Pratique
                </h2>
                <div>
                    <label for="item">Bonne Pratique:</label>
                    <input type="text" id="item" name="item" required>
                </div>
                <hr>
                <div>
                    <label for="motcles">Mots clés:</label>
                    <input type="text" id="motcles" name="motcles" required><br>
                    <small>Separer les mots clés par des ";"</small>
                </div>
                <hr>
                <div>
                    <label for="programme">Programme:</label>
                    <select id="programme" name="programme" required>
                        <?php foreach ($programmes as $row) : ?>
                            <option value="<?= $row['num_prog'] ?>"><?= $row['nom_prog'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <hr>
                <div>
                    <label for="phase">Phase:</label>
                    <select id="phase" name="phase" required>
                        <?php foreach ($phases as $row) : ?>
                            <option value="<?= $row['num_phase'] ?>"><?= $row['nom_phase'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
            <a href="../utilisateur/utilisateur.php">Retour</a> 
        </div>
        <div class="right">
            <h2>
                Liste des Programmes
            </h2>
            <ul>
                <?php foreach ($programmes as $row) : ?>
                    <li><?= $row['nom_prog'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>