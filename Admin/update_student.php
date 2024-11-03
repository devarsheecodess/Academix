<?php
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
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

    $sql = "UPDATE students SET image=?, fname=?, lname=?, class=?, division=?, rollNo=?, dob=?, gender=?, address=?, contact=?, parentsContact=?, username=?, email=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssi", $image, $fname, $lname, $class, $division, $rollNo, $dob, $gender, $address, $contact, $parentsContact, $username, $email, $password, $id);

    if ($stmt->execute()) {
        echo "Student updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>