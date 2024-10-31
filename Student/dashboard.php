<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 id="greet"></h1>

<script>
    const user = localStorage.getItem("user");
    const greet = document.getElementById("greet");
    greet.innerText = `Welcome ${user}!`;
</script>
</body>
</html>