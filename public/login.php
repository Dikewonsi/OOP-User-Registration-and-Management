<?php
    // Include database and user classes
    require_once '../classes/Database.php';
    require_once '../classes/User.php';

    // Start session
    session_start();

    $error_message = '';

    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize User object
    $user = new User($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form inputs
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        // Try to log in
        $result = $user->login(); 

        if ($result) {
            // User authenticated, set session variables
            $_SESSION['user_id'] = $result['id'];            

            // Redirect to a dashboard or home page
            header("Location: dashboard.php");
        } else {
            $error_message = "Invalid email or password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        <?php if ($error_message): ?>
            <div class="text-red-500 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                Login
            </button>
        </form>
    </div>
</body>
</html>
