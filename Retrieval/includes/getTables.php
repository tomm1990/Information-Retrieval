<?php

    function getInvertedTable()
    {
        // Init Sorting
        $sort = "word";
        $sort = "sum(hits)";

        // craate sql connection
        include('connection.php');

        // make query to sql hits table
        $mainTable = "SELECT id,fileNo,word,offset,SUM(hits)
        FROM Hits
        group BY word
        order by ".$sort." desc";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable) or die(mysqli_error());

        // Tommy don't worry tommorow i'll move this stylesheet to external file

        // print first table row
        echo '<table style="margin-left: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr><a href="#">';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">File No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; #fff; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Hits No</span></td>';
            echo '</a></tr>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            $sumHits = $row['SUM(hits)'];
            echo '<tr><a href="#">';

            echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">'.$row["id"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["word"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["fileNo"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["offset"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; #fff; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$sumHits.'</td>';

            echo '</a></tr>';
        }
        echo '</table>';

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }

    // start
    getInvertedTable();

?>
