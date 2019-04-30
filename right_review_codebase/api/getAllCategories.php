<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$sql = 'SELECT * FROM rating_category;';

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>