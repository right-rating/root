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
      // Allow any client to access
      header("Access-Control-Allow-Origin: *");
      // Let the client know the format of the data being returned
      header("Content-Type: application/json");

      // Get the body json that was sent
      $rawJsonString = file_get_contents("php://input");

      // Make it a associative array (true, second param)
      $jsonData = json_decode($rawJsonString, true);

      // Perform password validations

      // Was a password provided?
      if (empty($_POST["password"])) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "No password provided"));

        exit;
      }

      if (empty($_POST["confirmation"])) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "No password confirmation provided"));

        exit;
      }

      if ($_POST["password"] != $_POST["confirmation"]) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "password does not equal confirmation"));

        exit;
      }

      // Hash my password!!!!!!
      $options = [
        'cost' => 11,
      ];

      $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

      try {

        // TODO: do stuff to get the $results which is an associative array
        $dbname = 'heroku_2f5d071b652d3b7';
        $host = 'us-cdbr-iron-east-02.cleardb.net';
        $username = 'b5f872661c80e1';
        $password = '4cb4913a';

        // Get Data from DB
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO users (user_email, user_password, user_role) " .
               "VALUES (:email, :hashedPassword, 'user');";

        $stmt = $dbConn->prepare($sql);
        $stmt->execute(array (
          ":email" => $_POST['email'],
          ":hashedPassword" => $hashedPassword));

        $_SESSION["user_email"] = $_POST['email'];
        $_SESSION["user_role"] = 'user';

        // Sending back down as JSON
        echo json_encode(array("isSignedUp" => true));

      } catch (PDOException $ex) {
        switch ($ex->getCode()) {
          case "23000":
            echo json_encode(array(
              "isSignedUp" => false,
              "message"=> "email taken, try another",
              "details" => $ex->getMessage()));
            break;
          default:
            echo json_encode(array(
              "isSignedUp" => false,
              "message"=> $ex->getMessage(),
              "details" => $ex->getMessage()));
            break;
        }
        exit;
      }
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
