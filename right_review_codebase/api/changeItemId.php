<?php
    session_start();
    
    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);
    
    switch($httpMethod) {
        case "GET":
        $_SESSION['item_id'] = $_GET['new_id'];
        
        var_dump($_SESSION['item_id']);
        
        // header("Location: ../item.php");
        
        break;  
        
    }
?>