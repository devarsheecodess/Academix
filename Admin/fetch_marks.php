<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include '../dbconnect.php'; // Adjust path as necessary

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the student ID from the query string
$studentId = $_GET['id'];

// Prepare the SQL query to fetch marks for the given student ID
$sql = "SELECT subject, semester_marks, it1, it2, it3 FROM student_marks WHERE studentId = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $studentId); // Assuming studentId is an integer
$stmt->execute();
$result = $stmt->get_result();

// Check if any marks were found
if ($result->num_rows > 0) {
    echo "<table class='min-w-full divide-y divide-gray-200'>";
    echo "<thead class='bg-gray-50'>";
    echo "<tr>";
    echo "<th class='px-4 py-2'>Subject</th>";
    echo "<th class='px-4 py-2'>Semester Marks</th>";
    echo "<th class='px-4 py-2'>IT1</th>";
    echo "<th class='px-4 py-2'>IT2</th>";
    echo "<th class='px-4 py-2'>IT3</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody class='bg-white divide-y divide-gray-200'>";

    // Fetch each row and display it
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='px-4 py-2'>" . htmlspecialchars($row['subject']) . "</td>";
        echo "<td class='px-4 py-2'>" . htmlspecialchars($row['semester_marks']) . "</td>";
        echo "<td class='px-4 py-2'>" . htmlspecialchars($row['it1']) . "</td>";
        echo "<td class='px-4 py-2'>" . htmlspecialchars($row['it2']) . "</td>";
        echo "<td class='px-4 py-2'>" . htmlspecialchars($row['it3']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='text-center text-gray-600'>No marks found for this student.</p>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
