<?php
     //craate sql connection
    $servername = "localhost";
    $username = "galServer";
    $password = "301gals20";
    $dbname = "myDB";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
