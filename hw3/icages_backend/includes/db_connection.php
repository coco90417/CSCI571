<?php
    // Create a database connection
    $dbhost = "127.0.0.1:3374";
    $dbuser = "root";
    $dbpassword = "3374";
    $dbname = "hw3";
    $connection = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Cannot connect to server.");
    // Select a database
    mysql_select_db($dbname, $connection) or die("Cannot select database.");
?>
