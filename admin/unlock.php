<?php
    include_once('../outils/bd.php');
    include('../outils/log.php');
    try {
        $conn = createConnection();  
        $sqlunlock = "UPDATE utilisateur SET bloque_ut = 0, tentative_ut = 0 WHERE login_ut = ?";
        $stmtunlock = $conn->prepare($sqlunlock);
        $stmtunlock->execute([$_POST['userdebloq']]);
        $mess ='Un utilisateur a été débloqué avec ce login: ' . $_POST['userdebloq'];
        logMessage($conn, $mess, 'UTILISATEUR DÉBLOQUÉ');
        header('Location: ../admin/admin.php');  
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
?>