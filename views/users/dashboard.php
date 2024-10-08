<?php
    session_start();
    // Include database and user classes
    require_once '../../classes/Database.php';
    require_once '../../classes/User.php';

    // Check if the admin is logged in
    if (!isset($_SESSION['username']))
    {
        header('Location: login.php');
        exit();
    }
    else
    {
        $username = $_SESSION['username'];
    }

    // Check for flash message and display it
    if (isset($_SESSION['flash_message'])) {
        echo "<div id='flashMessage' class='bg-green-500 text-white p-3 rounded mb-4'>"
            . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']); // Unset the flash message after displaying it
    }

    $database = new Database();
    $db = $database->getConnection();
    $userProfile = new User($db);
    
    $profile = $userProfile->fetchProfile($username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>User Profile</title>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-12 p-8 bg-white shadow-xl rounded-lg max-w-2xl">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">User Profile</h1>
        </div>

        <div class="space-y-6 text-gray-700">
            <div class="flex items-center justify-between border-b pb-4">
                <p class="text-lg font-semibold">Username:</p>
                <p><?php echo $profile['username']; ?></p>
            </div>
            
            <div class="flex items-center justify-between border-b pb-4">
                <p class="text-lg font-semibold">Email:</p>
                <p><?php echo $profile['email']; ?></p>
            </div>
            
            <div class="flex items-center justify-between border-b pb-4">
                <p class="text-lg font-semibold">Password:</p>
                <p><?php echo $profile['password']; ?></p>
            </div>
        </div>

        <div class="mt-8 flex justify-center space-x-6">
            <a href="edit_profile.php" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md transition duration-200 ease-in-out">
                Edit Profile
            </a>
            <a href="delete_account.php?id=<?php echo $profile['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded-md transition duration-200 ease-in-out">
                Delete Account
            </a>
        </div>

        <div class="mt-6 flex justify-center">
            <a href="dashboard.php" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-md transition duration-200 ease-in-out">
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Flash message hide script -->
    <script>
        setTimeout(function() {
            var flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    </script>

</body>
</html>


