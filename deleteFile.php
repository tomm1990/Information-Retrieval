<?php
    if(isset($_GET['fileid'])) {
        $fileId = $_GET['fileid'];

        // create sql connection
        include('includes/connection.php');

        // make query to sql files table
        $query = "SELECT `fileName` FROM Files WHERE `fileID`='".$fileId."';";

        // send query to sql files table
        $result = mysqli_query($connection , $query);
        if( !$result ){
            die("DB query failed from delete.php : " . mysqli_connect_error());
        }
        $row = mysqli_fetch_assoc($result);
        $filename =  $row['fileName'];

        $chars = explode("../data/",$filename);
        $convert = implode("",$chars);
        $temp = '/data/';
        $final = $temp.$convert;

        $deletedfile = getcwd()."".$final."";

        unlink($deletedfile);


        $query = "DELETE FROM Files where `fileID`='".$fileId."';";
        $result = mysqli_query($connection , $query);
        if( !$result ){
            die("DB query failed from delete.php : " . mysqli_connect_error());
        }

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
        header('Location: intro.html');

    } else {
        echo 'Cant fetch filename';
    }
?>
