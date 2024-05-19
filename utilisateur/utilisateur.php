<?php 
    // Include database connection script
    include_once('../outils/bd.php');
    
    try {
        // Create database connection
        $conn = createConnexion();

        // Select all records from bonnespratique table
        $sql = "SELECT * FROM bonnespratique";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll();

        // Select bonnes pratiques with usage flag set to 1
        $sqlGetBP = "SELECT bonnespratique.num_bp, bonnespratique.test_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        WHERE bonnespratique.utilisation_bp = 1;";
        $stmt = $conn->prepare($sqlGetBP);
        $stmt->execute();
    
        $bps = $stmt->fetchAll();
    
        // Select descriptions of bonnes pratiques
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

        // Select all phases

        $sqlfiltrephase = "SELECT nom_phase FROM phase";
        $stmt = $conn->prepare($sqlfiltrephase);
        $stmt->execute();

        $phases = $stmt->fetchAll();

        // Select all programs

        $sqlfiltreprog = "SELECT nom_prog FROM programme";
        $stmt = $conn->prepare($sqlfiltreprog);
        $stmt->execute();

        $progs = $stmt->fetchAll();

        $descriptions = $stmt2->fetchAll();

    } catch(PDOException $e) {
        // Display error message if connection fails
        echo "Connection failed: " . $e->getMessage();
    }
    // Set error reporting settings
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Handle logout
    if (isset($_POST['deconnexion'])) {
        include_once('../outils/logout.php');
    }

    // Handle deletion of bonnes pratiques
    if (isset($_POST['delete'])){
        $sqldelete = "UPDATE bonnespratique SET utilisation_bp = 0 WHERE num_bp = ?";
        $stmt = $conn->prepare($sqldelete);
        $stmt->execute([$_POST['delete']]);
        header('Location: ../utilisateur/utilisateur.php');
    }

    // Handle form submission for filtering bonnes pratiques
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
            // Search for keywords by text
            $sqlrecherche .= " AND motcles.mot = :motcle";
            $params['motcle'] = $_POST['recherche'];
        }

        if ($_POST['filtrePhase'] !== "*") {
            // Search for keywords by text
            $sqlrecherche .= " AND phase.nom_phase = :phase";
            $params['phase'] = $_POST['filtrePhase'];
        }

        if ($_POST['filtreProg'] !== "*") {
            // Search for keywords by text
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
    <!-- Top section of the page -->
    <div class="haut">
        <div class="childmid">
            <!-- Filtering section -->
            <div class="filtre">
                <form action="" method="POST">
                    <!-- Dropdown for filtering by phase -->
                    <div class="dropdowns">
                        <div class="dropdown">
                            <label>Filtre par phase</label>
                            <select class="filtre-select" name="filtrePhase">
                                <option value="*">Tous</option>
                                <!-- Generating options dynamically from PHP -->
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
                        <!-- Dropdown for filtering by program -->
                        <div class="dropdown">
                            <label>Filtre par prog</label>
                            <select class="filtre-select" name="filtreProg">
                                <option value="*">Tous</option>
                                <!-- Generating options dynamically from PHP -->
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
                        <!-- Input field for keyword search -->
                        <div>        
                            <label>Recherche par mot clé</label>
                            <input type="text" name="recherche" placeholder="Mot-clé" value="<?= isset($_POST['recherche']) ? $_POST['recherche'] : "" ?>">
                        </div>
                    </div>
                    <!-- Button for submitting the filter form -->
                    <button>Filtrer</button>
                </form>
            </div>
        </div>
        <div class="childmid">
            <!-- Heading for the list of good practices -->
            <h1>Liste des bonnes pratiques</h1>
            <div class="content1">
                <!-- Button for creating a new good practice -->
                <form action="../bp/bp.php">
                    <button class="button-bp"><h2>Créer une bonne pratique</h2></button>
                </form>
            </div>
        </div>
        <div class="child">
            <!-- Form for admin actions -->
            <form action="../admin/admin.php" method="post" class="admin">
                <button type="submit" name="admin" class="button-admin"><h2>ADMIN</h2></button>
            </form>
            <!-- Form for logout action -->
            <form action="" method="post" class="deconnexion">
                <button type="submit" name="deconnexion" class="button-deconnexion"><h2>DÉCONNEXION</h2></button>
            </form>
        </div>
    </div>
    <div class="container">
        <!-- Section for displaying the list of good practices -->
        <div class="BP">
            <!-- Checking if there are any good practices to display -->
            <?php if (count($bps) > 0) : ?>
                <?php foreach ($bps as $bp) : ?>
                    <div class='bonne-pratique'>
                        <div class='info-container'>
                            <div class="checkbox">
                                <input type="checkbox" name="select" value="<?= $bp["num_bp"] ?>" checked>
                            </div>
                            <p>Bonne Pratique: <?= $bp["test_bp"] ?></p>
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
        <!-- Button for validation -->
        <div class="valider">
            <button class="button-pdf"><H2>PDF</H2></button>
            <button class="button-excel"><H2>EXCEL</H2></button>
            
        </div>
    </div>
    <div class="popup">
        <?php if (count($descriptions) > 0) : ?>
            <?php foreach ($descriptions as $desc) : ?>
                <div id="numbp_<?= $desc["num_bp"] ?>" style="display: none">
                    <h2><?= $desc["num_bp"] ?></h2>
                    <p>Bonne Pratique: <?= $desc["test_bp"] ?></p>
                    <!-- Displaying utilization status -->
                    <p>Utilisation: <?= $desc["utilisation_bp"] === 1 ? "oui" : "non" ?></p>
                    <p>Programme: <?= $desc["nom_prog"] ?></p>
                    <p>Phase: <?= $desc["nom_phase"] ?></p>
                    <p>Mot clé: <?= $desc["motcles"] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Displaying a message if no descriptions found -->
            <p>No results found</p>
        <?php endif; ?>
        <button class="close-button">
            Fermer
        </button>
    </div>
    <!-- Including jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Script for handling popup and validation button -->
    <script>
        $(document).ready(function() {
            $(".bonne-pratique-details").on("click", function(e) {
                // Show the popup and display the details of the selected good practice
                $(".popup").addClass("show");
                const numbp = $(e.currentTarget).data('numbp');
                $('.popup').find("#numbp_" + numbp).show();
            });
            
            $(".close-button").on("click", function(e) {
                // Close the popup
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