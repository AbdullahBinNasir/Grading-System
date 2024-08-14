<?php
include 'db_connection.php';

$semester_id = intval($_GET['semester_id']); // Validate input
$query = "SELECT id, name FROM assignments WHERE semester_id = $semester_id";
$result = mysqli_query($conn, $query);

$assignments = [];
while ($row = $result->fetch_assoc()) {
    $assignments[] = $row;
}
echo json_encode($assignments);

$conn->close();
?>
