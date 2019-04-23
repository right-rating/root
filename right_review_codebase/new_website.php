<head>
<?php
  include "pagetools/head.php";
 ?>
</head>
<body>
<?php
  $page="new_webpage";
include "pagetools/page-top.php";

?>

  <form class="" action="index.html" method="post">
    <label for="item_name">Website Name</label>
    <input type="text" name="item_name" value=""></input>
    <label for="Description"> Description </label>
    <textarea name="Description" value=""></textarea>
    <label for="item_image">Image URL:</label>
    <input type="text" name="item_image" value=""></input>
    <button type="button" name="submit" id="submit_webpage">Submit Website</button>
    <!-- item_id and date_created generated automatically -->
  </form>
</body>
<script type="text/javascript"src="js/add_item.js">

</script>
