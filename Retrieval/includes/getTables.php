<?php

    function getInvertedTable()
    {
        // Init Sorting
        $sort = "word";
        $sort = "sum(hits)";
        $sort2 = "asc";

        // craate sql connection
        include('connection.php');

        // make query to sql hits table
        $mainTable = "SELECT id,fileNo,word,offset,SUM(hits)
        FROM Hits
        group BY word
        order by ".$sort." desc";

        $mainTable2 = "select
            id as ID,
            word as Keyword,
            count(distinct(fileNo)) as FromFiles, count(offset) as TotalHits
            from Hits
            group BY Keyword
            order by ID ".$sort2."";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable2) or die(mysqli_error());

        // Tommy don't worry tommorow i'll move this stylesheet to external file

        // print first table row
        echo '<table style="margin-left: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">KeyWord</span></td>';
            //echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">File No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">From X Files</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; #fff; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Total Hits</span></td>';
            echo '</a></tr>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            //$sumHits = $row['SUM(hits)'];
            $ID = $row['ID'];
            $KeyWord = $row['Keyword'];
            $FromFiles = $row['FromFiles'];
            $TotalHits = $row['TotalHits'];
            echo '<tr>';

            echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); "><a href="javascript:alert('.$ID.')">'.$ID.'</a></td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); "><a href="javascript:alert()">'.$KeyWord.'</a></td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); "><a href="javascript:alert('.$FromFiles.')">'.$FromFiles.'</a></td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); "><a href="javascript:alert('.$TotalHits.')">'.$TotalHits.'</a></td>';
            //echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; #fff; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$sumHits.'</td>';

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
