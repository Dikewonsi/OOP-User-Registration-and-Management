<?php
    // Include database and user classes
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';

    // Start session
    session_start();

    $error_message = '';

    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize User object
    $admin = new Admin($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form inputs
        $admin->username = $_POST['username'];
        $admin->password = $_POST['password'];

        // Try to log in
        $result = $admin->login(); 

        if ($result) {
            // User authenticated, set session variables
            $_SESSION['admin_id'] = $result['id'];            

            // Redirect to a dashboard or home page
            header("Location: admin_dashboard.php");
        } else {
            $error_message = "Invalid username or password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <!-- Link to Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="">
            <h2 class="text-center text-lg font-bold mb-4">Admin Sign In</h2>

            <?php if ($error_message): ?>
                <div class="text-red-500 text-center mb-4"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required id="username" name="username" type="text" placeholder="Username">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required id="password" name="password" type="password" placeholder="********">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Sign In
                </button>
            </div>
            <div class="mt-4 text-center">
                <p>Don't have an account? <a class="text-blue-500 hover:text-blue-700" href="register.php">Sign up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
