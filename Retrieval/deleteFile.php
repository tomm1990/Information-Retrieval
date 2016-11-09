<?php


    $fileId = $_GET['filename'];

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
        while( $row = mysqli_fetch_assoc($result) ){
            if($fileId==$row["fileID"])
                $filename=$row["fileName"];
        }


        $chars = explode("../data/",$filename);
        $convert = implode("",$chars);
        $temp = '/data/';
        $final = $temp.$convert;

    $deletedfile = getcwd()."".$final."";

    unlink($deletedfile);

    // close sql connection
    mysqli_free_result($result);
    mysqli_close($connection);

?>
