<head>
<?php
  include "pagetools/head.php";
 ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="search.html">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Add a Website<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
<div class="card">
  <div class="card-body">
  <form class="" action="index.html" method="post">
    <table>
      <tr>
        <td>
          <label for="item_name">Website Name</label>
        </td><td>
          <input type="text" name="item_name" value=""></input>
        </td>
      </tr>
      <tr>
        <td>
        <label for="item_image">Image URL:</label>
        </td><td>
        <input type="text" name="item_image" value=""></input>
        </td>
      <tr>
      <tr>
        <tr>
          <td>
            <label for="Description"> Description </label>
            </td><td>
            <textarea name="Description" value=""></textarea>
          </td>
        </tr>


      </table>
    <button type="button" name="submit" id="submit_webpage">Submit Website</button>
    <!-- item_id and date_created generated automatically -->
  </form> </div> </div> </body> <script
  type="text/javascript"src="js/add_item.js">

</script>
