<?php
include '../dbconnect.php';
include 'header.php';

echo "<script>
    const school_id = localStorage.getItem('adminID');
    document.cookie = 'school_id=' + school_id;
</script>";

// Fetch student names and IDs from the database
$students = [];
$adminID = $_COOKIE['school_id'];
$studentsResult = $conn->query("SELECT id, fname FROM students WHERE school_id = '$adminID'");
if ($studentsResult->num_rows > 0) {
    while ($row = $studentsResult->fetch_assoc()) {
        $students[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId']; // Get student ID from the hidden input
    $marksData = [];
    $subjects = $_POST['subject'] ?? [];
    $semesterMarksList = $_POST['semester_marks'] ?? [];
    $it1MarksList = $_POST['it1'] ?? [];
    $it2MarksList = $_POST['it2'] ?? [];
    $it3MarksList = $_POST['it3'] ?? [];

    foreach ($subjects as $index => $subject) {
        $semesterMarks = $semesterMarksList[$index];
        $it1Marks = $it1MarksList[$index];
        $it2Marks = $it2MarksList[$index];
        $it3Marks = $it3MarksList[$index];
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
<body class="flex flex-col items-center justify-center">
    <div class="container mx-auto p-8 flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold text-center text-gray-800 fade-in-up">Marks</h1>

        <div class="max-w-4xl bg-white p-10 rounded-lg shadow-lg">
            <form method="POST" action="" class="space-y-6">
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Student Name:</label>
                    <select name="studentName" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="setStudentId(this)">
                        <option value="" disabled selected>Select a student</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= htmlspecialchars($student['fname']); ?>" data-id="<?= htmlspecialchars($student['id']); ?>"><?= htmlspecialchars($student['fname']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="subjects-container" class="space-y-4">
                    <div class="subject-entry bg-gray-50 p-5 rounded-lg shadow">
                        <label class="block text-lg font-semibold text-gray-800 mb-1">Subject Name:</label>
                        <input type="text" name="subject[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 font-medium">Semester Marks:</label>
                                <input type="number" name="semester_marks[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium">IT1 Marks:</label>
                                <input type="number" name="it1[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium">IT2 Marks:</label>
                                <input type="number" name="it2[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium">IT3 Marks:</label>
                                <input type="number" name="it3[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addSubject()" class="w-full bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:bg-blue-400 transition duration-300 mt-4">
                    Add Another Subject
                </button>
                <div class="text-center">
                    <input type="submit" value="Add Marks" class="w-full bg-green-500 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:bg-green-400 transition duration-300 mt-6">
                </div>
            </form>
        </div>
    </div>

    <script>
        function setStudentId(select) {
            const selectedOption = select.options[select.selectedIndex];
            const studentId = selectedOption.getAttribute('data-id');

            // Create a hidden input to store the studentId
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'studentId';
            input.value = studentId;

            // Append the input to the form
            const form = select.closest('form');
            const existingInput = form.querySelector('input[name="studentId"]');
            if (existingInput) {
                existingInput.value = studentId; // Update existing input value if it exists
            } else {
                form.appendChild(input); // Append new input if it doesn't exist
            }
        }

        function addSubject() {
            const container = document.getElementById('subjects-container');
            const subjectEntry = document.createElement('div');
            subjectEntry.className = "subject-entry bg-gray-50 p-5 rounded-lg shadow mb-4";
            subjectEntry.innerHTML = `
                <label class="block text-lg font-semibold text-gray-800 mb-1">Subject Name:</label>
                <input type="text" name="subject[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Semester Marks:</label>
                        <input type="number" name="semester_marks[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">IT1 Marks:</label>
                        <input type="number" name="it1[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">IT2 Marks:</label>
                        <input type="number" name="it2[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">IT3 Marks:</label>
                        <input type="number" name="it3[]" required class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            `;
            container.appendChild(subjectEntry);
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
