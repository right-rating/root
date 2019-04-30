<?php

include 'DBConnection.php';
$conn = getDBConn();

session_start();

$np = array();
$np[':user_email'] = $_GET['user_email'];

$sql = 'SELECT * FROM users
        WHERE user_email = :user_email;';
        
$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetch();

echo json_encode($records);

?>