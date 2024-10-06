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
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="">
            <h2 class="text-center text-lg font-bold mb-4">Admin Create Account</h2>
            
            <?php if ($message): ?>
                <div class="text-red-500 text-center mb-4"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username" required>
            </div>           
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="********" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Register
                </button>
            </div>
            <div class="mt-4 text-center">
                <p>Already have an account? <a class="text-blue-500 hover:text-blue-700" href="login.php">Sign in</a></p>
            </div>
        </form>
    </div>
</body>
</html>
