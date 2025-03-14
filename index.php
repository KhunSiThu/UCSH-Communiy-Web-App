<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .role-button {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .role-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-50 to-purple-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md w-full mx-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Welcome!</h1>
        <p class="text-gray-600 mb-8">Please select your role to continue.</p>
        <div class="space-y-4">
            <button id="user-btn" class="role-button w-full bg-gradient-to-r from-green-400 to-green-500 text-white py-3 px-6 rounded-xl hover:from-green-500 hover:to-green-600 transition duration-300">
                User
            </button>

            <button id="admin-btn" class="role-button w-full bg-gradient-to-r from-red-400 to-red-500 text-white py-3 px-6 rounded-xl hover:from-red-500 hover:to-red-600 transition duration-300">
                Admin
            </button>
        </div>
    </div>

    <script>
        // Add event listeners for buttons
        document.getElementById('user-btn').addEventListener('click', () => {
            window.location.href = "./Public/index.php";
        });

        document.getElementById('admin-btn').addEventListener('click', () => {
            window.location.href = "./src/admin/login.php";
        });
    </script>
</body>
</html>