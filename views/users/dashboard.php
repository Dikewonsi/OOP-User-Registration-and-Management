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
<body class="bg-gradient-to-r from-gray-100 to-gray-300 min-h-screen flex items-center justify-center">

    <div class="container mx-auto p-8 bg-white shadow-2xl rounded-lg max-w-3xl">
        <!-- Profile Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">Welcome, <?php echo $profile['username']; ?></h1>
            <p class="text-lg text-gray-600">Manage your account settings and preferences below</p>
        </div>

        <!-- Profile Info -->
        <div class="grid grid-cols-1 gap-6 text-gray-700">
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md shadow-sm">
                <p class="text-lg font-semibold">Username:</p>
                <p><?php echo $profile['username']; ?></p>
            </div>
            
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md shadow-sm">
                <p class="text-lg font-semibold">Email:</p>
                <p><?php echo $profile['email']; ?></p>
            </div>
            
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md shadow-sm">
                <p class="text-lg font-semibold">Password:</p>
                <p>••••••••</p> <!-- Masking the password for security -->
            </div>
        </div>

        <!-- Profile Actions -->
        <div class="mt-10 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="edit_profile.php" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-md font-medium transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                    Edit Profile
                </a>
                <a href="delete_account.php?id=<?php echo $profile['id']; ?>" class="bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-md font-medium transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                    Delete Account
                </a>
            </div>
            <a href="logout.php" class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-md font-medium transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                Logout
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




