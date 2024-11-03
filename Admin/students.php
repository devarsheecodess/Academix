<?php
include '../dbconnect.php';
include 'header.php';

// Fetch student data from the database
$query = "SELECT * FROM students";
$result = $conn->query($query);
$students = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Students</title>
    <style>
        .popup-scroll {
            max-height: 80vh;
            overflow-y: auto;
        }
        .success-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        .student-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .student-item {
            width: calc(20% - 10px); /* 5 items per row with 10px gap */
        }
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid black; /* Thin border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none;
            max-width: 90%;
            width: auto;
        }
        .modal-content {
            max-width: 100%;
            overflow-y: auto;
        }
        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .modal-close {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .modal-close:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function showStudentPopup(student) {
            document.getElementById('modalTitle').innerText = `${student.fname} ${student.lname}`;
            document.getElementById('modalContent').innerHTML = `
                <p><strong>Roll Number:</strong> ${student.rollNo}</p>
                <p><strong>Class:</strong> ${student.class}</p>
                <p><strong>Division:</strong> ${student.division}</p>
                <p><strong>Date of Birth:</strong> ${student.dob}</p>
                <p><strong>Gender:</strong> ${student.gender}</p>
                <p><strong>Address:</strong> ${student.address}</p>
                <p><strong>Contact:</strong> ${student.contact}</p>
                <p><strong>Parents Contact:</strong> ${student.parentsContact}</p>
                <p><strong>Email:</strong> ${student.email}</p>
            `;
            document.getElementById('studentModal').style.display = 'block';
        }

        function closeStudentPopup() {
            document.getElementById('studentModal').style.display = 'none';
        }

        function showEditPopup(student) {
            document.getElementById('editId').value = student.id;
            document.getElementById('editImage').value = student.image;
            document.getElementById('editFname').value = student.fname;
            document.getElementById('editLname').value = student.lname;
            document.getElementById('editClass').value = student.class;
            document.getElementById('editDivision').value = student.division;
            document.getElementById('editRollNo').value = student.rollNo;
            document.getElementById('editDob').value = student.dob;
            document.getElementById('editGender').value = student.gender;
            document.getElementById('editAddress').value = student.address;
            document.getElementById('editContact').value = student.contact;
            document.getElementById('editParentsContact').value = student.parentsContact;
            document.getElementById('editUsername').value = student.username;
            document.getElementById('editEmail').value = student.email;
            document.getElementById('editPassword').value = student.password;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditPopup() {
            document.getElementById('editModal').style.display = 'none';
        }

        function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
                xhr.send("id=" + studentId);
            }
        }

        function updateStudent() {
            const form = document.getElementById("editForm");
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_student.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    showSuccessPopup("Update successful");
                    location.reload();
                }
            };
            xhr.send(formData);
        }

        function showSuccessPopup(message) {
            const successPopup = document.getElementById("successPopup");
            successPopup.innerText = message;
            successPopup.style.display = "block";
            setTimeout(() => {
                successPopup.style.display = "none";
            }, 10000); // Display for 5 seconds
        }
    </script>
</head>
<body>
    <div class="flex justify-center items-center">
        <h1 class="text-center text-3xl mt-20 font-bold fade-in-up">Students</h1>
    </div>

    <div class="student-grid mt-10">
        <!-- Display Student Details -->
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $student): ?>
                <div class="student-item mb-4 p-4 border-b border-gray-300 bg-white rounded-lg shadow-md">
                    <img src="<?= htmlspecialchars($student['image']); ?>" alt="Student Photo" class="w-16 h-16 rounded-full mb-4">
                    <h3 class="font-bold text-lg"><?= htmlspecialchars($student['fname'] . ' ' . $student['lname']); ?></h3>
                    <p>Roll Number: <?= htmlspecialchars($student['rollNo']); ?></p>
                    <p>Class: <?= htmlspecialchars($student['class']); ?></p>
                    <p>Section: <?= htmlspecialchars($student['division']); ?></p>
                    <div class="flex justify-between items-center mt-4">
                        <button onclick="showStudentPopup(<?= htmlspecialchars(json_encode($student)); ?>)" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-info-circle"></i> Details
                        </button>
                        <button onclick="showEditPopup(<?= htmlspecialchars(json_encode($student)); ?>)" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                        <button onclick="deleteStudent(<?= htmlspecialchars($student['id']); ?>)" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No student found.</p>
        <?php endif; ?>
    </div>

    <!-- Popup for student details -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden" onclick="closeStudentPopup()"></div>
    <div id="studentModal" class="modal">
        <h2 id="modalTitle" class="modal-header">Student Details</h2>
        <div id="modalContent" class="modal-content"></div>
        <button onclick="closeStudentPopup()" class="modal-close">Close</button>
    </div>

    <!-- Edit Student Form -->
    <div id="editModal" class="modal popup-scroll">
        <h2 class="modal-header">Edit Student</h2>
        <form onsubmit="event.preventDefault(); updateStudent();" id="editForm">
            <input type="hidden" id="editId" name="id">
            <div class="mb-4">
                <label for="editImage" class="block text-gray-700 font-semibold mb-2">Image URL:</label>
                <input type="text" id="editImage" name="image" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editFname" class="block text-gray-700 font-semibold mb-2">First Name:</label>
                <input type="text" id="editFname" name="fname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editLname" class="block text-gray-700 font-semibold mb-2">Last Name:</label>
                <input type="text" id="editLname" name="lname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editClass" class="block text-gray-700 font-semibold mb-2">Class:</label>
                <input type="text" id="editClass" name="class" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editDivision" class="block text-gray-700 font-semibold mb-2">Division:</label>
                <input type="text" id="editDivision" name="division" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editRollNo" class="block text-gray-700 font-semibold mb-2">Roll Number:</label>
                <input type="text" id="editRollNo" name="rollNo" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editDob" class="block text-gray-700 font-semibold mb-2">Date of Birth:</label>
                <input type="date" id="editDob" name="dob" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editGender" class="block text-gray-700 font-semibold mb-2">Gender:</label>
                <select id="editGender" name="gender" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="editContact" class="block text-gray-700 font-semibold mb-2">Contact:</label>
                <input type="text" id="editContact" name="contact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editParentsContact" class="block text-gray-700 font-semibold mb-2">Parents Contact:</label>
                <input type="text" id="editParentsContact" name="parentsContact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editUsername" class="block text-gray-700 font-semibold mb-2">Username:</label>
                <input type="text" id="editUsername" name="username" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editEmail" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <input type="email" id="editEmail" name="email" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editPassword" class="block text-gray-700 font-semibold mb-2">Password:</label>
                <input type="password" id="editPassword" name="password" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="editAddress" class="block text-gray-700 font-semibold mb-2">Address:</label>
                <textarea id="editAddress" name="address" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500" rows="4"></textarea>
            </div>
            <div class="flex justify-center">
                <input type="submit" value="Update Student" class="bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-purple-600 transition duration-200">
            </div>
        </form>
        <button onclick="closeEditPopup()" class="mt-4 bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-purple-600 transition duration-200">Close</button>
    </div>

    <!-- Success Popup -->
    <div id="successPopup" class="success-popup"></div>
</body>
</html>