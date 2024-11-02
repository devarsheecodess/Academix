<?php
include '../dbconnect.php';
include 'header.php';

echo "<script>
    const school_id = localStorage.getItem('adminID');
    document.cookie = 'school_id=' + school_id;
</script>";

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete' && !empty($_POST['notice_id'])) {
        $notice_id = $_POST['notice_id'];
        $school_id = $_COOKIE['school_id'];

        $sql = "DELETE FROM notices WHERE id = '$notice_id' AND school_id = '$school_id'";
        if ($conn->query($sql) === TRUE) {
            $message = 'Notice deleted successfully.';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $notice_id = $_POST['notice_id'];
    $school_id = $_COOKIE['school_id'];

    if (!empty($title) && !empty($content) && !empty($school_id) && !empty($notice_id)) {
        $sql = "UPDATE notices SET title = '$title', content = '$content' WHERE id = '$notice_id' AND school_id = '$school_id'";
        if ($conn->query($sql) === TRUE) {
            $message = 'Notice updated successfully.';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['action']) && !isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $school_id = $_COOKIE['school_id'];

    if (!empty($title) && !empty($content) && !empty($school_id)) {
        $sql = "INSERT INTO notices (school_id, title, content, posted_on) VALUES ('$school_id', '$title', '$content', NOW())";
        if ($conn->query($sql) === TRUE) {
            $message = 'Notice posted successfully.';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$school_id = $_COOKIE['school_id'];
$notices = [];
if (!empty($school_id)) {
    $sql = "SELECT * FROM notices WHERE school_id = '$school_id' ORDER BY posted_on DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notices[] = $row;
        }
    } else {
        
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
    <title>Notices</title>
</head>
<body>
    <div class="flex justify-center items-center">
        <h1 class="text-center text-3xl mt-20 font-bold fade-in-up">Notices</h1>
    </div>

    <div class="flex flex-wrap gap-10 justify-center items-start mt-10 px-4">

        <!-- Notice Form -->
        <div class="w-full md:w-1/2 lg:w-1/3 p-4 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Post a Notice</h2>
            <form method="POST" action="">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title:</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>

                <label for="content" class="block text-gray-700 font-semibold mt-4 mb-2">Notice:</label>
                <textarea id="content" name="content" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required></textarea>

                <button type="submit" class="w-full mt-4 p-2 bg-gray-800 text-white font-bold rounded-md hover:bg-gray-600 focus:outline-none">Post Notice</button>
            </form>
        </div>

        <!-- Display Notices -->
        <div class="w-full md:w-1/2 lg:w-1/3">
            <h2 class="text-2xl font-semibold mb-4">Posted Notices</h2>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <?php if ($message) : ?>
                    <div class="mb-4 p-2 bg-green-100 text-green-800 rounded-md">
                        <?= htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($notices)) : ?>
                    <?php foreach ($notices as $notice) : ?>
                        <div class="notice-item mb-4 p-4 border-b border-gray-300">
                            <h3 class="font-bold text-lg"><?= htmlspecialchars($notice['title']); ?></h3>
                            <p class="mt-2 text-gray-700 truncate"><?= htmlspecialchars(substr($notice['content'], 0, 100)) . '...'; ?></p>

                            <div class="flex justify-between items-center mt-4">
                                <small class="text-gray-500">Posted on: <?= htmlspecialchars($notice['posted_on']); ?></small>
                                <div class="flex space-x-4">
                                    <button onclick="showNoticePopup('<?= htmlspecialchars($notice['title']); ?>', '<?= htmlspecialchars($notice['content']); ?>')" class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <button onclick="showEditPopup('<?= htmlspecialchars($notice['id']); ?>', '<?= htmlspecialchars($notice['title']); ?>', '<?= htmlspecialchars($notice['content']); ?>')" class="text-green-500 hover:text-green-700">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <form method="POST" action="" class="inline" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="notice_id" value="<?= htmlspecialchars($notice['id']); ?>">
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

    <div id="noticeModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white w-3/4 max-w-lg p-6 rounded-lg shadow-lg">
            <h3 id="modalTitle" class="text-2xl font-bold mb-4">Notice Title</h3>
            <p id="modalContent" class="text-gray-700 mb-6">Full notice content goes here...</p>
            <button onclick="closeNoticePopup()" class="w-full p-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex justify-center items-center">
        <div class="bg-white w-3/4 max-w-lg p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-bold mb-4">Edit Notice</h3>
            <form id="editForm" method="POST" action="">
                <input type="hidden" id="editNoticeId" name="notice_id">
                <label for="editTitle" class="block text-gray-700 font-semibold mb-2">Title:</label>
                <input type="text" id="editTitle" name="title" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>

                <label for="editContent" class="block text-gray-700 font-semibold mt-4 mb-2">Notice:</label>
                <textarea id="editContent" name="content" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required></textarea>

                <button type="submit" name="update" class="w-full mt-4 p-2 bg-gray-800 text-white font-bold rounded-md hover:bg-gray-600 focus:outline-none">Update Notice</button>
            </form>
        </div>
    </div>

    <script>
        function showNoticePopup(title, content) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalContent').innerText = content;
            document.getElementById('noticeModal').classList.remove('hidden');
        }

        function closeNoticePopup() {
            document.getElementById('noticeModal').classList.add('hidden');
        }

        function showEditPopup(id, title, content) {
            document.getElementById('editNoticeId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditPopup() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this notice?');
        }
    </script>
</body>
</html>