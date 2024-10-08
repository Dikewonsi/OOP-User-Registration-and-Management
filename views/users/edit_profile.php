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
 

    $database = new Database();
    $db = $database->getConnection();
    $userProfile = new User($db);
    $profile = $userProfile->fetchProfile($username);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $username;
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if ($userProfile->updateUser($email, $password, $username)) {
            // Redirect to profile view with success message
            $_SESSION['flash_message'] = "Profile updated successfully!";
            header("Location: dashboard.php");
        } else {
            $_SESSION['flash_message'] = "Failed to update profile.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Profile</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-12 p-8 bg-white shadow-xl rounded-lg max-w-md">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Edit Profile</h1>

        <!-- Back Home Button -->
        <div class="mb-8 text-center">
            <a href="dashboard.php" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-md transition duration-200 ease-in-out">
                Back Home
            </a>
        </div>

        <!-- Profile Edit Form -->
        <form method="POST" action="">
            <div class="mb-6">
                <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $profile['email']; ?>" 
                    class="border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold text-gray-700 mb-2">Password:</label>
                <input type="text" name="password" id="password" value="<?php echo $profile['password']; ?>" 
                    class="border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200 ease-in-out">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript for any future flash messages -->
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
