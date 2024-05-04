<?php
    include_once('../outils/bd.php');
    try {
        $conn = createConnexion(); 
        // creation bonne pratique
        $sqlbp = "INSERT INTO bonnespratique (test_bp) VALUES (?)";  
        $stmtbp = $conn->prepare($sqlbp);
        $stmtbp->execute([$_POST['item']]);
        $num_bp = $conn->lastInsertId();
        // jointure avec l'apparatenance
        $sqlapp = "INSERT INTO appartenance (num_prog, num_phase, num_bp) VALUES (?, ?, ?)";
        $stmtapp = $conn->prepare($sqlapp);
        $stmtapp->execute([$_POST['programme'], $_POST['phase'], $num_bp]);
        $motcles = explode(";", $_POST['motcles']);
        // creation des mots cles et jointure des mot cles
        foreach ($motcles as $motcle) {
            $sqlselectmc = "SELECT * FROM motcles WHERE mot = ?";
            $stmtselectmc = $conn->prepare($sqlselectmc);
            $stmtselectmc->execute([$motcle]);
            $existemc = $stmtselectmc->fetch();
            $num_cle = $existemc['num_cles'];
            if (!$existemc) {
                $sqlmc = "INSERT INTO motcles (mot) VALUES (?)";
                $stmtmc = $conn->prepare($sqlmc);
                $stmtmc->execute([$motcle]);
                $num_cle = $conn->lastInsertId();
            }
            $sqlbpmc = "INSERT INTO bp_motcles (num_bp,num_cles) VALUES (?,?)";
            $stmtbpmc = $conn->prepare($sqlbpmc);
            $stmtbpmc->execute([$num_bp, $num_cle]);
        }
        header('Location: ../utilisateur/utilisateur.php');
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>