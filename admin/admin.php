<?php
    // Démarrez la session au début de votre fichier
    session_start(); 
    // Ensuite, sur la page admin, vous pouvez vérifier cette variable de session avant d'afficher le contenu
    include_once('../outils/bd.php');
    if ($_SESSION['acces_ut'] != 15) {
        // Si l'utilisateur n'a pas le niveau d'accès requis, redirigez-le vers une autre page
        header('Location: ../utilisateur/utilisateur.php');
        exit();
    }
    try {
        $conn = createConnexion();  
        $sqlbp = "SELECT * FROM bonnespratique WHERE utilisation_bp = 0";
        $resultbp = $conn->prepare($sqlbp);
        $resultbp->execute();
        $bps = $resultbp->fetchAll(); 
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="all-box">
        <div class="box">
            <form action="user_creation.php" method="post">
                <h2>
                    Ajouter un utilisateur 
                </h2>
                <h3>Nom</h3>
                <input type="text" name="nom_ut" id="nom_ut" required class="text-place">
                <h3>Identifiant: </h3>
                <input type="text" name="login_ut" class="text-place">
                <h3>Mot de passe</h3>
                <input type="text" name="mdp_ut" id="mdp_ut" required class="text-place">
                <h4>Privilège</h4>
                <select name="acces_ut" id="acces_ut" required> 
                    <option value="1">Utilisateur</option>
                    <option value="15">Administrateur</option>
                </select>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
        <div class="box">
            <form action="user_update.php" method="post">
                <h2>
                    Modifier mot de passe
                </h2>
                <h3>Identifiant </h3>
                <input type="text" name="login_ut" class="text-place">
                <h3>Mot de passe</h3>
                <input type="text" name="mdp_ut" id="mdp_ut" required class="text-place">
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
        <div class="box">
            <h2>Ajouter des programmes</h2>
            <form action="prog_creation.php" method="post">
                <div>
                    <label for="nom_prog">Nom du programme:</label>
                    <input type="text" id="nom_prog" name="nom_prog" required class="text-place">
                </div>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
        <div class="box">
            <h2>Supprimer Bonne Pratique</h2>
            <form action="bp_sup.php" method="post">
                <div>
                    <select name="num_bp" id="num_bp">
                        <?php foreach ($bps as $bp) { ?>
                            <option value="<?php echo $bp['num_bp']; ?>"><?php echo $bp['nom_bp']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>