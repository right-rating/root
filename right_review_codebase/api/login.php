<?php
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
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      echo "Not Supported";
      break;
    case 'POST':
      // Get the body json that was sent
      $rawJsonString = file_get_contents("php://input");

      //var_dump($rawJsonString);

      // Make it a associative array (true, second param)
      $jsonData = json_decode($rawJsonString, true);

      // TODO: do stuff to get the $results which is an associative array
      $dbname = 'heroku_2f5d071b652d3b7';
      $host = 'us-cdbr-iron-east-02.cleardb.net';
      $username = 'b5f872661c80e1';
      $password = '4cb4913a';

      // Get Data from DB
      $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT * FROM users " .
             "WHERE user_email = :email;";

      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array (":email" => $_POST['email']));

      $record = $stmt->fetch();

      $hash = $record['user_password'];
      $pass = $_POST['password'];
      $isAuthenticated = password_verify($pass, $hash);

      if ($isAuthenticated) {
        $_SESSION["user_email"] = $record["user_email"];
        $_SESSION["user_role"] = $record["user_role"];
      }

      // Allow any client to access
      header("Access-Control-Allow-Origin: *");
      // Let the client know the format of the data being returned
      header("Content-Type: application/json");

      // // Sending back down as JSON
      // //***********************************************************************************
      // $record['formPass'] = $_POST['password'];
      // $options = [
      //   'cost' => 11,
      //   ];
      // $record['formPassE'] = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    
      // // $record['isAuth'] = $isAuthenticated;
      // $record['DBPass'] = $record['user_password'];
      // echo json_encode($record);
      // //***********************************************************************************
      echo json_encode(array("isAuthenticated" => $isAuthenticated));

      break;
    case 'PUT':
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      echo "Not Supported";
      break;
    case 'DELETE':
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      break;
  }
?>