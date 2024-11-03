<?php
include '../dbconnect2.php';
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
    <!-- Head section remains the same -->
</head>
<body>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
        <h2 class="text-2xl font-bold mb-6 text-purple-700 text-center">Marks Overview</h2>
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-purple-700 text-white">
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
                    <tr>
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
            <div class="mt-6 text-xl font-semibold text-center">
                Overall Percentage: <?php echo round(($totalMarks / ($totalSubjects * 100)) * 100, 2); ?>%
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
<?php $conn->close(); ?>
