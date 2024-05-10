<?php
    include_once('../outils/bd.php');       // Inclut le fichier de connexion à la base de données

    try {
        $conn = createConnexion();          // Crée une connexion à la base de données

        // Insertion d'une nouvelle bonne pratique dans la table 'bonnespratique'
        $sqlbp = "INSERT INTO bonnespratique (test_bp) VALUES (?)";  
        $stmtbp = $conn->prepare($sqlbp);
        $stmtbp->execute([$_POST['item']]);
        $num_bp = $conn->lastInsertId();    // Récupère l'ID de la dernière insertion

        // Jointure avec l'appartenance à un programme et une phase dans la table 'appartenance'
        $sqlapp = "INSERT INTO appartenance (num_prog, num_phase, num_bp) VALUES (?, ?, ?)";
        $stmtapp = $conn->prepare($sqlapp);
        $stmtapp->execute([$_POST['programme'], $_POST['phase'], $num_bp]);

        $motcles = explode(";", $_POST['motcles']);      // Sépare les mots-clés par ';'

        // Création des mots-clés et jointure des mots-clés dans la table 'motcles' et 'bp_motcles'
        foreach ($motcles as $motcle) {
            $sqlselectmc = "SELECT * FROM motcles WHERE mot = ?";
            $stmtselectmc = $conn->prepare($sqlselectmc);
            $stmtselectmc->execute([trim($motcle)]);        // Recherche si le mot-clé existe déjà
            $existemc = $stmtselectmc->fetch();
            $num_cle = $existemc['num_cles'];           // Récupère l'ID du mot-clé existant

            if (!$existemc) {               // Si le mot-clé n'existe pas, l'insère dans la table 'motcles'
                $sqlmc = "INSERT INTO motcles (mot) VALUES (?)";
                $stmtmc = $conn->prepare($sqlmc);
                $stmtmc->execute([trim($motcle)]);
                $num_cle = $conn->lastInsertId();       // Récupère l'ID du nouveau mot-clé
            }

            // Insère la relation entre la bonne pratique et le mot-clé dans la table 'bp_motcles'
            $sqlbpmc = "INSERT INTO bp_motcles (num_bp,num_cles) VALUES (?,?)";             
            $stmtbpmc = $conn->prepare($sqlbpmc);
            $stmtbpmc->execute([$num_bp, $num_cle]);
        }

        header('Location: ../utilisateur/utilisateur.php');     // Redirige après l'opération réussie
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();        // Affiche un message d'erreur en cas d'échec de connexion
    }
    
    // Configuration pour afficher les erreurs (utile lors du développement)
    ini_set('display_errors', 1);           
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>