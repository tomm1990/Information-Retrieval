<?php

    function buildInvertedIndex($filenames){
        // error execution fix
        set_time_limit(0);

        // craate sql connection
        include('connection.php');

        // create sql files table
        $sqlFiles ="CREATE TABLE Files(
            fileID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fileName VARCHAR(80) ,
            songName VARCHAR(30) ,
            songAuthor VARCHAR(30) ,
            songDate VARCHAR(10),
            songSummary VARCHAR(130),
            songLyrics VARCHAR(2000),
            songPic VARCHAR(100),
            mp3Name VARCHAR(100)
            )";

        // create sql hits table
        $sqlHits = "CREATE TABLE Hits (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fileNo VARCHAR(30) NOT NULL,
            word VARCHAR(30) NOT NULL,
            offset INT(6) UNSIGNED NOT NULL,
            hits INT NOT NULL,
            isStopList BOOLEAN
        )";

        // check for old files table & remove
        if (mysqli_query($connection, $sqlFiles)) {
            echo "Files Table Successfully Created<br>";
        } else {
            $deleteSql = "DROP TABLE Files";
            if (mysqli_query($connection, $deleteSql)) {
//                echo "Old Files Table Deleted Successfully<br><br>";
                mysqli_query($connection, $sqlFiles);
                } else {
                    echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
                }
        }

        // check for old hits table & remove
        if (mysqli_query($connection, $sqlHits)) {
            echo "Hits table successfully created<br>";
        } else {
            $deleteSql = "DROP TABLE Hits";
            if (mysqli_query($connection, $deleteSql)) {
//                echo "Old Hits Table Deleted Successfully<br><br>";
                mysqli_query($connection, $sqlHits);
                } else {
                    echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
                }
        }

        //mysqli_close($connection);

        $invertedIndex = [];
        $filesCounter = 0;
        $lyrics = false;
        $info = "";

        foreach($filenames as $filename)
        {

            $data = file_get_contents($filename);
            if($data === false) die('Unable to read file: ' . $filename);
            $filesCounter++;
            preg_match_all("/(\w+)'(\w+) | (\w+)/", $data, $matches, PREG_SET_ORDER);

            $wordsCounter = 0;
            foreach($matches as $match)
            {
                $word = strtolower($match[0]);
                if($lyrics){
                    //$word = strtolower($match[0]);
                    if(($word == " you")||
                       ($word == " a")||
                       ($word == " i")||
                       ($word == " is")||
                       ($word == " and")||
                       ($word == " the")||
                       ($word == " to")||
                       ($word == " me")||
                       ($word == " in")||
                       ($word == " be")||
                       ($word == " of")||
                       ($word == " so")||
                       ($word == " he")||
                       ($word == " or")||
                       ($word == " by")||
                       ($word == " as")||
                       ($word == " it"))
                        $isStopList = 1;

                    else $isStopList = 0;

                    $addToSql = "INSERT INTO Hits (fileNo, word, offset,                               hits,isStopList)
                        VALUES ('$filesCounter', '$word', '$wordsCounter', 1, '$isStopList')
                        ON DUPLICATE KEY UPDATE hits = hits + 1";

                    mysqli_query($connection, $addToSql);
                    $wordsCounter++;
                }
                //if($word == "lyrics") $lyrics = true;
                if( strcmp($word,'lyrics')!=0 ) $lyrics = true;
                if(!array_key_exists($word, $invertedIndex)) $invertedIndex[$word] = [];
                if(!in_array($filename, $invertedIndex[$word], true)) $invertedIndex[$word][] = $filename;
            }

            $new_arr = array_map('trim', explode(';', $data));

            $addToFile="INSERT INTO Files (fileName,songName,songAuthor,songDate,songSummary,songPic,mp3Name)
                  VALUES ('$filename','$new_arr[1]','$new_arr[0]','$new_arr[2]','$new_arr[3]','$new_arr[4]','$new_arr[5]')";

            if (mysqli_query($connection, $addToFile)) {
                    //echo "<b>File successfully</b><br>";
            } else {
                    echo "<br><b>Error: " . $addToFile . "</b><br>" . mysqli_error($connection)."<br>";
            }

            $lyrics = false;
        }

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);

        return $invertedIndex;
    }


    // create array of files Names from loacl folder
    $filesNames=array();
    $filesCounter=0;
    foreach(glob('../data/*.*') as $filename){
        $filesCounter++;
        $filesNames[$filesCounter]=$filename;
    }

    // send all files to inverted parser
    $invertedIndex = buildInvertedIndex($filesNames);

?>
