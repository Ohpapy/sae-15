<?php
    // Set error reporting
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include database connection
    include_once('./outils/bd.php');
    try {
        // Create database connection
        $bd = createConnection();

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input data
            $login = htmlspecialchars($_POST['login']);
            $mdp = htmlspecialchars($_POST['mdp']);

            // Prepare and execute SQL query to fetch user data
            $req = $bd->prepare('SELECT * FROM utilisateur WHERE login_ut = :login'); // On prépare la requête
            $req->execute(array('login' => $login)); // On exécute la requête en passant les paramètres
            $user = $req->fetch(); // On récupère le résultat

            // Check if the user is not blocked
            if ($user["bloque_ut"] != 1) {
                // Verify password
                if (!password_verify($mdp, $user['mdp_ut'])) {
                    // Display error message for wrong credentials
                    echo 'Mauvais identifiant ou mot de passe ! Vous serez redirigé dans 3 secondes.';
                    header('Refresh: 3; URL=./index.php');

                    // Increment login attempts and update database
                    sleep(1);
                    $tentative = $user['tentative_ut'] + 1;
                    $sqltentative = $bd->prepare('UPDATE utilisateur SET tentative_ut = :tentative WHERE login_ut = :login');
                    $sqltentative->execute(array('tentative' => $tentative, 'login' => $login));

                    // Block account if login attempts exceed 3
                    if ($tentative >= 3) {
                        $sqlblock = $bd->prepare('UPDATE utilisateur SET bloque_ut = 1 WHERE login_ut = :login');
                        $sqlblock->execute(array('login' => $login));
                        echo 'Compte bloqué !';
                    }
                } else {
                    // Start session and redirect to user page on successful login
                    session_start();
                    $_SESSION['id'] = $resultat['id'];
                    $_SESSION['login'] = $login;
                    $_SESSION['acces_ut'] = $user['acces_ut'];
                    header('Location: ./utilisateur/utilisateur.php');

                    // Reset login attempts in the database
                    $sqlclean = $bd->prepare('UPDATE utilisateur SET tentative_ut = 0 WHERE login_ut = :login');
                    $sqlclean->execute(array('login' => $login));
                }
            }
            else {
                // Display error message for blocked account
                echo 'Compte bloqué ! Vous serez redirigé dans 3 secondes.';
                header('Refresh: 3; URL=./index.php');
            }

            // Close database connection and exit
            $req->closeCursor();
            $bd = null;
            exit();
        }
    } catch (PDOException $e) {
        // Handle connection errors
        echo 'Connexion échouée : ' . $e->getMessage();
    }
?>

<?php
#$month = "[" .date("d")."/". date("m")."/". date("Y")."]"; #variable which shows us the date on which we logged in
#$hour = "[" .date("H").":". date("i").":". date("s")."]"; #variable which shows us the time at which we logged on
#$url = $_SERVER['REMOTE_ADDR']."connect to" .$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; #Shows who logged on to our site, at what time and when 
#$fp = fopen("log.txt", "a"); #Open the log.txt file in add mode
#fputs($fp, $month." ".$hour." ".$url."\n"); #We write to the log.txt file
#fclose($fp); #Close the log.txt file
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Include CSS file -->
    <link rel="stylesheet" href="./css/login.css">
    <?php include_once('outils/header.php'); ?>
    <title>Connexion</title>
</head>
<body>
    <!-- Page title -->
    <h1>Bienvenue !</h1>

    <!-- Login form -->
    <div class="container">
        <form method="post" action="index.php">            
            <div>
                <!-- Username input -->
                <h4>Nom utilisateur</h4>
                <input type="text" name="login" required autofocus>
            </div>
            <div>
                <!-- Password input -->
                <h4>Mot de passe</h4>
                <input type="password" name="mdp" required>
            </div>
            <div class="connection">
                <!-- Submit button -->
                <button class="button-connection" type="submit"><h2>Connexion</h2></button>
            </div>
        </form>
    </div>
</body>
</html>