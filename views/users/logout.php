<?php
    session_start();

    // Destroy all session data
    session_unset();
    session_destroy();

    // Redirect to login page or homepage after logout
    header("Location: login.php");
    exit();
?>
