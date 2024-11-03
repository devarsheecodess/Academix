<?php
include '../dbconnect.php';
include 'header.php';

echo "<script>
    const studentID = localStorage.getItem('studentID');
    document.cookie = 'studentID=' + studentID;
</script>";

$school_id = null;

if (!empty($_COOKIE['studentID'])) {
    $studentID = $_COOKIE['studentID'];

    $sql = "SELECT school_id FROM students WHERE id = $studentID";
    $result = $conn->query($sql);
    
    if ($row = $result->fetch_assoc()) {
        $school_id = $row['school_id'];
    }
}

$notices = [];
if (!empty($school_id)) {
    // Direct query for notices
    $sql = "SELECT * FROM notices WHERE school_id = $school_id ORDER BY posted_on DESC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Student Notices</title>
</head>
<body>
    <div class="flex justify-center items-center">
        <h1 class="text-center text-3xl mt-20 font-bold text-gray-800 fade-in-up">Notices</h1>
    </div>

    <div class="flex flex-wrap gap-10 justify-center items-start mt-10 px-4">

        <!-- Display Notices -->
        <div class="w-full md:w-1/2 lg:w-1/3">
            <h2 class="text-2xl font-semibold mb-4">Posted Notices</h2>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <?php if (!empty($notices)) : ?>
                    <?php foreach ($notices as $notice) : ?>
                        <div class="notice-item mb-4 p-4 border-b border-gray-300">
                            <h3 class="font-bold text-lg"><?= htmlspecialchars($notice['title']); ?></h3>
                            <p class="mt-2 text-gray-700 truncate"><?= htmlspecialchars(substr($notice['content'], 0, 100)) . '...'; ?></p>

                            <!-- Bottom section with date and buttons -->
                            <div class="flex justify-between items-center mt-4">
                                <small class="text-gray-500">Posted on: <?= htmlspecialchars($notice['posted_on']); ?></small>
                                <div class="flex space-x-4">
                                    <button onclick="showNoticePopup('<?= htmlspecialchars($notice['title']); ?>', '<?= htmlspecialchars($notice['content']); ?>')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-gray-500">No notices posted yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Notice Popup Modal -->
    <div id="noticeModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white w-3/4 max-w-lg p-6 rounded-lg shadow-lg">
            <h3 id="modalTitle" class="text-2xl font-bold mb-4">Notice Title</h3>
            <p id="modalContent" class="text-gray-700 mb-6">Full notice content goes here...</p>
            <button onclick="closeNoticePopup()" class="w-full p-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>

    <script>
        // Set the studentID from local storage as a cookie
        (function() {
            const studentID = localStorage.getItem('studentID');
            if (studentID) {
                document.cookie = 'studentID=' + studentID;
            }
        })();

        // Function to show the notice popup
        function showNoticePopup(title, content) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalContent').innerText = content;
            document.getElementById('noticeModal').classList.remove('hidden');
        }

        // Function to close the notice popup
        function closeNoticePopup() {
            document.getElementById('noticeModal').classList.add('hidden');
        }
    </script>
</body>
</html>
