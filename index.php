<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Academix!</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        @keyframes slide-in {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .animate-slide-in {
            animation: slide-in 1s ease-out forwards;
        }
    </style>
</head>

<body class="bg-transparent flex flex-col min-h-screen relative">
    <!-- Background -->
    <div class="absolute inset-0 -z-20 h-full w-full flex items-center px-5 py-24" style="background: radial-gradient(125% 125% at 50% 10%, #000 40%, #63e 100%);"></div>

    <!-- Navbar -->
    <nav class="flex justify-between items-center p-5 shadow-lg z-10">
        <div class="text-white text-2xl font-bold">Academix</div>
        <div class="space-x-4">
            <a href="login.php" class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-300 font-medium">Login</a>
            <a href="signup.php" class="bg-green-800 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition duration-300 font-medium">Register</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center z-10">
        <div class="max-w-lg text-center text-white p-10 bg-opacity-75 rounded-lg shadow-lg animate-slide-in">
            <h1 class="text-4xl font-bold mb-6">Welcome to Academix!</h1>
            <p class="text-lg">Your journey to knowledge and excellence starts here.</p>
        </div>
    </div>
</body>

</html>
