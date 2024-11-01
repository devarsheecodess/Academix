<?php
include '../dbconnect.php'; // Include your database connection
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
        <h1 id="greet" class="text-center text-3xl mt-20 font-bold fade-in-up"></h1>
    </div>

    <div id="currentTime" class="text-center text-xl mt-2 font-semibold slide-in-left"></div>

    <input type="hidden" id="studentID" name="studentID" value="">

    <div class="flex justify-center mt-10">
        <div class="bg-white p-6 rounded-lg shadow-md w-2/3">
            <table class="min-w-full border-collapse">
                <tbody>
                    <?php
                    // Get the student ID from the hidden input field
                    echo "<script>
                            const studentId = localStorage.getItem('studentID');
                            document.cookie = 'studentId=' + studentId;
                        </script>";
                    $studentId = $_COOKIE['studentId'];
                    
                    $sql = "SELECT id, image, fname, lname, class, division, rollNo, dob, gender, address, contact, parentsContact, username, email FROM students WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $studentId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userData = $result->fetch_assoc();
                        echo "<tr><td class='border p-2 font-semibold'>Image:</td><td class='border p-2'><img src='data:image/jpeg;base64," . base64_encode($userData['image']) . "' alt='User Image' class='w-32 h-32 rounded-full'></td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>First Name:</td><td class='border p-2'>" . htmlspecialchars($userData['fname']) . "</td></tr>";
                        echo "<tr><td class='border p-2 font-semibold'>Last Name:</td><td class='border p-2'>" . htmlspecialchars($userData['lname']) . "</td></tr>";
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

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const user = localStorage.getItem("user");
        const studentID = localStorage.getItem("studentID"); // Fetch studentID from local storage
        const greet = document.getElementById("greet");
        const studentIDInput = document.getElementById("studentID");
        
        greet.innerText = `Welcome ${user}!`;
        studentIDInput.value = studentID; // Set the hidden input value

        // Function to update time
        function updateTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            document.getElementById("currentTime").innerText = now.toLocaleTimeString([], options);
        }

        setInterval(updateTime, 1000); // Update time every second
        updateTime(); // Initial call to display time immediately
    </script>
</body>
</html>
