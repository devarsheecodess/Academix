<?php
include '../dbconnect.php';
include 'header.php';

$studentId = isset($_COOKIE['studentId']) ? (int)$_COOKIE['studentId'] : null;
$sql = "SELECT subject, semester_marks, it1, it2, it3 FROM student_marks WHERE studentId = $studentId";
$result = $conn->query($sql);

$totalMarks = 0;
$totalSubjects = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Overview</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <h1 class="text-center text-3xl mt-20 font-bold text-blue-900 fade-in-up">Marks</h1>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl mx-auto mt-10">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="border p-4">Subject</th>
                    <th class="border p-4">Semester Marks</th>
                    <th class="border p-4">IT1</th>
                    <th class="border p-4">IT2</th>
                    <th class="border p-4">IT3</th>
                    <th class="border p-4">Average IT</th>
                    <th class="border p-4">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $averageIT = ($row['it1'] + $row['it2'] + $row['it3']) / 3;
                        $total = $row['semester_marks'] + $averageIT;
                        $totalMarks += $total;
                        $totalSubjects++;
                ?>
                    <tr class="hover:bg-blue-100 transition duration-200">
                        <td class="border p-4"><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td class="border p-4"><?php echo htmlspecialchars($row['semester_marks']); ?></td>
                        <td class="border p-4"><?php echo htmlspecialchars($row['it1']); ?></td>
                        <td class="border p-4"><?php echo htmlspecialchars($row['it2']); ?></td>
                        <td class="border p-4"><?php echo htmlspecialchars($row['it3']); ?></td>
                        <td class="border p-4"><?php echo round($averageIT, 2); ?></td>
                        <td class="border p-4"><?php echo round($total, 2); ?></td>
                    </tr>
                <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="7" class="text-center border p-4">No marks available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if ($totalSubjects > 0): ?>
            <div class="mt-6 text-xl font-semibold text-center text-blue-900">
                Overall Percentage: <?php echo round(($totalMarks / ($totalSubjects * 100)) * 100, 2); ?>%
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
<?php $conn->close(); ?>
