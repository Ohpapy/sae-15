<?php
    include_once('../outils/bd.php');       // Includes the database connection file
    include('../outils/log.php');

    function validatePassword($password, $conn) {
        // Fetch password requirements from the 'mdp' table
        $sqlgetpwd = "SELECT * FROM mdp WHERE num_car = 1";
        $stmtgetpwd = $conn->prepare($sqlgetpwd);
        $stmtgetpwd->execute();
        $requirements = $stmtgetpwd->fetch(PDO::FETCH_ASSOC);
    
        // Check if the password meets the requirements
        $length = strlen($password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialchars = preg_match('@[^\w]@', $password);
    
        if ($length < $requirements['caractere'] || 
            !$uppercase && $requirements['majuscule'] ||
            !$lowercase && $requirements['minuscule'] ||
            !$number && $requirements['chiffre'] ||
            !$specialchars && $requirements['carac']) {
            return false;
        } else {
            return true;
        }
    }

    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    try {
        $conn = createConnection();          // Creates a connection to the database
        $password = htmlspecialchars($_POST['mdp_ut']);        // Get the password from POST data

        if (!validatePassword($password, $conn)) {
            $mess ='Erreur pour la modification utilisateur le mot de passe ne convien pas';
            logMessage($conn, $mess, 'ERREUR MODIFICATION UTILISATEUR');
            header('Location: admin.php?erreurmodif'); // Redirect to admin.php
            exit; // Ensure the script stops after redirection
        }
        else {        
            $password = password_hash($password, PASSWORD_DEFAULT);    // Hashes the password
            // Inserting a new best practice into the 'bonnespratique' table
            $sqluser = "UPDATE utilisateur SET mdp_ut = ? WHERE login_ut = ?";  
            $stmtbp = $conn->prepare($sqluser);
            $stmtbp->execute([$password, $_POST['usermodif']]);
            $num_bp = $conn->lastInsertId();    // Retrieves the ID of the last insertion
            $mess ='Un utilisateur a été mis à jour avec ce login: ' . $_POST['login_ut'];
            logMessage($conn, $mess, 'MISE À JOUR UTILISATEUR');
            header('Location: ../admin/admin.php');     // Redirects after successful operation
            exit; // Ensure the script stops after redirection
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    } catch(Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
?>