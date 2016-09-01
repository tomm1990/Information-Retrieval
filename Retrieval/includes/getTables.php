<?php
    function buildInvertedIndex($filenames)
    {
    // Init Sorting
    $sort = "word";
    $sort = "sum(hits)";

    //include('connection.php');

    //craate sql connection
    $servername = "localhost";
    $username = "galServer";
    $password = "301gals20";
    $dbname = "myDB";
    // Create connection
    $connection = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }


        $invertedIndex = [];
        $filesCounter = 0;
        $mainTable = "SELECT id,fileNo,word,offset,SUM(hits)
        FROM Hits
        group BY word
        order by ".$sort." desc";
        $result = mysqli_query($connection,$mainTable) or die(mysqli_error());

        // Tommy don't worry tommorow i'll move this stylesheet to external file

        echo '<table style="margin: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr><a href="#">';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">File No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; #fff; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Hits No</span></td>';
            echo '</a></tr>';

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

        mysqli_free_result($result);
        mysqli_close($connection);

        return $invertedIndex;
    }


    function lookupWord($invertedIndex, $word)
    {
        return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
    }

    $invertedIndex = buildInvertedIndex(['file1.txt', 'file2.txt', 'file3.txt']);




?>
