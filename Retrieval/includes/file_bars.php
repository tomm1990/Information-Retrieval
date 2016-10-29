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
        $fileName = explode("e", $row["fileName"]);
        $fileName2 = explode(".", $fileName[1]);

        echo '<a href="javascript:showLyrics('.$fileName2[0].')" class="list-group-item active">';
        echo '<h4 class="list-group-item-heading">'.$row["fileID"]." // ".$row["fileName"].'</h4>';
        echo '<p class="list-group-item-text">'.$row["songAuthor"].' - '.$row["songName"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songDate"].'</p>';
        echo '<p class="list-group-item-text">'.$row["songSummary"].'</p>';

        echo '<img src="./images/x.png" class="deleteBtn" onclick="deleteFile('.$fileName2[0].');";>';
        echo '<img src='.$row["songPic"].'></a>';

    }

    echo '<script type="text/javascript">
        function showLyrics(value) {
            path =  "../data/file"+value+".txt";
//            var iframe = document.createElement("iframe");
//            iframe.id = "iframeSearch";
//            iframe.frameBorder = "0";
//            iframe.height = "100%";
//            iframe.width = "100%";
//            var html = "includes/getLyrics.php?file="+path+"";
//            iframe.src = encodeURI(html);
//            console.log("iframe: "+iframe.src);
//            document.body.appendChild(iframe);
              window.open("http://localhost:8080//Retrieval/Retrieval/includes/getLyrics.php?file="+path+"", "", "width=700,height=800");
        }

        function deleteFile(value){
                $.post("http://localhost:8080/Retrieval/Retrieval/deleteFile.php?filename="+value+"");
//                window.open("http://localhost:8080/Retrieval/Retrieval/intro.html","_self");
                window.location.reload(true);

                $.post("http://localhost:8080/Retrieval/Retrieval/includes/createTables.php");
                window.open("http://localhost:8080/Retrieval/Retrieval/intro.html","_self");
                location = "http://localhost:8080/Retrieval/Retrieval/intro.html";
                window.location.reload(true);
        }
    </script>';



    // close sql connection
    mysqli_free_result($result);
    mysqli_close($connection);

?>
