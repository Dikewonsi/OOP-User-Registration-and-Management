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

    // Initialize database and admin class
    $database = new Database();
    $db = $database->getConnection();
    $admin = new Admin($db);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $admin->username = $_POST['username'];
        $admin->email = $_POST['email'];
        $admin->password = $_POST['password'];
        // $admin->password = password_hash($_POST['password'], PASSWORD_DEFAULT); ----if you want to hash the password.

        // Attempt to register the user
        if ($admin->createUser()) {
            $_SESSION['flash_message'] = "User added successfully!";
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['flash_message'] = "Failed to add user. Username may already exist.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add User</title>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-2xl font-bold mb-4">Add User</h1>

    <!-- Display Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            <?php echo $_SESSION['flash_message']; ?>
            <?php unset($_SESSION['flash_message']); ?>
        </div>
    <?php endif; ?>

    <!-- User Registration Form -->
    <form method="POST" class="bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label class="block text-gray-700">Username:</label>
            <input type="text" name="username" required class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email:</label>
            <input type="email" name="email" required class="border p-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Password:</label>
            <input type="password" name="password" required class="border p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Add User</button>
        <a href="admin_dashboard.php" class="text-gray-600 hover:underline ml-4">Cancel</a>
    </form>

</body>
</html>
