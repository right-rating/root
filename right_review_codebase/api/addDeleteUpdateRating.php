<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$sql = '';
$records = array();

if ($_POST['operation'] == 'insert') {
    $np[':rating_hidden'] = 0;
    $np[':rating_val'] = $_POST['rating_val'];
    $np[':rating_category_id'] = $_POST['rating_category_id'];
    $np[':item_id'] = $_POST['item_id'];
    $np[':user_id'] = $_POST['user_id'];
    $sql = 'INSERT INTO rating
            (rating_hidden, rating_val, rating_category_id, item_id, user_id)
            VALUES
            (:rating_hidden, :rating_val, :rating_category_id, :item_id, :user_id);';
    $records['ran'] = 'insert ran';
}
else if ($_POST['operation'] == 'update') {
    $np[':rating_val'] = $_POST['rating_val'];
    $np[':rating_id'] = $_POST['rating_id'];
    $sql = 'UPDATE rating
            SET rating_val = :rating_val
            WHERE rating_id = :rating_id;';
    $records['ran'] = 'update ran';
}
else if ($_POST['operation'] == 'delete') {
    $np['rating_id'] = $_POST['rating_id'];
    $sql = 'DELETE FROM rating
            WHERE rating_id = :rating_id;';
    $records['ran'] = 'delete ran';
}

$stmt = $conn->prepare($sql);
$stmt->execute($np);

// $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $records['sql'] = $sql;
$records['operation'] = $_POST['operation'];
echo json_encode($records);
?>