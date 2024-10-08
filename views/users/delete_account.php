<?php
    session_start();
    // Include database and user classes
    require_once '../../classes/Database.php';
    require_once '../../classes/User.php';

    $database = new Database();
    $db = $database->getConnection();
    $userProfile = new User($db);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userProfile->username = $_SESSION['username'];
        
        if ($userProfile->deleteAccount()) {
            // Logout and redirect to home page
            session_destroy();

            // $_SESSION['flash_message'] = "Profile updated successfully!";
            header("Location: login.php");
        } else {
            echo "Failed to delete account.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Delete Account</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-5">Delete Account</h1>
        <form method="POST">
            <p class="text-lg mb-4">Are you sure you want to delete your account?</p>
            <div class="flex justify-center">
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Yes, Delete</button>
            </div>
        </form>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="text-blue-500 hover:underline">Cancel</a>
        </div>
    </div>
</body>
</html>
