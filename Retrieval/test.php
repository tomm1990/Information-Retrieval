<?php

    $filesCounter = 1;

    // craate sql connection
    include('/includes/connection.php');

    // make query to sql files table
    $query = "select * from Files";

    // send query to sql files table
    $result = mysqli_query($connection , $query);
    if( !$result ){
        echo "DB query failed from file_bars.php";
        die("DB query failed from file_bars.php");
    }

    // print all sql data rows
    while( $row = mysqli_fetch_assoc($result) )
        $filesCounter++;

    // close sql connection
    mysqli_free_result($result);
    mysqli_close($connection);

    $checkTest = getcwd()."/data/";

    $filename = $_GET['filename'];

    $path = getcwd()."/source/".$filename."";
    $newfile = getcwd()."/data/file".$filesCounter.".txt";

    if(file_exists( $path ))
    {
        copy($path, $newfile);
    }


?>
