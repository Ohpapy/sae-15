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
<div class="main">
        <div class="left">
            <h2>
                Ajouter Un utilisateur :
            </h2>
            <h3>NOM : </h3>
            <input type="text" name="nom" id="nom" required>

            <h3>MOT DE PASSE : </h3>
            
            <input type="text" name="mot-de-passe" id="mdp" required>
            
            <h4>PRIVILEGE :</h4>
            
            <select name="privilege" id="privilege" required>
        </div>
        <div class="center">
            <h2>Ajouter des programmes :</h2>
            <form action="add_programme.php" method="post">
                <div>
                    <label for="nom_prog">Nom du programme:</label>
                    <input type="text" id="nom_prog" name="nom_prog" required>
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
                </div>
            </form>
        </div>
    </div>
</body>
</html>