<?php
    // Set error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include database connection
    include_once('./outils/bd.php');
    include_once('./outils/log.php');
    try {
        // Create database connection
        $conn = createConnection();

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input data
            $login = htmlspecialchars($_POST['login']);
            $mdp = htmlspecialchars($_POST['mdp']);

            // Prepare and execute SQL query to fetch user data
            $req = $conn->prepare('SELECT * FROM utilisateur WHERE login_ut = :login'); // We prepare the request
            $req->execute(array('login' => $login)); // We execute the request with the login parameter
            $user = $req->fetch(); // We fetch the result

            // Check if the user is not blocked
            if ($user["bloque_ut"] != 1) {
                // Verify password
                if (!password_verify($mdp, $user['mdp_ut'])) {
                    // Display error message for wrong credentials
                    $mess ='l\' utilisateur s\'est trompé: ' . $user['nom_ut'];
                    logMessage($conn, $mess, 'MOT DE PASSE INCORRECT');
                    header('location: index.php?ErreurConnexion');

                    // Increment login attempts and update database
                    sleep(1);
                    $tentative = $user['tentative_ut'] + 1;
                    $sqltentative = $conn->prepare('UPDATE utilisateur SET tentative_ut = :tentative WHERE login_ut = :login');
                    $sqltentative->execute(array('tentative' => $tentative, 'login' => $login));

                    // Block account if login attempts exceed 3
                    if ($tentative >= 3) {
                        $sqlblock = $conn->prepare('UPDATE utilisateur SET bloque_ut = 1 WHERE login_ut = :login');
                        $sqlblock->execute(array('login' => $login));
                        $mess ='Un utilisateur est bloqué' . $login;
                        logMessage($conn, $mess, 'BLOCAGE UTILISATEUR');
                        header('Refresh: 3; URL=./index.php?blocked');
                    }
                } else {
                    // Start session and redirect to user page on successful login
                    $_SESSION['login'] = $login;
                    $_SESSION['acces_ut'] = $user['acces_ut'];
                    $_SESSION['nom_ut'] = $user['nom_ut'];
                    $mess ='Un utilisateur est connecté: ' . $user['nom_ut'];
                    logMessage($conn, $mess, 'UTILISATEUR CONNECTÉ');
                    header('Location: ./utilisateur/utilisateur.php');

                    // Reset login attempts in the database
                    $sqlclean = $conn->prepare('UPDATE utilisateur SET tentative_ut = 0 WHERE login_ut = :login');
                    $sqlclean->execute(array('login' => $login));
                }
            }
            else {
                $mess ='Un utilisateur essaye de ce connecter avec un compet bloqué: ';
                logMessage($conn, $mess, 'TENTATIVE DE CONNEXION');
                header('location: index.php?blocked');
            }

            // Close database connection and exit
            $req->closeCursor();
            $conn = null;
            exit();
        }
    } catch (PDOException $e) {
        // Handle connection errors
        echo 'Connexion échouée : ' . $e->getMessage();
    }
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
    <?php
        // Display error message for blocked account
        if (isset($_GET['blocked'])) {
            echo '<h3 style="text-align: center;color: white;">Compte bloqué !</h3>';
        }
        if (isset($_GET['ErreurConnexion'])) {
            echo '<h3 style="text-align: center;color: white;">Mauvais identifiant ou mot de passe !</h3>';
        }
    ?>
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