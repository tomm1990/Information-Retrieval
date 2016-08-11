<?php
//require('connection.php');

//CREATE TABLE `myDB`.`Info` (
//  `word` VARCHAR(30) NOT NULL,
//  `file` VARCHAR(30) NOT NULL,
//  `offset` INT NOT NULL,
//  `num` INT NOT NULL,
//  PRIMARY KEY (`num`));

function buildInvertedIndex($filenames)
{
    $invertedIndex = [];
    $filesCounter = 0;

    // craate sql connection
    $servername = "localhost";
    $username = "galServer";
    $password = "301gals20";
    $dbname = "myDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $mainTable = "SELECT id,fileNo,word,offset,SUM(hits)
                FROM Hits
                group BY word
                order by sum(hits) desc";

     $result = mysqli_query($conn,$mainTable) or die(mysqli_error());;


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


//    foreach($filenames as $filename)
//    {
//        // Create sql Table for each file
////        $sql = "CREATE TABLE songLyrics (
////        fileNo INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
////        word VARCHAR(30) NOT NULL,
////        offset VARCHAR(30) NOT NULL
////        )";
//
//
//
//        $data = file_get_contents($filename);
//        if($data === false) die('Unable to read file: ' . $filename);
//        $filesCounter++;
//
//        preg_match_all('/(\w+)/', $data, $matches, PREG_SET_ORDER);
//        $wordsCounter = 0;
//
//        // temp print to show the process
//        echo "<table style='margin-RIGHT: 10px; float: left; border: 2px solid; font-size: 18px;' class='table'>";
//        echo "<tr>";
//            echo "<td style='border: 1px solid; font-size: 18px;'><b>Files Number &emsp;<b></td>";
//            echo "<td style='border: 1px solid;'><b>Offset &emsp;<b></td>";
//            echo "<td style='border: 1px solid; font-size: 18px;'><b>Word &emsp;<b></td>";
//        echo "</tr>";
//
//        while($row = mysql_fetch_array($result)){
//            echo "<tr>
//            <td style='border: 1px solid; font-size: 17px'>".$row['id']."</td>
//            <td style='border: 1px solid; font-size: 17px'>".$row['fileNo']."</td>
//            <td style='border: 1px solid; font-size: 17px'>".$row['word']."</td>
//            <td style='border: 1px solid; font-size: 17px'>".$row['offset']."</td>
//            <td style='border: 1px solid; font-size: 17px'>".$row['SUM(hits)']."</td>
//            </tr>";
//        }
//
////        foreach($matches as $match)
////        {
////            $word = strtolower($match[0]);
////
////            $wordsCounter++;
////
////
////
////            echo "<tr>";
////                echo "<td style='border: 1px solid; font-size: 17px;'>".$filesCounter."</td>";
////                echo "<td style='border: 1px solid; font-size: 17px;'>".$wordsCounter."</td>";
////                echo "<td style='border: 1px solid; font-size: 17px;'>".$word."</td>";
////            echo "</tr>";
////
////            // Insert word to sql table
////            //$addToSql = "INSERT INTO songLyrics (fileNo, word, offset)
////            //VALUES ($filesCounter, $word, $wordsCounter)";
////
////            if(!array_key_exists($word, $invertedIndex)) $invertedIndex[$word] = [];
////            if(!in_array($filename, $invertedIndex[$word], true)) $invertedIndex[$word][] = $filename;
////        }
//        echo "</table>";
//    }
    return $invertedIndex;
}
 




function lookupWord($invertedIndex, $word)
{
    return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
}
 
$invertedIndex = buildInvertedIndex(['file1.txt', 'file2.txt', 'file3.txt']);

?>
