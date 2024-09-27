<?php
    require_once '../classes/Database.php';
    require_once '../classes/User.php';


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
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        <?php if ($message): ?>
            <div class="text-red-500 text-center mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-4">
                <label class="block text-gray-700">Username</label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                Register
            </button>
        </form>
    </div>
</body>

</html>
