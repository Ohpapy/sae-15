<?php
    include_once('../outils/bd.php');
    include('../outils/log.php');
    try {
        $conn = createConnection();  
        $sqlUnlock = "UPDATE utilisateur SET bloque_ut = 0, tentative_ut = 0 WHERE login_ut = ?";
        $stmtUnlock = $conn->prepare($sqlUnlock);
        $stmtUnlock->execute([$_POST['login_ut']]);
        $mess ='Unutilisateur a été débloqué avec ce login: ' . $_POST['login_ut'];
        logMessage($conn, $mess, 'UTILISATEUR DÉBLOQUÉ');
        header('Location: ../admin/admin.php');  
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
?>