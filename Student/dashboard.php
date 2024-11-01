<?php
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="flex justify-center items-center">
        <h1 id="greet" class="text-center text-3xl mt-20 font-bold fade-in-up"></h1>
    </div>
<script>
    const user = localStorage.getItem("user");
    const greet = document.getElementById("greet");
    greet.innerText = `Welcome ${user}!`;
</script>
</body>
</html>