<?php
    session_start();
    // Include database and user classes
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

    // Fetch user data if ID is provided
    if (isset($_GET['id'])) {
        $user = $admin->fetchUserById($_GET['id']);

        if (!$user) {
            echo "User not found!";
            exit();
        }
    } else {
        echo "No user ID provided!";
        exit();
    }

    // Update user details when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Update user data
        if ($admin->updateUser($_GET['id'], $username, $email, $password)){
            $_SESSION['flash_message'] = "User updated successfully!";
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['flash_message'] = "Failed to update user!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>

        <!-- Edit User Form -->
        <form action="" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" 
                    class="border border-gray-400 p-2 w-full">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                    class="border border-gray-400 p-2 w-full">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>" 
                    class="border border-gray-400 p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update User</button>
        </form>
    </div>
</body>
</html>
