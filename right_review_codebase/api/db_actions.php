<?php
include_once "DBConnection.php";


function add_entry($type,$name,$description,$image)
{
  $conn = getDBConn();

  $sql = "insert into item (item_name, item_description, item_image_url) values (:name, :description,:image);";
  $namedParameters[":name"] = $name;
  $namedParameters[":image"] = $image;
  $namedParameters[":description"] = $description;
  $stmnt = $conn->prepare($sql);

  $stmnt->execute($namedParameters);
}

 ?>
