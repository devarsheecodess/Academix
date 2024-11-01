<?php
    include '../dbconnect.php';
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
    <style>
        *{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="flex items-center mt-10 flex-col w-full min-h-screen p-4">
        <h1 id="greet" class="font-bold text-red-950 text-3xl md:text-4xl lg:text-4xl mb-4 fade-in-up text-center"></h1>
        <div id="current-time" class="text-xl font-medium text-gray-700 mb-4 font-semibold"></div>
        <img
            src="https://media4.giphy.com/media/v1.Y2lkPTc5MGI3NjExNXc5MGFlbHk2YjJjazNid2Vmb2NzOTYwNWlsem9hdGtwbHExbmhpaCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/26u4cqVR8dsmedTJ6/giphy.webp"
            alt="Welcome animation"
            className="rounded-lg max-w-full h-auto entry-animation"
        />
    </div>
    
    <script>
        const user = localStorage.getItem("user");
        const greet = document.getElementById("greet");
        greet.innerText = `Welcome ${user}!`;

        function updateTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            const currentTime = now.toLocaleTimeString(undefined, options);
            document.getElementById('current-time').innerText = `${currentTime}`;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>
