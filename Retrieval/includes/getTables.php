<?php

    function getInvertedTable()
    {
        // Init Sorting
        if(isset($_GET['sort'])){
            if($_GET['sort']=="hits")
                $sort = "sum(hits) desc";
            if($_GET['sort']=="word")
                $sort = "word";
            if($_GET['sort']=="id")
                $sort = "ID asc";
        }
        // Default Sorting
        else $sort = "ID asc";


        // craate sql connection
        include('connection.php');

        // make query to sql hits table
        $mainTable = "select
            id as ID,
            word as Keyword,
            count(distinct(fileNo)) as FromFiles, count(offset) as TotalHits
            from Hits where isStopList = 0
            group BY Keyword
            order by ".$sort."";
            //order by ".$sort." desc";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable) or die(mysqli_error());

        // print first table row
        echo '<table style="font-family: Levenim MT , arial; margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">KeyWord</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">From X Files</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; #fff; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Total Hits</span></td>';
            echo '</a></tr>';

            echo '<script type="text/javascript">
                function doSomething(value) {
                    var iframe = document.createElement("iframe");
                    iframe.id = "iframeSearch";
                    iframe.frameBorder = "0";
                    iframe.height = "100%";
                    iframe.width = "100%";
                    var html = "postingFile.php?searchId="+value+"";
                    iframe.src = encodeURI(html);
                    console.log("iframe: "+iframe.src);
                    document.body.appendChild(iframe); window.open("http://localhost:8080//Retrieval/Retrieval/includes/postingFile.php?searchId="+value+"", "_self", "");
                }
            </script>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            $ID = $row['ID'];
            $KeyWord = (string)$row['Keyword'];
            $FromFiles = $row['FromFiles'];
            $TotalHits = $row['TotalHits'];
            $temp = &$ID;
            echo '<tr onclick="Javascript:doSomething('.$temp.')">';

                echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">'.$ID.'</td>';
                echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$KeyWord.'</td>';
                echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$FromFiles.'</td>';
                echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$TotalHits.'</td>';

            echo '</tr>';
        }
        echo '</table>';

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);


    }


    // start
    getInvertedTable();

?>
