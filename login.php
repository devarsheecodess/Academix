<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == 'admin') {
        $sql = "SELECT * FROM `admins` WHERE `username` = '$username' AND `password` = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $adminID = $result->fetch_assoc()['id'];
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['adminID'] = $adminID; // Store adminID in session
            
            // Store adminID in localStorage via JavaScript
            echo "<script>
                    localStorage.setItem('adminID', '$adminID');
                    localStorage.setItem('role', 'admin');
                    window.location.href = 'Admin/dashboard.php';
                  </script>";
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Invalid credentials.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    } else {
        $sql = "SELECT * FROM `students` WHERE `username` = '$username' AND `password` = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $studentID = $result->fetch_assoc()['id'];
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['studentID'] = $studentID; // Store studentID in session
            
            // Store studentID in localStorage via JavaScript
            echo "<script>
                    localStorage.setItem('studentID', '$studentID');
                    localStorage.setItem('role', 'student');
                    window.location.href = 'Student/dashboard.php';
                  </script>";
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Invalid credentials.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academix - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
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
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">Academix</h2>
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
                        <img class="w-auto h-7 sm:h-8" src="https://merakiui.com/images/logo.svg" alt="">
                    </div>
                    <p class="mt-3 text-gray-500 dark:text-gray-300">Log in to access your account</p>
                </div>

                <div class="mt-8">
                    <form action="" method="POST">
                        <div>
                            <label for="role" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Login as</label>
                            <select name="role" id="role" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40">
                                <option value="student">Student</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <label for="username" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Username</label>
                            <input type="username" name="username" id="username" placeholder="" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                        </div>

                        <div class="mt-6 relative">
                            <label for="password" class="text-sm text-gray-600 dark:text-gray-200">Password</label>
                            <input type="password" name="password" id="password" placeholder="Your Password" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            <button type="button" id="togglePassword" class="absolute right-3 top-3/4 transform -translate-y-1/2 text-gray-600">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50" onclick="handleSubmit()">
                                Sign in
                            </button>
                        </div>
                    </form>

                    <p id="signup-link" class="mt-6 text-sm text-center text-gray-400 hidden">Don&#x27;t have an account yet? <a href="signup.php" class="text-blue-500 focus:outline-none focus:underline hover:underline">Sign up</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const signupLink = document.getElementById('signup-link');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'admin') {
            signupLink.classList.remove('hidden');
        } else {
            signupLink.classList.add('hidden');
        }
    });

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    const handleSubmit = () =>{
        const username = document.getElementById('username').value;
        localStorage.setItem('user', username);
    }
</script>
</body>
</html>
