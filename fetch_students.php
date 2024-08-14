<?php
include 'db_connection.php';

$batch_id = intval($_GET['batch_id']); // Validate input
$semester_id = intval($_GET['semester_id']); // Validate input
$assignment_id = intval($_GET['assignment_id']); // Validate input

$query = "SELECT id, name FROM students WHERE batch_id = $batch_id";
$result = mysqli_query($conn, $query);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
echo json_encode($students);

$conn->close();
?>
