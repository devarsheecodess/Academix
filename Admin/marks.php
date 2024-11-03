<?php
include '../dbconnect.php';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Marks</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8 flex flex-col justify-center items-center">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center fade-in-up">Add Student Marks</h2>
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl flex flex-col justify-center items-center">
            <form method="POST" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php 
                    $subjects = ["Database Management", "Theory of Computation", "Internet of Things", "Statistical Model Science", "Ethics and Entrepreneurship", "Open Elective"];
                    foreach ($subjects as $subject): 
                    ?>
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo $subject; ?></h3>
                            <label class="block text-gray-700 mt-2">Semester Marks:</label>
                            <input type="number" name="semester_<?php echo $subject; ?>" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                            <label class="block text-gray-700 mt-2">IT1 Marks:</label>
                            <input type="number" name="it1_<?php echo $subject; ?>" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                            <label class="block text-gray-700 mt-2">IT2 Marks:</label>
                            <input type="number" name="it2_<?php echo $subject; ?>" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                            <label class="block text-gray-700 mt-2">IT3 Marks:</label>
                            <input type="number" name="it3_<?php echo $subject; ?>" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex justify-center mt-8">
                    <input type="submit" value="Add Marks" class="bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-gray-700 transition duration-200">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
