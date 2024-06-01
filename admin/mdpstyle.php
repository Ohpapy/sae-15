<?php
    include_once('../outils/bd.php');
    include_once('../outils/log.php');    
    // mdpstyle.php
    try {
        $conn = createConnection();          // Creates a connection to the database
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $caractere = $_POST['caractere'];
            $chiffre = $_POST['chiffre'];
            $majuscule = $_POST['majuscule'];
            $minuscule = $_POST['minuscule'];
            $carac = isset($_POST['carac']) ? 1 : 0;
        }
        $sql = "UPDATE mdp SET caractere = ?, chiffre = ?, majuscule = ?, minuscule = ?, carac = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$caractere, $chiffre, $majuscule, $minuscule, $carac]);
        $mess ='La forme des mots de passe a été changée';
        logMessage($conn, $mess, 'MODIFICATION FORME MOT DE PASSE');
        header('Location: ../admin/admin.php');     // Redirects after successful operation         
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }

?>