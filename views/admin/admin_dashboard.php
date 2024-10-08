<?php 
    // Include database and user classes
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';

    session_start();    

    // Check if the admin is logged in
    if (!isset($_SESSION['admin_id']))
    {
        header('Location: login.php');
        exit();
    }
    else
    {
        $admin_id = $_SESSION['admin_id'];
    }

    // Check for flash message and display it
    if (isset($_SESSION['flash_message'])) {
        echo "<div id='flashMessage' class='bg-green-500 text-white p-3 rounded mb-4'>"
            . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']); // Unset the flash message after displaying it
    }

    // Database and Admin initialization
    $database = new Database();
    $db = $database->getConnection();
    $admin = new Admin($db);

    // Fetch all users
    $users = $admin->fetchUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
        
        <!-- User Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Users List</h2>
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Username</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add this script at the bottom of your HTML to hide the flash message after 5 seconds -->
    <script>
        setTimeout(function() {
            var flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000); // 5000ms = 5 seconds
    </script>
</body>
</html>