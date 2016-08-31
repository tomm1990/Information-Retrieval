<?php
     //craate sql connection
    $servername = "localhost";
    $username = "galServer";
    $password = "301gals20";
    $dbname = "myDB";
    // Create connection
    $connection = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
