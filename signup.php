<?php 
    include('dbconnect.php');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $schoolName = $_POST["schoolName"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

        if ($password !== $confirmPassword) {
            echo "Passwords do not match";
            exit();
        }

        $sql = "INSERT INTO admins (schoolName, username, email, password) VALUES ('$schoolName', '$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $flag = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Academix</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
</style>
<body>
<div class="bg-white dark:bg-gray-900">
    <div class="flex justify-center h-screen">
        <div class="hidden bg-cover lg:block lg:w-2/3" style="background-image: url(https://t3.ftcdn.net/jpg/05/96/59/18/360_F_596591823_3BYze4Efc1HixPsuio20BizY1AsT0nOJ.jpg)">
            <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                <div>
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">Welcome to Academix</h2>
                    <p class="max-w-xl mt-3 text-gray-300">
                        Where student management meets innovation.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
            <div class="flex-1">
                <div class="text-center">
                    <div class="flex justify-center mx-auto">
                        <img class="w-auto h-7 sm:h-8" src="https://merakiui.com/images/logo.svg" alt="Academix Logo">
                    </div>
                    <p class="mt-3 text-gray-500 dark:text-gray-300">Create your Academix account</p>
                </div>

                <div class="mt-8">
                    <form method="POST" action="">
                        <div>
                            <label for="schoolName" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">School Name</label>
                            <input type="text" name="schoolName" id="schoolName" placeholder="Your School Name" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" required />
                        </div>

                        <div class="mt-6">
                            <label for="username" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Username</label>
                            <input type="text" name="username" id="username" placeholder="Choose a username" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" required />
                        </div>

                        <div class="mt-6">
                            <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="example@example.com" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" required />
                        </div>

                        <div class="mt-6">
                            <label for="password" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Password</label>
                            <input type="password" name="password" id="password" placeholder="Create a password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" required />
                        </div>

                        <div class="mt-6">
                            <label for="confirmPassword" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Confirm Password</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Re-enter password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" required />
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                Sign up
                            </button>
                        </div>
                    </form>

                    <p class="mt-6 text-sm text-center text-gray-400">Already have an account? <a href="login.php" class="text-blue-500 focus:outline-none focus:underline hover:underline">Log in</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($flag): ?>
    <script>
        alert("Account created successfully!");
        window.location.href = "login.php";
    </script>
<?php endif; ?>
</body>
</html>
