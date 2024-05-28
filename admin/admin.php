<?php
    // Start the session at the beginning of your file
    session_start(); 
    // Then, on the admin page, you can check this session variable before displaying the content
    include_once('../outils/bd.php');
    try {
        $conn = createConnection();  
        $sqlbp = "SELECT * FROM bonnespratique WHERE utilisation_bp = 0";
        $resultbp = $conn->prepare($sqlbp);
        $resultbp->execute();
        $bps = $resultbp->fetchAll(); 
        $sqlprog = "SELECT * FROM programme";
        $resultprog = $conn->prepare($sqlprog);
        $resultprog->execute();
        $progs = $resultprog->fetchAll();
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();   // Displays an error message in case of connection failure
    }
    if ($_SESSION['acces_ut'] != 15) {
        // If the user does not have the required access level, redirect them to another page
        header('Location: ../utilisateur/utilisateur.php');
        exit();
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
                <br>
                <br>
                <br>
                <form action="unlock.php" method="post">
                    <h2>
                        Débloquer un utilisateur
                    </h2>
                    <h3>Identifiant </h3>
                    <input type="text" name="login_ut" class="text-place">
                    <div class="valider">
                        <button type="submit" class="button-valider">Débloqué</button>
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
                <form action="prog_supp.php" method="post">
                    <div>
                        <p>Attention si vous supprimer un programme toute les bonnes pratique assosier le seront aussi</p>
                        <div>
                            <select name="num_prog" id="num_prog">
                                <?php if (count($progs) > 0) : ?>
                                    <?php foreach ($progs as $prog) : ?>
                                        <option value="<?= $prog["num_prog"] ?>"><?= $prog["nom_prog"] ?></option>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <h4>Supprimer</h4>
                        <input type="checkbox" name="delete" id="delete" checked>
                        <label for="delete">Oui</label>
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
                            <?php if (count($bps) > 0) : ?>
                                <?php foreach ($bps as $bp) : ?>
                                    <option value="<?= $bp["num_bp"] ?>"><?= $bp["test_bp"] ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div>
                        <h4>Supprimer</h4>
                        <input type="checkbox" name="delete" id="delete">
                        <label for="delete">Oui</label>
                    </div>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                </form>
            </div>
            <div class="box">
                <h2>Télécharger Logs</h2>
                <form method="post" action="logs.php">
                    <button type="submit" class="button-valider">Voir Logs</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bas">
        <a href="../utilisateur/utilisateur.php" class="home">Accueil</a>
    </div>
</body>
</html>