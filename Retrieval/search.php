<?php



function buildInvertedIndex($filenames){
    // craate sql connection
    //phpinfo();
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

    $sqlFiles ="CREATE TABLE Files(
        fileID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileName VARCHAR(30) NOT NULL,
        songName VARCHAR(30) NOT NULL,
        songAuthor VARCHAR(30) NOT NULL,
        songDate VARCHAR(10),
        songSummary VARCHAR(130),
        songLyrics VARCHAR(2000),
        songPic VARCHAR(100))";


    $sqlHits = "CREATE TABLE Hits (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileNo VARCHAR(30) NOT NULL,
        word VARCHAR(30) NOT NULL,
        offset INT(6) UNSIGNED NOT NULL,
        hits INT NOT NULL
    )";


    if (mysqli_query($conn, $sqlFiles)) {
        echo "Files Table successfully created";
    } else {
        $deleteSql = "DROP TABLE Files";
        if (mysqli_query($conn, $deleteSql)) {
            echo "Table Files was deleted successfully<br>";
            mysqli_query($conn, $sqlFiles);
            } else {
                echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
            }
    }

    if (mysqli_query($conn, $sqlHits)) {
        echo "Hits table successfully created";
    } else {
        $deleteSql = "DROP TABLE Hits";
        if (mysqli_query($conn, $deleteSql)) {
            echo "Table Hits was deleted successfully<br><br>";
            mysqli_query($conn, $sqlHits);
            } else {
                echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
            }
    }

    //mysqli_close($conn);

    $invertedIndex = [];
    $filesCounter = 0;
    $lyrics = false;
    $info = "";

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

            $addToSql="INSERT INTO Hits (fileNo, word, offset, hits)
                        VALUES ('$filesCounter', '$word', '$wordsCounter', 1)
                        ON DUPLICATE KEY UPDATE hits = hits + 1";

                if (mysqli_query($conn, $addToSql)) {
                    $wordsCounter++;
                    echo $wordsCounter.") '".$word."' New record created successfully<br>";
                } else {
                    echo "Error: " . $addToSql . "<br>" . mysqli_error($conn);
                }

            if(!array_key_exists($word, $invertedIndex)) $invertedIndex[$word] = [];
            if(!in_array($filename, $invertedIndex[$word], true)) $invertedIndex[$word][] = $filename;
        }

        list($songAuthor, $songName, $songDate, $songSummary, $songPic, $songLyrics) = explode(";", $data, 6);


        echo("File Name: ".$filename."<br>");
        echo("Author Name: ".$songAuthor."<br>");
        echo("Song Name: ".$songName."<br>");
        echo("Date: ".$songDate."<br>");
        echo("Summary: ".$songSummary."<br>");
        echo("Pic Path: ".$songPic."<br>");
        echo("Full Lyrics: ".$songLyrics."<br><br>");


        $s_fileName = "fileName";
        $s_songName = "songName";
        $s_songAuthor = "songAuthor";
        $s_songDate = "songDate";
        $s_songSummary = "songSummary";
        $s_songLyrics = "songLyrics";
        $s_songPic = "songPic";


         $addToFile="INSERT INTO Files (fileName, songName, songAuthor, songDate, songSummary, songPic)
              VALUES ('$filename','$songName', '$songAuthor', '$songDate', '$songSummary' , '$songPic')";

         if (mysqli_query($conn, $addToFile)) {
                echo "File successfully<br>";
         } else {
                echo "Error: " . $addToFile . "<br>" . mysqli_error($conn);
         }

        $lyrics = false;
    }
    return $invertedIndex;
}





function lookupWord($invertedIndex, $word)
{
    return array_key_exists($word, $invertedIndex) ? $invertedIndex[$word] : false;
}

$invertedIndex = buildInvertedIndex(['file1.txt']);

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
