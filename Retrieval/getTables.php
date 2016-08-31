<?php
    function buildInvertedIndex($filenames)
    {
        include('includes/connection.php');
        $invertedIndex = [];
        $filesCounter = 0;
        $mainTable = "SELECT id,fileNo,word,offset,SUM(hits)
        FROM Hits
        group BY word
        order by id";
        $result = mysqli_query($conn,$mainTable) or die(mysqli_error());


        echo "<table>";
        while($row = mysqli_fetch_array($result)){
            $sumHits = $row['SUM(hits)'];
            echo "<tr>";
            echo "<td style='border: 1px solid; font-size: 17px'>".$row['id']."</td>";
            echo "<td style='border: 1px solid; font-size: 17px'>".$row['fileNo']."</td>";
            echo "<td style='border: 1px solid; font-size: 17px'>".$row['word']."</td>";
            echo "<td style='border: 1px solid; font-size: 17px'>".$row['offset']."</td>";
            echo "<td style='border: 1px solid; font-size: 17px'>".$sumHits."</td>";
            echo "</tr>";
        }
        echo "</table>";

        mysqli_free_result($result);
        mysqli_close($conn);

        return $invertedIndex;
    }





    function lookupWord($invertedIndex, $word)
    {
        return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
    }

    $invertedIndex = buildInvertedIndex(['file1.txt', 'file2.txt', 'file3.txt']);
?>
