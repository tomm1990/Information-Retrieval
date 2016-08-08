<?php

function buildInvertedIndex($filenames)
{

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

    // Create database
    //$sql = "CREATE DATABASE myDB";

     $sql = "CREATE TABLE MyGuests (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileNo VARCHAR(30) NOT NULL,
        word VARCHAR(30) NOT NULL,
        offset VARCHAR(30) NOT NULL
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }

    //mysqli_close($conn);

    $invertedIndex = [];
    $filesCounter = 0;

    foreach($filenames as $filename)
    {
        $data = file_get_contents($filename);

        if($data === false) die('Unable to read file: ' . $filename);
        $filesCounter++;
        preg_match_all('/(\w+)/', $data, $matches, PREG_SET_ORDER);
        
        $wordsCounter = 0;

        foreach($matches as $match)
        {
            $word = strtolower($match[0]);

            $wordsCounter++;

            echo ($wordsCounter);

            $addToSql = "INSERT INTO MyGuests (fileNo, word, offset)
            VALUES ('$filesCounter', '$word', '$wordsCounter')";
            if (mysqli_query($conn, $addToSql)) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $addToSql . "<br>" . mysqli_error($conn);
            }

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
    
    // Get Search Input & find
    $word = $_GET['searchInput'];
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
//}

?>
