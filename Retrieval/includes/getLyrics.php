<?php

    function getLyrics()
    {
        $markFlag =0;

        // Init
        if(isset($_GET['file']))
            $fileName = $_GET['file'];

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
            echo("Mark the Word: ".$wordId."");
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
                echo '<img src="../'.$info[$row]['data'].'" style="width:150px; float: left; margin-top: -160px;">';
            if($counter==6)
                echo '<div style="clear:both;"><br>';
            if($counter>7){
                if($markFlag){
                    // here we should mark (.$wordId.)
                }
                echo '<p style="font-size: 15px; color: #ffffff; font-weight: normal;">' . $info[$row]['data'] . '<br />';
            }

        }

        echo '</div>';
    }


    // start
    getLyrics();

?>
