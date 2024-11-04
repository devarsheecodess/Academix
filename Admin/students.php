<?php
include '../dbconnect.php';
include 'header.php';

echo "<script>
    const school_id = localStorage.getItem('adminID');
    document.cookie = 'school_id=' + school_id;
</script>";

// Fetch student data from the database
$school_id = $_COOKIE['school_id'];
$search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';

// Prepare the query with JOIN
$query = "SELECT s.*, a.schoolName 
          FROM students s 
          INNER JOIN admins a ON s.school_id = a.id 
          WHERE s.school_id = $school_id";

if ($search_name) {
    $search_name = $conn->real_escape_string($search_name);
    $query .= " AND (s.fname LIKE '%$search_name%' OR s.lname LIKE '%$search_name%' OR s.username LIKE '%$search_name%')";
}

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
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM2rR/F9C4UAnRzDqq+9XpG1k0yNnAFL4B8sB5" crossorigin="anonymous">
    <style>
        .popup-scroll {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
    <script>
        function showStudentPopup(student) {
            document.getElementById('modalTitle').innerText = `${student.fname} ${student.lname}`;
            document.getElementById('modalContent').innerHTML = `
                <img src="https://img.freepik.com/premium-vector/silver-membership-icon-default-avatar-profile-icon-membership-icon-social-media-user-image-vector-illustration_561158-4215.jpg" alt="${student.fname} ${student.lname}" class="w-32 h-32 mb-4 rounded" />
                <p class="mb-2"><strong>Username:</strong> ${student.username}</p>
                <p class="mb-2"><strong>First Name:</strong> ${student.fname} ${student.lname}</p>
                <p class="mb-2"><strong>Roll Number:</strong> ${student.rollNo}</p>
                <p class="mb-2"><strong>Class:</strong> ${student.class}</p>
                <p class="mb-2"><strong>Division:</strong> ${student.division}</p>
                <p class="mb-2"><strong>Date of Birth:</strong> ${student.dob}</p>
                <p class="mb-2"><strong>Gender:</strong> ${student.gender}</p>
                <p class="mb-2"><strong>Address:</strong> ${student.address}</p>
                <p class="mb-2"><strong>Contact:</strong> ${student.contact}</p>
                <p class="mb-2"><strong>Parents Contact:</strong> ${student.parentsContact}</p>
                <p class="mb-2"><strong>Email:</strong> ${student.email}</p>
            `;
            document.getElementById('studentModal').classList.remove('hidden');
        }

        function closeStudentPopup() {
            document.getElementById('studentModal').classList.add('hidden');
        }

        function showEditPopup(student) {
            Object.keys(student).forEach(key => {
                const input = document.getElementById(`edit${key.charAt(0).toUpperCase() + key.slice(1)}`);
                if (input) input.value = student[key];
            });
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditPopup() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        showSuccessPopup("Student deleted successfully");
                        setTimeout(() => location.reload(), 1500);
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
                    setTimeout(() => location.reload(), 1500);
                }
            };
            xhr.send(formData);
        }

        function showSuccessPopup(message) {
            const successPopup = document.getElementById("successPopup");
            successPopup.innerText = message;
            successPopup.classList.remove('hidden');
            setTimeout(() => {
                successPopup.classList.add('hidden');
            }, 5000); // Display for 5 seconds
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto mt-20 px-4">
        <h1 class="text-4xl font-bold text-center text-gray-800 fade-in-up">Students</h1>

        <!-- Search Bar -->
        <div class="mt-5 flex justify-center">
            <form method="POST" class="flex items-center">
                <input type="text" name="search_name" placeholder="Search by name..." value="<?= htmlspecialchars($search_name); ?>" class="border border-gray-300 rounded-lg p-2 w-64 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="ml-2 bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Search</button>
            </form>
        </div>
        
        <div class="student-grid mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <div class="student-item bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow">
                        <img src="https://img.freepik.com/premium-vector/silver-membership-icon-default-avatar-profile-icon-membership-icon-social-media-user-image-vector-illustration_561158-4215.jpg" alt="Student Photo" class="w-20 h-20 rounded-full mx-auto mb-4">
                        <h3 class="font-bold text-lg text-center"><?= htmlspecialchars($student['fname'] . ' ' . $student['lname']); ?></h3>
                        <p class="text-center text-gray-600">Roll Number: <?= htmlspecialchars($student['rollNo']); ?></p>
                        <p class="text-center text-gray-600">Class: <?= htmlspecialchars($student['class']); ?></p>
                        <p class="text-center text-gray-600">Section: <?= htmlspecialchars($student['division']); ?></p>
                        <div class="flex justify-around mt-4">
                            <button onclick="showStudentPopup(<?= htmlspecialchars(json_encode($student)); ?>)" class="bg-blue-800 text-white px-3 py-1 rounded-lg hover:bg-blue-600" title="View Details">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <button onclick="showEditPopup(<?= htmlspecialchars(json_encode($student)); ?>)" class="bg-green-800 text-white px-3 py-1 rounded-lg hover:bg-green-600" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteStudent(<?= htmlspecialchars($student['id']); ?>)" class="bg-red-800 text-white px-3 py-1 rounded-lg hover:bg-red-600" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-700">No student found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white w-11/12 md:w-1/2 lg:w-1/3 rounded-lg p-8 shadow-lg">
            <h2 id="modalTitle" class="text-2xl font-bold mb-4 text-blue-600">Student Details</h2>
            <div id="modalContent" class="text-gray-700"></div>
            <button onclick="closeStudentPopup()" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Close</button>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white w-11/12 md:w-1/2 lg:w-1/3 rounded-lg p-8 shadow-lg popup-scroll">
            <h2 class="text-2xl font-bold mb-4 text-green-600">Edit Student</h2>
            <form onsubmit="event.preventDefault(); updateStudent();" id="editForm">
                <input type="hidden" id="editId" name="id">

                <div class="mb-4">
                    <label for="editUsername" class="block text-gray-700 font-semibold mb-2">Username:</label>
                    <input type="text" id="editUsername" name="username" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editFname" class="block text-gray-700 font-semibold mb-2">First Name:</label>
                    <input type="text" id="editFname" name="fname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editLname" class="block text-gray-700 font-semibold mb-2">Last Name:</label>
                    <input type="text" id="editLname" name="lname" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editRollNo" class="block text-gray-700 font-semibold mb-2">Roll Number:</label>
                    <input type="text" id="editRollNo" name="rollNo" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editClass" class="block text-gray-700 font-semibold mb-2">Class:</label>
                    <input type="text" id="editClass" name="class" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editDivision" class="block text-gray-700 font-semibold mb-2">Division:</label>
                    <input type="text" id="editDivision" name="division" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editDob" class="block text-gray-700 font-semibold mb-2">Date of Birth:</label>
                    <input type="date" id="editDob" name="dob" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editGender" class="block text-gray-700 font-semibold mb-2">Gender:</label>
                    <select id="editGender" name="gender" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="editAddress" class="block text-gray-700 font-semibold mb-2">Address:</label>
                    <input type="text" id="editAddress" name="address" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editContact" class="block text-gray-700 font-semibold mb-2">Contact:</label>
                    <input type="text" id="editContact" name="contact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editParentsContact" class="block text-gray-700 font-semibold mb-2">Parents Contact:</label>
                    <input type="text" id="editParentsContact" name="parentsContact" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="editEmail" class="block text-gray-700 font-semibold mb-2">Email:</label>
                    <input type="email" id="editEmail" name="email" required class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Update</button>
            </form>
            <button onclick="closeEditPopup()" class="mt-2 w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
        </div>
    </div>

    <!-- Success Popup -->
    <div id="successPopup" class="fixed bottom-0 right-0 mb-4 mr-4 p-4 bg-green-600 text-white rounded-lg hidden">
        Success!
    </div>

    <script>
        // Close the modals on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeStudentPopup();
                closeEditPopup();
            }
        });
    </script>
</body>
</html>
