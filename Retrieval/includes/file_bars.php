<?php
    include('connection.php');
    require('search.php');
    $query = "select * from Files";
    $result = mysqli_query($connection , $query);
    if( !$result ){
        echo "DB query failed from file_bars.php";
        die("DB query failed from file_bars.php");
    }
    while( $row = mysqli_fetch_assoc($result) ){
        echo "<a href='#' class='list-group-item active'>";
        echo '<h4 class="list-group-item-heading">'.$row["fileID"]." // ".$row["fileName"]." // ".$row["songAuthor"].'</h4>';
        echo '<p class="list-group-item-text">'.$row["songDate"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songSummary"].'</p>';
        echo '<img src='.$row["songPic"].'></a>';
    }

    mysqli_free_result($result);
    mysqli_close($connection);
?>
