<?php

    if(isset($_GET['delete'])){
        $deleteFlag = true;
        return;
    }
    else $deleteFlag = false;


    // craate sql connection
    include('connection.php');

    // make query to sql files table
    $query = "SELECT * FROM Files";

    // send query to sql files table
    $result = mysqli_query($connection , $query);
    if( !$result ){
        die("DB query failed from file_bars.php : ".mysqli_connect_error());
    }

    // print all sql data rows
    while( $row = mysqli_fetch_assoc($result) ){
        echo '<a href="javascript:showLyrics('.$row["fileID"].')" class="list-group-item active" style="width: 750px;">';
        echo '<h4 class="list-group-item-heading">'.$row["fileID"]." // ".$row["fileName"].'</h4>';
        echo '<p class="list-group-item-text">'.$row["songAuthor"].' - '.$row["songName"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songDate"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songSummary"].'</p>';
        echo '<img src="'.$row["songPic"].'"/>';
        echo '</a>';
        echo '<a href="deleteFile.php?fileid='.$row["fileID"].'">';
        echo '<img src="./images/x.png" class="deleteBtn" data-pin-nopin="true"/>';
        echo '</a>';
    }

    echo '<script type="text/javascript">
        function showLyrics(value) {
              window.open("includes/getLyrics.php?file="+value+"", "", "width=700,height=800");
        }

        function deleteFile(value){
                $.post("http://localhost:8080/Retrieval/Retrieval/deleteFile.php?filename="+value+"");

                $.post("http://localhost:8080/Retrieval/Retrieval/includes/createTables.php");
                window.open("http://localhost:8080/Retrieval/Retrieval/intro.html","_self");
                window.location.reload(true);

        }
    </script>';

    // close sql connection
    mysqli_free_result($result);
    mysqli_close($connection);
    header('Location: ../intro.html');
?>
