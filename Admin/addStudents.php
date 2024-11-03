<?php
    include '../dbconnect.php';
    include 'header.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $school_id = $_POST["id"];
        $image = $_POST["image"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $class = $_POST["class"];
        $division = $_POST["division"];
        $rollNo = $_POST["rollNo"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $contact = $_POST["contact"];
        $parentsContact = $_POST["parentsContact"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "INSERT INTO students (image, fname, lname, class, division, rollNo, dob, gender, address, contact, parentsContact, username, email, password, school_id) VALUES ('$image', '$fname', '$lname', '$class', '$division', '$rollNo', '$dob', '$gender', '$address', '$contact', '$parentsContact', '$username', '$email', '$password', $school_id)";

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
    <title>Add Students</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<script>
    const id = localStorage.getItem("adminID");

    const handleChange = () =>{
        const idField = document.getElementById("id");
        idField.value = id;
    }
</script>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 fade-in-up">Add New Student</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold mb-2">Image URL:</label>
                <input type="file" onchange="handleChange()" id="image" name="image" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="fname" class="block text-gray-700 font-semibold mb-2">First Name:</label>
                <input type="text" id="fname" name="fname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="lname" class="block text-gray-700 font-semibold mb-2">Last Name:</label>
                <input type="text" id="lname" name="lname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="class" class="block text-gray-700 font-semibold mb-2">Class:</label>
                <input type="text" id="class" name="class" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="division" class="block text-gray-700 font-semibold mb-2">Division:</label>
                <input type="text" id="division" name="division" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="rollno" class="block text-gray-700 font-semibold mb-2">Roll Number:</label>
                <input type="text" id="rollNo" name="rollNo" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender:</label>
                <select id="gender" name="gender" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="rollno" class="block text-gray-700 font-semibold mb-2">Contact:</label>
                <input type="text" id="contact" name="contact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="rollno" class="block text-gray-700 font-semibold mb-2">Parents Contact:</label>
                <input type="text" id="parentsContact" name="parentsContact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="dob" class="block text-gray-700 font-semibold mb-2">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold mb-2">Username:</label>
                <input type="text" id="username" name="username" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <input type="email" id="email" name="email" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-semibold mb-2">Address:</label>
                <textarea id="address" name="address" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500" rows="4"></textarea>
            </div>
            <div class="mb-4 hidden">
                <label for="id" class="block text-gray-700 font-semibold mb-2">ID:</label>
                <input id="id" name="id" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500"></input>
            </div>
            <div class="flex justify-center">
                <input type="submit" value="Add Student" class="bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-purple-600 transition duration-200">
            </div>
        </form>
    </div>
    <?php if ($flag): ?>
        <script>
            alert("Student added successfully!");
        </script>
    <?php endif; ?>
</body>
</html>