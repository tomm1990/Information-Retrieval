<?php

    // craate sql connection
    include('connection.php');

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
        echo '<a href="http://localhost/RetrievalGit/Information-Retrieval/Retrieval/lyricsPage.html/'.$row["fileName"].'" class="list-group-item active">';
        echo '<h4 class="list-group-item-heading">'.$row["fileID"]." // ".$row["fileName"].'</h4>';
        echo '<p class="list-group-item-text">'.$row["songAuthor"].' - '.$row["songName"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songDate"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songSummary"].'</p>';
        echo '<img src='.$row["songPic"].'></a>';
    }

    // close sql connection
    mysqli_free_result($result);
    mysqli_close($connection);

?>
