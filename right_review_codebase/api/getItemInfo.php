<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[':item_id'] = $_GET['item_id'];

$sql = 'SELECT * 
        FROM item 
        WHERE item_id = :item_id;';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>