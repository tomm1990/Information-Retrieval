<?php

    function getLyrics()
    {
        echo "<script src='https://cdn.jsdelivr.net/mark.js/8.1.1/mark.min.js'></script>";
        echo "<script src='https://code.jquery.com/jquery-latest.min.js'></script>";

        echo "<script src='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>";


        $markFlag =0;

        // Init
        if(isset($_GET['file']))
            $fileId = $_GET['file'];

        // craate sql connection
        include('connection.php');

        // make query to sql files table
        $query = "select * from Files";

        // send query to sql files table
        $result = mysqli_query($connection , $query);
        if( !$result ){
            echo "DB query failed from file_bars.php";
            die("DB query failed from file_bars.php");
        }

        // print all sql data rows
        while( $row = mysqli_fetch_assoc($result) ){
            if($fileId == $row["fileID"])
                $fileName = $row["fileName"];
        }

        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);

        // Case need to mark word
        if(isset($_GET['word'])){
            $tosearch = $_GET['word'];

            $markFlag =1;
            // connect
            include('connection.php');

            // Get Word by Id
            $getWord = "select word from Hits where id = '".$tosearch."'";
            $result = mysqli_query($connection, $getWord);
            while($ID = mysqli_fetch_array($result)){
                $wordId = $ID["word"];
            }

            // Mark the word
            echo "<span>Search:</span>
                        <input type='text' name='keyword' class='form-control input-sm' value='".$wordId."'>";
        }

        $txt_file = file_get_contents(''.$fileName.'');
        $rows = explode("\n", $txt_file);

        $counter = 0;

        echo '<div style="background: url(../images/backgroundBlack.jpg);
            padding: 70px;
            background-size : 100% 100% ;
	        background-attachment:fixed ;
            font-family: Levenim MT , arial;
            color : aliceblue ; ">';
        $runOnce = 1;

        foreach($rows as $row => $data)
        {
            $counter++;
            //get row data
            $row_data = explode(';', $data);

            $info[$row]['data'] = $row_data[0];

            //display data
            if($counter==1)
                echo '<h4 style="font-weight: normal; font-size: 20px; color: #ffffff; margin-top:60px; margin-left: 170px;">Artist: &nbsp&nbsp' . $info[$row]['data'] . '<h4/>';
            if($counter==2)
                echo '<h4 style="font-weight: normal; font-size: 20px; margin-left: 170px; margin-top: -15px; color: #ffffff;">Song: &nbsp&nbsp' . $info[$row]['data'] . '<h4/>';
            if($counter==3)
                echo '<h4 style="font-weight: normal; font-size: 20px; margin-top: -15px; margin-left: 170px; color: #ffffff;">Date: &nbsp&nbsp' . $info[$row]['data'] . '<h4/>';
            if($counter==5)
                echo '<img src="../'.$info[$row]['data'].'" style="width:150px; float: left; margin-top: -160px;"><div style="clear:both;"><br>';

            if($counter==6){
                echo '<audio controls style="display: block;">
                    <source src="../audio/'.$info[$row]['data'].'" type="audio/mpeg">
                    Your browser does not support the audio element.
                    </audio><br>';
            }

            if($counter>8){
                if($markFlag){
                    // here we should mark (.$wordId.)
                }
                if($runOnce){
                    $runOnce = 0;
                    echo '<div class="panel-body context">';
                }

                echo '<p style="font-size: 15px; color: #ffffff; font-weight: normal;">' .      $info[$row]['data'] . '<br />';
            }

        }

        echo '</div>';

        echo "<script src='../js/remark.js'></script>";
    }


    // start
    getLyrics();

?>
