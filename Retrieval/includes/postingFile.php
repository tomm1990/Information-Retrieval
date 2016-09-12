<?php
    function getPostingFile( $word ){
        include('connection.php');

        // make query to sql hits table
        $postingFileSql = "select
            fileNo as FileNum ,
            sum(hits) as Hits
            from Hits
            where word=".$word."
            group by fileNo";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable2) or die(mysqli_error());


        echo '<table style="margin-left: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

        echo '<tr><a href="#">';
        echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">FileNum</span></td>';
        echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">Hits</span></td>';
        echo '</a></tr>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            //$sumHits = $row['SUM(hits)'];
            $fileNo = $row['FileNum'];
            $hits = $row['Hits'];
            echo '<tr><a href="#">';

            echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">'.$fileNo.'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$hits.'</td>';
            //echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$FromFiles.'</td>';
            //echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$TotalHits.'</td>';
            //echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; #fff; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$sumHits.'</td>';

            echo '</a></tr>';
        }
        echo '</table>';

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }

    getPostingFile( $word );
?>
