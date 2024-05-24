<?php
    include_once('../outils/bd.php');
    try {
        $conn = createConnection();  
        if (isset($_POST['delete'])){
            // Delete the corresponding rows from 'bp_motcles' first
            $sqlDeleteKeywords = "DELETE FROM bp_motcles WHERE num_bp = ?";
            $stmtDeleteMotCles = $conn->prepare($sqlDeleteKeywords);
            $stmtDeleteMotCles->execute([$_POST['num_bp']]);
            
            // Then delete the corresponding rows from 'appartenance'
            $sqlDeleteAppartenance = "DELETE FROM appartenance WHERE num_bp = ?";
            $stmtDeleteAppartenance = $conn->prepare($sqlDeleteAppartenance);
            $stmtDeleteAppartenance->execute([$_POST['num_bp']]);
            
            // Now delete the row from 'bonnespratique'
            $sqlsupp = "DELETE FROM bonnespratique WHERE num_bp = ?";
            $stmtsupp = $conn->prepare($sqlsupp);
            $stmtsupp->execute([$_POST['num_bp']]);
            
            header('Location: ../admin/admin.php');
        }
        else {
            $sqlUpdateBP = "UPDATE bonnespratique SET utilisation_bp = 1 WHERE num_bp = ?";
            $stmtUpdateBP = $conn->prepare($sqlUpdateBP);
            $stmtUpdateBP->execute([$_POST['num_bp']]);
            header('Location: ../admin/admin.php');
        }   
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Displays an error message in case of connection failure
    }
?>