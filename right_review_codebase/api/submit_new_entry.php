<?php
  include_once "db_actions.php";
  session_start();

    $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

    switch($httpMethod) {
      case "OPTIONS":
        // Allows anyone to hit your API, not just this c9 domain
        header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
        header("Access-Control-Allow-Methods: POST, GET");
        header("Access-Control-Max-Age: 3600");
        exit();

      case "GET":
        // Allow any client to access
        header("Access-Control-Allow-Origin: *");
        add_entry(
          $type = $_GET["type"],
          $name = $_GET["item_name"],
          $description = $_GET["description"],
          $image = $_GET["item_image"]
        );
          var_dump($_GET);
        break;
      case 'POST':
        // Allow any client to access
        header("Access-Control-Allow-Origin: *");
        add_entry(
          $type = $_POST["type"],
          $name = $_POST["item_name"],
          $description = $_POST["description"],
          $image = $_POST["item_image"]
        );
          var_dump($_POST);
        break;
      case 'PUT':
        header("Access-Control-Allow-Origin: *");
        http_response_code(401);
        echo "Not Supported";
        break;
      case 'DELETE':
        header("Access-Control-Allow-Origin: *");
        http_response_code(401);
        break;
    }
?>
