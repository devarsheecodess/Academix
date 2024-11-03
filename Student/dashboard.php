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
    <title>User Profile</title>
</head>
<body>
    <div class="flex justify-center items-center">
        <h1 id="greet" class="text-center text-3xl mt-20 font-bold fade-in-up text-blue-900"></h1>
    </div>

    <div id="currentTime" class="text-center text-xl mt-2 font-semibold slide-in-left"></div>

    <div class="flex justify-center mt-10">
        <div class="bg-white p-6 rounded-lg shadow-md w-2/3">
            <table class="min-w-full border-collapse">
                <tbody>
                    <?php
                    // Set the student ID from JavaScript to a cookie
                    echo "<script>
                            const studentId = localStorage.getItem('studentID');
                            document.cookie = 'studentId=' + studentId;
                        </script>";
                    
                    // Fetch student ID from the cookie
                    $studentId = isset($_COOKIE['studentId']) ? $_COOKIE['studentId'] : null;

                    // Ensure student ID is an integer
                    $studentId = (int)$studentId;

                    // Direct query without prepare/execute/bind_param
                    $sql = "SELECT id, image, fname, lname, class, division, rollNo, dob, gender, address, contact, parentsContact, username, email FROM students WHERE id = $studentId";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $userData = $result->fetch_assoc();
                        echo "<tr><td class='border p-2 font-semibold'>Image:</td><td class='border p-2'><img src='https://img.freepik.com/premium-vector/silver-membership-icon-default-avatar-profile-icon-membership-icon-social-media-user-image-vector-illustration_561158-4215.jpg' alt='User Image' class='w-32 h-32 rounded-full'></td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Name:</td><td class='border p-2'>" . htmlspecialchars($userData['fname']) . ' ' . htmlspecialchars($userData['lname']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Class:</td><td class='border p-2'>" . htmlspecialchars($userData['class']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Division:</td><td class='border p-2'>" . htmlspecialchars($userData['division']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Roll No:</td><td class='border p-2'>" . htmlspecialchars($userData['rollNo']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>DOB:</td><td class='border p-2'>" . htmlspecialchars($userData['dob']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Gender:</td><td class='border p-2'>" . htmlspecialchars($userData['gender']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Address:</td><td class='border p-2'>" . htmlspecialchars($userData['address']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Contact:</td><td class='border p-2'>" . htmlspecialchars($userData['contact']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Parent's Contact:</td><td class='border p-2'>" . htmlspecialchars($userData['parentsContact']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Username:</td><td class='border p-2'>" . htmlspecialchars($userData['username']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Email:</td><td class='border p-2'>" . htmlspecialchars($userData['email']) . "</td></tr>";
                    } else {
                        echo "<tr><td colspan='2' class='border p-2 text-center'>No user found</td></tr>";
                    }                    

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const user = localStorage.getItem("user");
        const greet = document.getElementById("greet");
        greet.innerText = `Welcome ${user}!`;

        // Display and update the current time
        function updateTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            document.getElementById("currentTime").innerText = now.toLocaleTimeString([], options);
        }

        // Initial time display and set interval to refresh every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>
