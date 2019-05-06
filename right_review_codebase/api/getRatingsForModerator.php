<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[':item_id'] = $_GET['item_id'];

$sql = 'SELECT rating.item_id, rating.rating_id, rating.rating_hidden, rating.rating_val, rating_category.rating_category_name, item.item_name, users.user_email
        FROM rating
        INNER JOIN rating_category
        INNER JOIN item
        INNER JOIN users
        ON (rating.rating_category_id = rating_category.rating_category_id AND 
        rating.item_id = item.item_id AND 
        rating.user_id = users.user_id)
        WHERE rating.item_id = :item_id;';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>