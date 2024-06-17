<?php
    session_start();
    include_once('../outils/bd.php');
    include('../outils/log.php'); 
    try {
        $conn = createConnection();  
        if (isset($_POST['delete'])){
            // Delete the corresponding rows from 'bp_motcles' first
            $sqldelete_keywords = "DELETE FROM bp_motcles WHERE num_bp = ?";
            $stmtdelete_keywords = $conn->prepare($sqldelete_keywords);
            $stmtdelete_keywords->execute([$_POST['num_bp']]);
            
            // Then delete the corresponding rows from 'appartenance'
            $sqldelete_appartenance = "DELETE FROM appartenance WHERE num_bp = ?";
            $stmtdelete_appartenance = $conn->prepare($sqldelete_appartenance);
            $stmtdelete_appartenance->execute([$_POST['num_bp']]);
            
            // Now delete the row from 'bonnespratique'
            $sqlsupp = "DELETE FROM bonnespratique WHERE num_bp = ?";
            $stmtsupp = $conn->prepare($sqlsupp);
            $stmtsupp->execute([$_POST['num_bp']]);
            
            $mess ='Une bp a été supprimée avec cet ID: ' . $_POST['num_bp'];
            logMessage($conn, $mess, 'SUPPRESSION BP');
            header('Location: ../admin/admin.php');
        }
        else {
            $sqlupdatebp = "UPDATE bonnespratique SET utilisation_bp = 1 WHERE num_bp = ?";
            $stmtupdatebp = $conn->prepare($sqlupdatebp);
            $stmtupdatebp->execute([$_POST['num_bp']]);
            $mess ='Une bp a été remise en utilisation avec cet ID: ' . $_POST['num_bp'];
            logMessage($conn, $mess, 'REMISE EN UTILISATION BP');
            header('Location: admin.php');
        }   
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
?>