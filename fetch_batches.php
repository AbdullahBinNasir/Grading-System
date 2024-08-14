<?php
include 'db_connection.php';

$query = "SELECT id, name FROM batches";
$result = mysqli_query($conn, $query);

$batches = [];
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}
echo json_encode($batches);

$conn->close();
?>
