<?php
    require_once '../../classes/Database.php';
    require_once '../../classes/User.php';


    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $user->username = htmlspecialchars($_POST['username']);
        $user->email = htmlspecialchars($_POST['email']);
        $user->password = $_POST['password'];

        // Register user
        if ($user->register()) {
            $message = "User registered successfully!";
        } else {
            $message = "Username or email already exists.";            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Register</title>
    <!-- Link to Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-r from-green-400 to-blue-500">

    <!-- Card Container -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Logo and App Title -->
        <div class="bg-green-500 py-4 px-6 text-white text-center">
            <h2 class="text-3xl font-bold">Create Account</h2>
            <p class="text-sm mt-2">Join us and get started!</p>
        </div>

        <!-- Registration Form -->
        <div class="p-6">
            <form method="POST" action="">
                <!-- Display message -->
                <?php if ($message): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded-md text-center mb-4">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="username">Username</label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" id="username" name="username" type="text" placeholder="Enter your username" required>
                </div>  

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">Email</label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" id="email" name="email" type="email" placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" id="password" name="password" type="password" placeholder="********" required>
                </div>

                <!-- Register Button -->
                <div class="flex items-center justify-center">
                    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300 ease-in-out transform hover:scale-105" type="submit">
                        Register
                    </button>
                </div>

                <!-- Sign In Link -->
                <div class="mt-4 text-center">
                    <p class="text-sm">Already have an account? <a class="text-green-500 hover:text-green-600 font-semibold" href="login.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

