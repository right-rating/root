<?php
// database config text
// mysql://b5f872661c80e1:4cb4913a@us-cdbr-iron-east-02.cleardb.net/heroku_2f5d071b652d3b7?reconnect=true
function getDBConn() {
    $dbname = 'heroku_2f5d071b652d3b7';
    $host = 'us-cdbr-iron-east-02.cleardb.net';
    $username = 'b5f872661c80e1';
    $password = '4cb4913a';

    if  (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $host = $url["host"];
        $dbname = substr($url["path"], 1);
        $username = $url["user"];
        $password = $url["pass"];
    }

    //creates db connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    //displays errors when accessing tables
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConn;
}
?>
