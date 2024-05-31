<?php
    include_once('../outils/bd.php');
    // Check if a session is not already started, then start a session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Reset session data by assigning an empty array
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect user to index.php after session is destroyed
    header('Location: ../index.php');
    // Ensure no further PHP script is executed after redirection
    exit;
?>