<?php
    // Start the session at the beginning of your file
    session_start(); 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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

        $sqlgetuser = "SELECT * FROM utilisateur";
        $stmtgetuser = $conn->prepare($sqlgetuser);
        $stmtgetuser->execute();
        $users = $stmtgetuser->fetchAll();

        $sqlgetuserblocked = "SELECT * FROM utilisateur WHERE bloque_ut = 1";
        $stmtgetuserblocked = $conn->prepare($sqlgetuserblocked);
        $stmtgetuserblocked->execute();
        $usersblocked = $stmtgetuserblocked->fetchAll();

        $sqlgetpwdform = "SELECT caractere, chiffre, majuscule, minuscule, carac FROM mdp LIMIT 1";
        $stmtgetpwdform = $conn->prepare($sqlgetpwdform);
        $stmtgetpwdform->execute();
        $pwdform = $stmtgetpwdform->fetch();
        $default_character = $pwdform['caractere'];
        $default_number = $pwdform['chiffre'];
        $default_capital = $pwdform['majuscule'];
        $default_minuscule = $pwdform['minuscule'];
        $default_charac = $pwdform['carac'];
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();   // Displays an error message in case of connection failure
    }
    if ($_SESSION['acces_ut'] != 15) {
        // If the user does not have the required access level, redirect them to another page
        header('Location: ../utilisateur/utilisateur.php');
        exit();
    }
    if (isset($_POST['suprimerlogs'])) { 
        $sqldeletelog = "DELETE FROM logs;";
        $stmtlogs = $conn->prepare($sqldeletelog);
        $stmtlogs->execute();
        header('Location: admin.php');
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
                    <?php if (isset($_GET['erreur'])) : ?>
                        <h3>Erreur pour la création utilisateur le mot de passe ne convient pas</h3>
                    <?php endif ?>
                    <h3>Nom:</h3>
                    <input type="text" name="nom_ut" id="nom_ut" required class="text-place">
                    <h3>Identifiant: </h3>
                    <input type="text" name="login_ut" class="text-place">
                    <h3>Mot de passe:</h3>
                    <input type="text" name="mdp_ut" id="mdp_ut" required class="text-place">
                    <h4>Privilège</h4>
                    <select name="acces_ut" id="acces_ut" required> 
                        <option value="1">Utilisateur</option>
                        <option value="15">Administrateur</option>
                    </select>
                    <br>
                    <br>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                </form>
                <form action="user_delete.php" method="post">
                    <h2>
                        Supprimer un utilisateur 
                    </h2>
                    <h3>Identifiant: </h3>
                    <select name="usersupp" id="usersupp" style="width: 200px; text-overflow: ellipsis; text-align: center;">
                        <?php if (count($users) > 0) : ?>
                            <!-- Deleting a user from a drop-down menu -->
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user["login_ut"] ?>"><?= $user["login_ut"] ?></option>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </select>
                    <br>
                    <br>
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
                    <?php if (isset($_GET['erreurmodif'])) : ?>
                        <h3>Erreur pour la création utilisateur le mot de passe ne convient pas</h3>
                    <?php endif ?>
                    <h3>Identifiant </h3>
                    <select name="usermodif" id="usermodif" style="width: 200px; text-overflow: ellipsis; text-align: center;">
                        <?php if (count($users) > 0) : ?>
                            <!--Change your password from a drop-down menu-->
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user["login_ut"] ?>"><?= $user["login_ut"] ?></option>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </select>
                    <h3>Mot de passe</h3>
                    <input type="text" name="mdp_ut" id="mdp_ut" required class="text-place">
                    <br>
                    <br>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                </form>
                <br>
                <form action="unlock.php" method="post">
                    <h2>
                        Débloquer un utilisateur
                    </h2>
                    <h3>Identifiant </h3>
                    <select name="userdebloq" id="userdebloq" style="width: 200px; text-overflow: ellipsis; text-align: center;">
                        <?php if (count($usersblocked) > 0) : ?>
                            <!-- unblock a user from a drop-down menu -->
                            <?php foreach ($usersblocked as $userblocked) : ?>
                                <option value="<?= $userblocked["login_ut"] ?>"><?= $userblocked["login_ut"] ?></option>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </select>
                    <br>
                    <br>
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
                    <br>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                </form>
                <br>
                <br>
                <br>
                <form action="prog_supp.php" method="post">
                    <div>
                        <label for="nom_prog"><b>Supprimer un programme:</b></label>
                        <div>
                            <select name="num_prog" id="num_prog">
                                <?php if (count($progs) > 0) : ?>
                                     <!-- Delete a program from a drop-down menu -->
                                    <?php foreach ($progs as $prog) : ?>
                                        <option value="<?= $prog["num_prog"] ?>"><?= $prog["nom_prog"] ?></option>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <br>
                        <label for="delete">Es-tu sûr ?</label>
                        <input type="checkbox" name="delete" id="delete" checked>
                    </div>
                    <br>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                    <p>Attention si vous supprimez un programme toutes les bonnes pratiques associées le seront aussi</p>
                </form>
            </div>
            <div class="box">
                <h2>Supprimer Bonne Pratique</h2>
                <form action="bp_sup.php" method="post">
                    <div>
                    <select name="num_bp" id="num_bp" style="width: 200px; text-overflow: ellipsis;">
                        <?php if (count($bps) > 0) : ?>
                             <!-- Delete bp from a drop-down menu -->
                            <?php foreach ($bps as $bp) : ?>
                                <option value="<?= $bp["num_bp"] ?>" title="<?= $bp["test_bp"] ?>"><?= $bp["test_bp"] ?></option>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </select>
                    </div>
                    <div>
                        <h4>Cocher pour supprimer. Si tu ne coche pas elles redeviennent visible pour tous</h4>
                        <input type="checkbox" name="delete" id="delete">
                        <label for="delete">Oui</label>
                    </div>
                    <br>
                    <div class="valider">
                        <button type="submit" class="button-valider">VALIDER</button>
                    </div>
                </form>
            </div>
            <div class="box">
                <h2>Logs</h2>
                <form method="post" action="logs.php">
                    <button type="submit" class="button-valider">Voir les logs</button>
                </form>
                <br>
                <br>
                <br>
                <form action="" method="post">
                    <input type="submit" name="suprimerlogs" value="supprimer log" class="button-valider">
                </form>
            </div>
            <div class="box">
                <h2>Forme d'un mot de passe</h2>
                <form method="post" action="mdpstyle.php">
                    <h3>Nombre de caractère</h3>
                    <input type="number" name="caractere" min="1" max="30" value="<?php echo $default_character; ?>" class="center">
                    <h3>Nombre de chiffre</h3>
                    <input type="number" name="chiffre" value="<?php echo $default_number; ?>" class="center">
                    <h3>Nombre de majuscule</h3>
                    <input type="number" name="majuscule" value="<?php echo $default_capital; ?>" class="center">
                    <h3>Nombre de minuscule</h3>
                    <input type="number" name="minuscule" value="<?php echo $default_minuscule; ?>" class="center">
                    <h3>Caractères spéciaux</h3>
                    <input type="checkbox" name="carac" <?php if ($default_charac == 1) echo 'checked'; ?>>
                    <br>
                    <br>
                    <button type="submit" class="button-valider">valider</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bas">
        <a href="../utilisateur/utilisateur.php" class="home">Accueil</a>
    </div>
</body>
</html>