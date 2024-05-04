<?php 
    include_once('../outils/bd.php');
    
    try {
        $conn = createConnexion();
        $sql = "SELECT * FROM BonnesPratique";
        $stmt = $conn->query($sql);

        $result = $stmt->fetchAll();

        // recherche des bonnes pratiques
        $sqlGetBP = "SELECT bonnespratique.num_bp, bonnespratique.test_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase;";
        $stmt = $conn->prepare($sqlGetBP);
        $stmt->execute();
    
        $bps = $stmt->fetchAll();
    
        // recherches des descriptions des bonnes pratiques
        $sqlDescriptions = "SELECT appartenance.num_bp, bonnespratique.test_bp, bonnespratique.utilisation_bp, programme.nom_prog, phase.nom_phase, GROUP_CONCAT(motcles.mot SEPARATOR ' - ') AS motcles
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        JOIN bp_motcles ON appartenance.num_bp = bp_motcles.num_bp
        JOIN motcles ON bp_motcles.num_cles = motcles.num_cles
        GROUP BY appartenance.num_bp, bonnespratique.test_bp, bonnespratique.utilisation_bp, programme.nom_prog, phase.nom_phase;";
        $stmt2 = $conn->prepare($sqlDescriptions);
        $stmt2->execute();
    
        $descriptions = $stmt2->fetchAll();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    if (isset($_POST['recherche']) && $_POST['recherche'] !== "") {
        // recherche des mots cles par texte
        $sqlrecherche = "SELECT appartenance.num_bp, bonnespratique.test_bp, bonnespratique.utilisation_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        JOIN bp_motcles ON appartenance.num_bp = bp_motcles.num_bp
        JOIN motcles ON bp_motcles.num_cles = motcles.num_cles
        WHERE motcles.mot = ?;";
        $stmt = $conn->prepare($sqlrecherche);
        $stmt->execute([$_POST['recherche']]);
    
        $bps = $stmt->fetchAll();
    }

    if (isset($_POST['deconnexion'])) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
        header('Location: ../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/utilistateur.css">
    <title>Utilisateur</title>
</head>
<body>
    <div class="haut">
        <div class="childmid">
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
        <div class="childmid">
            <div class="rechercher">
                <form action="" method="post">
                    <input type="text" name="recherche" placeholder="Mot-clé" value="<?= isset($_POST['recherche']) ? $_POST['recherche'] : "" ?>">
                    <button>Rechercher</button>
                </form>
            </div>
            <div class="content1">
                <form action="../bp/bp.php">
                    <button class="button-bp"><h2>Créer une bonne pratique</h2></button>
                </form>
            </div>
        </div>
        <div class="child">
            <form action="" method="post" class="admin">
                <button type="submit" name="admin" class="button-admin"><h2>ADMIN</h2></button>
            </form>
            <form action="" method="post" class="deconnexion">
                <button type="submit" name="deconnexion" class="button-deconnexion"><h2>DÉCONNEXION</h2></button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="BP">
            <?php if (count($bps) > 0) : ?>
                <?php foreach ($bps as $bp) : ?>
                    <div class='bonne-pratique' data-numbp="<?= $bp["num_bp"] ?>">
                        <div class='info-container'>
                            <p>Test: <?= $bp["test_bp"] ?></p>
                            <p>Programme: <?= $bp["nom_prog"] ?></p>
                            <p>Phase: <?= $bp["nom_phase"] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No results found</p>
            <?php endif ?>
        </div>
        <div class="valider">
            <button class="button-valider"><H2>valider</H2></button>
        </div>
    </div>
    <div class="popup">
        <?php if (count($descriptions) > 0) : ?>
            <?php foreach ($descriptions as $desc) : ?>
                <div id="numbp_<?= $desc["num_bp"] ?>" style="display: none">
                    <h2><?= $desc["num_bp"] ?></h2>
                    <p>Test: <?= $desc["test_bp"] ?></p>
                    <p>Utilisation: <?= $desc["utilisation_bp"] === 1 ? "oui" : "non" ?></p>
                    <p>Programme: <?= $desc["nom_prog"] ?></p>
                    <p>Phase: <?= $desc["nom_phase"] ?></p>
                    <p>Mot clé: <?= $desc["motcles"] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No results found</p>
        <?php endif; ?>
        <button class="close-button">
            Fermer
        </button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".bonne-pratique").on("click", function(e) {
                $(".popup").addClass("show");
                const numbp = $(e.currentTarget).data('numbp');
                $('.popup').find("#numbp_" + numbp).show();
            });
            
            $(".close-button").on("click", function(e) {
                $(".popup").removeClass("show");
                $('.popup > div').hide();
            });
        });
    </script>
</body>
</html>