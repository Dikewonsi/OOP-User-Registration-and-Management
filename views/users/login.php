<?php
    // Include database and user classes
    require_once '../../classes/Database.php';
    require_once '../../classes/User.php';

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
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        // Try to log in
        $result = $user->login(); 

        if ($result) {
            // User authenticated, set session variables
            $_SESSION['username'] = $result['username'];            

            // Redirect to a dashboard or home page
            header("Location: dashboard.php");
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
    <title>Login</title>
    <!-- Link to Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-blue-500 to-indigo-600">

    <!-- Card Container -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Logo and App Title -->
        <div class="bg-indigo-600 py-4 px-6 text-white text-center">
            <h2 class="text-3xl font-bold">Welcome Back</h2>
            <p class="text-sm mt-2">Log in to your account</p>
        </div>

        <!-- Login Form -->
        <div class="p-6">
            <form method="POST" action="">
                <!-- Display error message -->
                <?php if ($error_message): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded-md text-center mb-4">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="username">Username</label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="username" name="username" type="text" placeholder="Enter your username">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="password" name="password" type="password" placeholder="********">
                </div>

                <!-- Login Button -->
                <div class="flex items-center justify-center">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300 ease-in-out transform hover:scale-105" type="submit">
                        Sign In
                    </button>
                </div>

                <!-- Register Link -->
                <div class="mt-4 text-center">
                    <p class="text-sm">Don't have an account? <a class="text-indigo-600 hover:text-indigo-700 font-semibold" href="register.php">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

