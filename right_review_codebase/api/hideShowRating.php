<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[':rating_id'] = $_POST['rating_id'];

$sql = '';
$records = array();

if ($_POST['op'] == 'hide') {
    $sql = 'UPDATE rating
            SET rating_hidden = TRUE
            WHERE rating_id = :rating_id;';
    $records['op'] = strval($POST['rating_id']) . " hidden";
}
else if ($_POST['op'] == 'show') {
    $sql = 'UPDATE rating
            SET rating_hidden = FALSE
            WHERE rating_id = :rating_id;';
    $records['op'] = strval($POST['rating_id']) . " shown";
}

$stmt = $conn->prepare($sql);
$stmt->execute($np);

echo json_encode($records);
?>