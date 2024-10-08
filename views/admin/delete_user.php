<?php
    session_start();
    // Include database and admin classes
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';

    // Check if the admin is logged in
    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit();
    }

    // Database and Admin initialization
    $database = new Database();
    $db = $database->getConnection();
    $admin = new Admin($db);

    // Check if ID is provided
    if (isset($_GET['id'])) {
        // Attempt to delete the user
        if ($admin->deleteUser($_GET['id'])) {
            $_SESSION['flash_message'] = "User deleted successfully!";
        } else {
            $_SESSION['flash_message'] = "Failed to delete user.";
        }
    } else {
        $_SESSION['flash_message'] = "No user ID provided!";
    }

    // Redirect back to the admin dashboard
    header("Location: admin_dashboard.php");
    exit();
