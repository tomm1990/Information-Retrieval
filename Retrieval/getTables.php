<?php

function buildInvertedIndex($filenames)
{
    $invertedIndex = [];
    $filesCounter = 0;

    foreach($filenames as $filename)
    {
        // Create sql Table for each file
        $sql = "CREATE TABLE songLyrics (
        fileNo INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        word VARCHAR(30) NOT NULL,
        offset VARCHAR(30) NOT NULL
        )";

        $data = file_get_contents($filename);
        if($data === false) die('Unable to read file: ' . $filename);
        $filesCounter++;

        preg_match_all('/(\w+)/', $data, $matches, PREG_SET_ORDER);
        $wordsCounter = 0;

        // temp print to show the process
        echo "<table style='margin-RIGHT: 10px; float: left; border: 2px solid; font-size: 18px;' class='table'>";
        echo "<tr>";
            echo "<td style='border: 1px solid; font-size: 18px;'><b>Files Number &emsp;<b></td>";
            echo "<td style='border: 1px solid;'><b>Offset &emsp;<b></td>";
            echo "<td style='border: 1px solid; font-size: 18px;'><b>Word &emsp;<b></td>";
        echo "</tr>";

        foreach($matches as $match)
        {
            $word = strtolower($match[0]);

            $wordsCounter++;

            echo "<tr>";
                echo "<td style='border: 1px solid; font-size: 17px;'>".$filesCounter."</td>";
                echo "<td style='border: 1px solid; font-size: 17px;'>".$wordsCounter."</td>";
                echo "<td style='border: 1px solid; font-size: 17px;'>".$word."</td>";
            echo "</tr>";

            // Insert word to sql table
            $addToSql = "INSERT INTO songLyrics (fileNo, word, offset)
            VALUES ($filesCounter, $word, $wordsCounter)";

            if(!array_key_exists($word, $invertedIndex)) $invertedIndex[$word] = [];
            if(!in_array($filename, $invertedIndex[$word], true)) $invertedIndex[$word][] = $filename;
        }
        echo "</table>";
    }
    return $invertedIndex;
}
 




function lookupWord($invertedIndex, $word)
{
    return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
}
 
$invertedIndex = buildInvertedIndex(['file1.txt', 'file2.txt', 'file3.txt']);

?>