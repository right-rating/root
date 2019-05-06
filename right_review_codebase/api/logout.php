<?php
    session_start();

    //remove PHPSESSID from browser
    if ( isset( $_COOKIE[session_name()] ) )
    {
      setcookie( session_name(), "", time()-3600, "/" );
      setcookie( "status", "logged_out", 0, "/");
    }
    //clear session from globals
    $_SESSION = array();

    //clear session from disk
    session_destroy();
    $ref="../index.php";
    echo '<script>window.location = "'.$ref.'";</script>';
?>
