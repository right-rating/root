<?php
    session_start();

    if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_role'])){
      header("Location: login.html");
    }
    // if (!isset($_SESSION['item_id'])){
    //   header("Location: dashboard/login.html");
    // }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title id="pageTitle"></title>
        <link href="css/item.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/css/mdb.min.css" rel="stylesheet">
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
    </head>

    <body>
      <?php
        $page = "new_item";
        include "pagetools/page-top.php";
       ?>
        <div class="jumbotron text-left" style="margin-bottom:0">
            <img id="rightReviewLogo" src="img/rightReviewLogo/logo_transparent_background.png" alt="Right Review Logo"></img>
            <img id="itemLogoImage" src=""></img>
            <div id="warningMsg"></div>
            <h1 id="itemName"></h1>
            <p id="itemDescription"></p>

            <h1>Average Ratings</h1>
            <table id='categoryRatingTotal'></table>
        </div>

        <div class="container" style="margin-top:30px">
            <h1 id="userRoleTitle"></h1>
            <table id='individualRatings'></table>
            <button id='ratingSubmissionButton' onclick='submitRatingsInTable()'>Submit Rating</button>
        </div>

    </body>

    <div id='error'></div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/item.js"></script>
    <script type="text/javascript" src="js/itemMaliciousDetect.js"></script>


</html>
