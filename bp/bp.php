<?php   
    include_once('../outils/bd.php');

    try {
        $conn = createConnexion(); 

        // chercher tous les prog
        $sqlProg = "SELECT * FROM programme";
        $stmtProg = $conn->query($sqlProg);
        $programmes = $stmtProg->fetchAll();

        // chercher toutes les phases
        $sqlPhase = "SELECT * FROM phase";
        $stmtPhase = $conn->query($sqlPhase);
        $phases = $stmtPhase->fetchAll();

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
                <div>
                    <label for="item">Item:</label>
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
        </div>
        <div class="right">
            <h2>
                liste des programmes
            </h2>

        </div>
    </div>
</body>
</html>