<?php
    // Démarrez la session au début de votre fichier
    session_start(); 
    // Ensuite, sur la page admin, vous pouvez vérifier cette variable de session avant d'afficher le contenu
    if ($_SESSION['acces_ut'] != 15) {
        // Si l'utilisateur n'a pas le niveau d'accès requis, redirigez-le vers une autre page
        header('Location: ../utilisateur/utilisateur.php');
        exit();
    }
    // Si l'utilisateur a le niveau d'accès requis, vous pouvez continuer à afficher le contenu de la page
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
                    Ajouter un utilisateur :
                </h2>
                <h3>Nom</h3>
                <input type="text" name="nom_ut" id="nom_ut" required>
                <h3>Identifient </h3>
                <input type="text" name="login_ut">
                <h3>Mot de passe</h3>
                <input type="text" name="mdp_ut" id="mdp_ut" required>
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
            <h2>Ajouter des programmes</h2>
            <form action="prog_creation.php" method="post">
                <div>
                    <label for="nom_prog">Nom du programme:</label>
                    <input type="text" id="nom_prog" name="nom_prog" required>
                </div>
                <div class="valider">
                    <button type="submit" class="button-valider">VALIDER</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>