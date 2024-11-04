<?php
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    // Prepare and execute the delete statement for student_marks first
    $sql2 = "DELETE FROM student_marks WHERE studentId=?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $id);

    if ($stmt2->execute()) {
        // Now prepare and execute the delete statement for students
        $sql = "DELETE FROM students WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Student deleted successfully.";
        } else {
            echo "Error deleting student: " . $conn->error;
        }
    } else {
        echo "Error deleting marks: " . $conn->error;
    }

    // Close the prepared statements
    $stmt2->close();
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
