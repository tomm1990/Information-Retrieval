<?php
    //craate sql connection
    $servername = "localhost";
    $username = "retuser";
    $password = "retuser!";
    $dbname = "inforet";

    // Create connection
    $connection = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
