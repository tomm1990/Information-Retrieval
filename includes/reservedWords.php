<?php
    function reservedWords()
    {
        // craate sql connection
        include('connection.php');

        // Search Reserved Words
        foreach(['things', 'out', 'life', 'with'] as $word)
        {
            // quick fixup
            $replace = " REPLACE(word, ' ', '') ";

            // make query to sql hits table
            $mainTable = "SELECT id,fileNo,word,offset
            FROM Hits
            WHERE ".$replace." = '".$word."'";

            // send query to sql hits table
            $result = mysqli_query($connection,$mainTable)
                or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$mainTable."</h2>");

            // print first table row
            $tableHeads = '<table style="font-family: Levenim MT , tahoma; margin: 0px auto; margin-bottom: 40px; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            $tableRowStart = '<td style="font-family: Levenim MT , tahoma;padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span style="">';

            $tableRowEnd = '</span></td>';

            $tableTdStart = '<td style="font-family: Levenim MT , tahoma;padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">';

            echo $tableHeads;
            {
                echo '<tr><a href="#">';
                echo $tableRowStart.'#'.$tableRowEnd;
                echo $tableRowStart.'Word'.$tableRowEnd;
                echo $tableRowStart.'File No'.$tableRowEnd;
                echo $tableRowStart.'Word No'.$tableRowEnd;
                echo '</a></tr>';
            }

            // print all sql data rows
            while($row = mysqli_fetch_array($result)){
                echo '<tr><a href="#">';
                echo $tableTdStart.$row["id"].'</td>';
                echo $tableTdStart.$row["word"].'</td>';
                echo $tableTdStart.$row["fileNo"].'</td>';
                echo $tableTdStart.$row["offset"].'</td>';
                echo '</a></tr>';
            }

            // end of table
            echo '</table>';
        }

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }

    // start
    reservedWords();
?>
