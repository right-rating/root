<?php
    include 'DBConnection.php';
    
    $conn = getDBConn();

    // $sql = "SELECT item_id, item_name, item_description FROM rating INNER JOIN item ON item.item_id = rating.item_id";
    // $sql = "SELECT item.item_id, AVG(rating.rating_val) FROM item INNER JOIN rating ON rating.item_id = item.item_id GROUP BY item.item_id";
    
    $sql = "SELECT item.item_id, item.item_name, item.item_description, AVG(rating.rating_val) FROM item INNER JOIN rating ON rating.item_id = item.item_id GROUP BY item.item_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($records);
?>