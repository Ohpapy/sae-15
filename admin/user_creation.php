<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');

    function validatePassword($password, $conn) {
        // Fetch password requirements from the 'mdp' table
        $sqlGETmdp = "SELECT * FROM mdp WHERE num_car = 1";
        $stmtGETmdp = $conn->prepare($sqlGETmdp);
        $stmtGETmdp->execute();
        $requirements = $stmtGETmdp->fetch(PDO::FETCH_ASSOC);
    
        // Check if the password meets the requirements
        $length = strlen($password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
    
        if ($length < $requirements['caractere'] || 
            !$uppercase && $requirements['majuscule'] ||
            !$lowercase && $requirements['minuscule'] ||
            !$number && $requirements['chiffre'] ||
            !$specialChars && $requirements['carac']) {
            return false;
        } else {
            return true;
        }
    }
    
    try {
        $conn = createConnection();          // Creates a connection to the database
        $password = $_POST['mdp_ut'];
    
        if (!validatePassword($password, $conn)) {
            $mess ='Erreur pour la création utilisateur le mot de passe ne convien pas';
            logMessage($conn, $mess, 'ERREUR CREATION UTILISATEUR');
            header('Location: admin.php?erreur'); // Redirect to admin.php
        }
        else {        
            $password = password_hash($password, PASSWORD_DEFAULT);    // Hashes the password
            // Inserting a new best practice into the 'bonnespratique' table
            $sqluser = "INSERT INTO utilisateur (login_ut, nom_ut, mdp_ut, acces_ut, bloque_ut, tentative_ut, presence_ut) VALUES (?,?,?,?,0,0,0)";  
            $stmtuser = $conn->prepare($sqluser);
            $stmtuser->execute([$_POST['login_ut'], $_POST['nom_ut'], $password, $_POST['acces_ut']]);
            $num_user = $conn->lastInsertId();    // Retrieves the ID of the last insertion
            $mess ='Un nouvel utilisateur a été créé avec cet ID: ' . $num_user. ' son login est: ' . $_POST['login_ut'];
            logMessage($conn, $mess, 'CRÉATION UTILISATEUR');
            header('Location: admin.php');
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

    // Configuration to display errors (useful during development)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>