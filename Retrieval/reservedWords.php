<?php

function buildInvertedIndex($filenames)
{
    $invertedIndex = [];
    $filesCounter = 0;

    foreach($filenames as $filename)
    {
        $sql = "CREATE TABLE MyGuests (
        fileNo INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        word VARCHAR(30) NOT NULL,
        offset VARCHAR(30) NOT NULL
        )";

        $data = file_get_contents($filename);

        if($data === false) die('Unable to read file: ' . $filename);
        $filesCounter++;
        preg_match_all('/(\w+)/', $data, $matches, PREG_SET_ORDER);
        
        $wordsCounter = 0;

        foreach($matches as $match)
        {
            $word = strtolower($match[0]);

            $wordsCounter++;

            $addToSql = "INSERT INTO MyGuests (fileNo, word, offset)
            VALUES ($filesCounter, $word, $wordsCounter)";

            if(!array_key_exists($word, $invertedIndex)) $invertedIndex[$word] = [];
            if(!in_array($filename, $invertedIndex[$word], true)) $invertedIndex[$word][] = $filename;
        }
    }

    return $invertedIndex;
}
 




function lookupWord($invertedIndex, $word)
{
    return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
}
 
$invertedIndex = buildInvertedIndex(['file1.txt', 'file2.txt', 'file3.txt']);
 
// Search Reserved Words
foreach(['guitar', 'love', 'beatles', 'hate'] as $word)
{
    $matches = lookupWord($invertedIndex, $word);
 
    if($matches !== false)
    {   
        echo "<img src='images/v.png' style='width: 30px;'>";
        echo "Found the word <span style='color: #00135D; font-weight: bold;'>\"$word\"</span> in the following files: <span style='color: #004621; font-weight: bold;'>" . implode(' , ', $matches) . "</span>\n";
        echo "<br><br>";
    }
    else
    {
        echo "<img src='images/x.png' style='width: 25px; margin-right: 10px;'>";
        echo "Unable to find the word <span style='color: #00135D; font-weight: bold;'> \"$word\"</span> in the index\n";
        echo "<br><br>";
    }
}

?>