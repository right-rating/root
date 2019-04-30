<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[':rating_category_id'] = $_GET['rating_category_id'];
$np[':item_id'] = $_GET['item_id'];
$np[':user_id'] = $_GET['user_id'];

$sql = 'SELECT * FROM rating
        INNER JOIN rating_category
        ON rating_category.rating_category_id = rating.rating_category_id
        WHERE rating.rating_category_id = :rating_category_id AND rating.item_id = :item_id AND rating.user_id = :user_id';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);

?>