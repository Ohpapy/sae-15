<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    try {
        $bd = new PDO ( "mysql:host=localhost;dbname=RP09", "RP09", "RP09" );
        $bd->exec('SET NAMES utf8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login = htmlspecialchars($_POST['login']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $req = $bd->prepare('SELECT * FROM utilisateur WHERE login_ut = :login AND mdp_ut = :mdp'); // On prépare la requête
            $req->execute(array('login' => $login, 'mdp' => $mdp)); // On exécute la requête en passant les paramètres
            $resultat = $req->fetch(); // On récupère le résultat
            if (!$resultat) {
                echo 'Mauvais identifiant ou mot de passe !';
                sleep(2);
                header('Location: ./index.php');
            } else {
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['login'] = $login;
                header('Location: ./utilisateur/utilisateur.php');
            }
            $req->closeCursor();
            $bd = null;
            exit();
        }
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Login.css">
    <title>Connexion</title>
</head>
<body>
    <H1>Bienvenue !</H1>
    <div class="container">
        <form method="post" action="index.php">            
            <div>
                <h4>Nom utilisateur</h4>
                <input type="text" name="login" required autofocus>
            </div>
            <div>
                <h4>Mot de passe</h4>
                <input type="password" name="mdp" required>
            </div>
            <div class="connection">
                <button class="button-connection" type="submit"><h2>Connexion</h2></button>
            </div>
        </form>
    </div>
</body>
</html>