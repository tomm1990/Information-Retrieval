<?php

    function searchWord()
    {
        // craate sql connection
        include('connection.php');

        // Get Search Input & find
        $word = $_GET['searchInput'];

        $counter = 0;

        // make query to sql hits table
        $mainTable = "SELECT id,fileNo,word,offset
        FROM Hits
        WHERE word='".$word."'";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable) or die(mysqli_error());
        $num_rows = mysqli_num_rows($result);

        echo "<h2 style='font-size: 25px; margin-left: 276px; font-weight: 100; color: #fff; margin-top: 30px;'>".$num_rows." Results Found</h2>";

        // print first table row
        echo '<table style="margin: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr><a href="#">';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">File No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word No</span></td>';
            echo '</a></tr>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            echo '<tr><a href="#">';

            echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">'.$row["id"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["word"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["fileNo"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["offset"].'</td>';

            echo '</a></tr>';
        }
        echo '</table>';
        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }

    // start
    searchWord();

?>
