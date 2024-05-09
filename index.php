<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once('./outils/bd.php');
    try {
        $bd = createConnexion();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login = htmlspecialchars($_POST['login']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $req = $bd->prepare('SELECT * FROM utilisateur WHERE login_ut = :login'); // On prépare la requête
            $req->execute(array('login' => $login)); // On exécute la requête en passant les paramètres
            $user = $req->fetch(); // On récupère le résultat

            if ($user["bloque_ut"] != 1) {
                if (!password_verify($mdp, $user['mdp_ut'])) {
                    echo 'Mauvais identifiant ou mot de passe !';
                    sleep(2);
                    $tentative = $user['tentative_ut'] + 1;
                    $sqltentative = $bd->prepare('UPDATE utilisateur SET tentative_ut = :tentative WHERE login_ut = :login');
                    $sqltentative->execute(array('tentative' => $tentative, 'login' => $login));
                    if ($tentative >= 3) {
                        $sqlblock = $bd->prepare('UPDATE utilisateur SET bloque_ut = 1 WHERE login_ut = :login');
                        $sqlblock->execute(array('login' => $login));
                        echo 'Compte bloqué !';
                    }
                } else {
                    session_start();
                    $_SESSION['id'] = $resultat['id'];
                    $_SESSION['login'] = $login;
                    header('Location: ./utilisateur/utilisateur.php');
                    $sqlclean = $bd->prepare('UPDATE utilisateur SET tentative_ut = 0 WHERE login_ut = :login');
                    $sqlclean->execute(array('login' => $login));
                }
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
    <link rel="stylesheet" href="./css/login.css">
    <?php include_once('outils/header.php'); ?>
    <title>Connexion</title>
</head>
<body>
    <h1>Bienvenue !</h1>
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