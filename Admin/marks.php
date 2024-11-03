<?php
include '../dbconnect2.php';
include 'header.php';

// Assuming `studentId` is stored in a cookie
$studentId = isset($_COOKIE['studentId']) ? (int)$_COOKIE['studentId'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $studentId) {
    $subjects = ["Database Management", "Theory of Computation", "Internet of Things", "Statistical Model Science", "Ethics and Entrepreneurship", "Open Elective"];
    $marksData = [];

    foreach ($subjects as $subject) {
        $semesterMarks = $_POST["semester_{$subject}"];
        $it1Marks = $_POST["it1_{$subject}"];
        $it2Marks = $_POST["it2_{$subject}"];
        $it3Marks = $_POST["it3_{$subject}"];
        $marksData[] = "('$studentId', '$subject', '$semesterMarks', '$it1Marks', '$it2Marks', '$it3Marks')";
    }

    $values = implode(", ", $marksData);
    $sql = "INSERT INTO student_marks (studentId, subject, semester_marks, it1, it2, it3) VALUES $values 
            ON DUPLICATE KEY UPDATE semester_marks=VALUES(semester_marks), it1=VALUES(it1), it2=VALUES(it2), it3=VALUES(it3)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Marks added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section remains the same -->
</head>
<body>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-purple-700 text-center">Add Student Marks</h2>
        <form method="POST" action="">
            <?php 
            $subjects = ["Database Management", "Theory of Computation", "Internet of Things", "Statistical Model Science", "Ethics and Entrepreneurship", "Open Elective"];
            foreach ($subjects as $subject): 
            ?>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-purple-700"><?php echo $subject; ?></h3>
                    <label class="block text-gray-700 mt-2">Semester Marks:</label>
                    <input type="number" name="semester_<?php echo $subject; ?>" required class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <label class="block text-gray-700 mt-2">IT1 Marks:</label>
                    <input type="number" name="it1_<?php echo $subject; ?>" required class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <label class="block text-gray-700 mt-2">IT2 Marks:</label>
                    <input type="number" name="it2_<?php echo $subject; ?>" required class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <label class="block text-gray-700 mt-2">IT3 Marks:</label>
                    <input type="number" name="it3_<?php echo $subject; ?>" required class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            <?php endforeach; ?>
            <div class="flex justify-center mt-8">
                <input type="submit" value="Add Marks" class="bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-purple-600 transition duration-200">
            </div>
        </form>
    </div>
</body>
</html>
