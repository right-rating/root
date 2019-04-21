<?php
    include 'DBConnection.php';
    
    $conn = getDBConn();

    $sql = "SELECT * FROM item ORDER BY item_id ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($records);
?>