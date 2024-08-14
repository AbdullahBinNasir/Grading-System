<?php
include 'db_connection.php';

$grades = $_POST['grades'];
$assignment_id = intval($_POST['assignment']); // Validate input

foreach ($grades as $student_id => $grade) {
    $student_id = intval($student_id); // Validate input
    $grade = mysqli_real_escape_string($conn, $grade); // Escape special characters
    $query = "INSERT INTO grades (student_id, assignment_id, grade) VALUES ($student_id, $assignment_id, '$grade')";
    mysqli_query($conn, $query);
}

echo json_encode(['status' => 'success']);

$conn->close();
?>
