<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np[':item_id'] = $_GET['item_id'];
$np[':rating_category_id'] = $_GET['rating_category_id'];

$sql = 'SELECT rating_category.rating_category_id, rating.rating_hidden, AVG(rating.rating_val), rating_category.rating_category_name, rating_category.rating_category_image_url   
        FROM rating 
        INNER JOIN rating_category 
        ON rating.rating_category_id=rating_category.rating_category_id
        WHERE rating.item_id = :item_id AND rating_category.rating_category_id = :rating_category_id AND rating.rating_hidden = 0
        ORDER BY rating_category.rating_category_id;';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>