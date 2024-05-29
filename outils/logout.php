<?php
    // Check if a session is not already started, then start a session
    include_once('./outils/bd.php');
    include('../outils/log.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Reset session data by assigning an empty array
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect user to index.php after session is destroyed
    $mess = 'Un utilisateur a été connecté avec ce login: ' . $login . ' à ce moment: ' . date("d/m/Y H:i:s");
    logMessage($conn, $mess, 'DÉCONNEXION UTILISATEUR');
    header('Location: ../index.php');
    // Ensure no further PHP script is executed after redirection
    exit;
?>