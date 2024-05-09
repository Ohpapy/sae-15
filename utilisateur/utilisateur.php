<?php 
    include_once('../outils/bd.php');
    
    try {
        $conn = createConnexion();
        $sql = "SELECT * FROM bonnespratique";
        $stmt = $conn->query($sql);

        $result = $stmt->fetchAll();

        // recherche des bonnes pratiques
        $sqlGetBP = "SELECT bonnespratique.num_bp, bonnespratique.test_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        WHERE bonnespratique.utilisation_bp = 1;";
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

        // select all phases

        $sqlfiltrephase = "SELECT nom_phase FROM phase";
        $stmt = $conn->prepare($sqlfiltrephase);
        $stmt->execute();

        $phases = $stmt->fetchAll();

        // select all prog

        $sqlfiltreprog = "SELECT nom_prog FROM programme";
        $stmt = $conn->prepare($sqlfiltreprog);
        $stmt->execute();

        $progs = $stmt->fetchAll();

        $descriptions = $stmt2->fetchAll();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_POST['deconnexion'])) {
        include_once('../outils/logout.php');
    }
    if (isset($_POST['delete'])){
        $sqldelete = "UPDATE bonnespratique SET utilisation_bp = 0 WHERE num_bp = ?";
        $stmt = $conn->prepare($sqldelete);
        $stmt->execute([$_POST['delete']]);
        header('Location: ../utilisateur/utilisateur.php');
    }

    if (isset($_POST['filtrePhase']) && isset($_POST['filtreProg']) && isset($_POST['recherche'])) {
        $sqlrecherche = "SELECT DISTINCT appartenance.num_bp, bonnespratique.test_bp, bonnespratique.utilisation_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        JOIN bp_motcles ON appartenance.num_bp = bp_motcles.num_bp
        JOIN motcles ON bp_motcles.num_cles = motcles.num_cles WHERE 1=1";

        $params = [];

        if ($_POST['recherche'] !== "") {
            // recherche des mots cles par texte
            $sqlrecherche .= " AND motcles.mot = :motcle";
            $params['motcle'] = $_POST['recherche'];
        }

        if ($_POST['filtrePhase'] !== "*") {
            // recherche des mots cles par texte
            $sqlrecherche .= " AND phase.nom_phase = :phase";
            $params['phase'] = $_POST['filtrePhase'];
        }

        if ($_POST['filtreProg'] !== "*") {
            // recherche des mots cles par texte
            $sqlrecherche .= " AND programme.nom_prog = :prog";
            $params['prog'] = $_POST['filtreProg'];
        }

        $stmt = $conn->prepare($sqlrecherche);
        $stmt->execute($params);
    
        $bps = $stmt->fetchAll();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/utilistateur.css">
    <?php include_once('../outils/header.php'); ?>
    <title>Utilisateur</title>
</head>
<body>
    <div class="haut">
        <div class="childmid">
            <div class="filtre">
                <form action="" method="POST">
                    <div class="dropdowns">
                        <div class="dropdown">
                            <label>Filtre par phase</label>
                            <select class="filtre-select" name="filtrePhase">
                                <option value="*">Tous</option>
                                <?php if (count($phases) > 0) : ?>
                                    <?php foreach ($phases as $phase) : ?>
                                        <option value="<?= $phase["nom_phase"] ?>" 
                                            <?php if (isset($_POST['filtrePhase']) && $_POST['filtrePhase'] == $phase["nom_phase"]): ?>
                                                selected
                                            <?php endif ?>
                                        ><?= $phase["nom_phase"] ?></option>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="dropdown">
                            <label>Filtre par prog</label>
                            <select class="filtre-select" name="filtreProg">
                                <option value="*">Tous</option>
                                <?php if (count($progs) > 0) : ?>
                                    <?php foreach ($progs as $prog) : ?>
                                        <option value="<?= $prog["nom_prog"] ?>" 
                                            <?php if (isset($_POST['filtreProg']) && $_POST['filtreProg'] == $prog["nom_prog"]): ?>
                                                selected
                                            <?php endif ?>
                                        ><?= $prog["nom_prog"] ?></option>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div>        
                            <label>Recherche par mot clé</label>
                            <input type="text" name="recherche" placeholder="Mot-clé" value="<?= isset($_POST['recherche']) ? $_POST['recherche'] : "" ?>">
                        </div>
                    </div>
                    <button>Filtrer</button>
                </form>
            </div>
        </div>
        <div class="childmid">
            <h1>Liste des bonnes pratiques</h1>
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
                    <div class='bonne-pratique'>
                        <div class='info-container'>
                            <div class="checkbox">
                                <input type="checkbox" name="select" value="<?= $bp["num_bp"] ?>">
                            </div>
                            <p>Test: <?= $bp["test_bp"] ?></p>
                            <p>Programme: <?= $bp["nom_prog"] ?></p>
                            <p>Phase: <?= $bp["nom_phase"] ?></p>
                            <div class="action">
                                <button class='bonne-pratique-details' data-numbp="<?= $bp["num_bp"] ?>">Voir le détails</button>
                                <form action="" method="POST">
                                    <input type="hidden" name="delete" value="<?= $bp["num_bp"] ?>" />
                                    <button type="submit">Supprimer</button>
                                </form>
                            </div>
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
            $(".bonne-pratique-details").on("click", function(e) {
                $(".popup").addClass("show");
                const numbp = $(e.currentTarget).data('numbp');
                $('.popup').find("#numbp_" + numbp).show();
            });
            
            $(".close-button").on("click", function(e) {
                $(".popup").removeClass("show");
                $('.popup > div').hide();
            });

            $(".button-valider").on("click", function(e) {
                const selected = $("input[name='select']:checked");
                const numBpSelected = [];

                selected.toArray().forEach(i => {
                    numBpSelected.push(i.value);
                });

                console.log(numBpSelected);
            });
        });

    </script>
</body>
</html>