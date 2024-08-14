<?php
include 'db_connection.php';

$batch_id = intval($_GET['batch_id']); // Validate input
$query = "SELECT id, name FROM semesters WHERE batch_id = $batch_id";
$result = mysqli_query($conn, $query);

$semesters = [];
while ($row = $result->fetch_assoc()) {
    $semesters[] = $row;
}
echo json_encode($semesters);

$conn->close();
?>
