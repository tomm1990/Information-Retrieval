<?php

    function checkIfValid($word){

    }


    function searchWord()
    {
        // craate sql connection
        include('connection.php');

        // Get Search Input & find
        if(isset($_GET['searchInput']))
            $word = $_GET['searchInput'];
        else return;

        $rows = explode(" ", $word);
        $numOfWords = count($rows);

        $queryToEx = "SELECT id, fileNo, word, offset
                        FROM Hits ";
        $replace = " REPLACE(word, ' ', '') ";
        $isStopList = 0;
        $andStopList = " AND isStopList = ".$isStopList;

        //for( $i = 0 ; $i < $numOfWords ; $i++){
        //   echo "<Br><H2 style=color:white;>rows -> ".$rows[$i]."</h2>";
        //}

        if($numOfWords == 1){
            // if the word is different from OR, AND, NOT
            if( strcmp($rows[0],"OR")!=0
                 && strcmp($rows[0],"AND")!=0
                 && strcmp($rows[0],"NOT")!=0){
                    $queryToEx .= " WHERE ".$replace.' ="'.$word.'"  '.$andStopList.' ';
                    // debbuging
                    echo "<Br><H2 style='color:white; font-size: 20px;'>".$queryToEx."</h2>";
            }
        } else if($numOfWords == 2){
            // if $rows[0] == "NOT"
            if (strcmp($rows[0],"NOT")==0){
                //  "NOT" statement was found
                $queryToEx .= " WHERE NOT ".$replace.' ="'.$rows[1].'"  '.$andStopList.' ';
                // debbuging
                echo "<Br><H2 style='color:white; font-size: 20px;'>".$queryToEx."</h2>";
            } else{
                echo "<Br><H2 style='color:white; font-size: 20px;'>Please provide another values</h2>";
            }
        } else if($numOfWords == 3){
            if( strcmp($rows[1],"AND")==0 || strcmp($rows[1],"&&")==0 ){

            } else if( strcmp($rows[1],"OR")==0 || strcmp($rows[1],"||")==0 || strcmp($rows[1],"|")==0 ){

            } else {

            }
        }
        //echo "<Br><H2 style=color:white;>".$queryToEx."</h2>";
        if( strcmp($rows[0],"NOT")==0 || strcmp($rows[0],"!")==0){
            // $rows[0] is NOT
            //$queryToEx .= " Where NOT ".$replace.'  = "'.$rows[1].'" '.$andStopList.'';
            //echo "<Br><H2 style=color:white;>NOT2 -> ".$queryToEx."</h2>";

        } else if( strcmp($rows[1],"AND")==0 || strcmp($rows[1],"&&")==0 ){
            //$queryToEx .= " Where ".$replace.' (word="'.$rows[0].'" AND ="'.$rows[2].'") '.$andStopList.'';
            //echo "<Br><H2 style=color:white;>AND -> ".$queryToEx."</h2>";

        } else if( strcmp($rows[1],"OR")==0 || strcmp($rows[1],"||")==0 || strcmp($rows[1],"|")==0){
            //$queryToEx .= " Where ".$replace.' (word="'.$rows[0].'" OR ="'.$rows[2].'") '.$andStopList.'';
            //echo "<Br><H2 style=color:white;>OR -> ".$queryToEx."</h2>";

        } else {

        }

        $counter = 0;

        // make query to sql hits table
        //$mainTable = "SELECT id,fileNo,word,offset
        //FROM Hits
        //WHERE word='".$word."'";

        // send query to sql hits table
        $result = mysqli_query($connection,$queryToEx) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$queryToEx."</h2>" );
        $num_rows = mysqli_num_rows($result);

        echo "<h2 style='font-family: Levenim MT , arial;
    color : aliceblue; font-size: 25px; margin-left: 400px; font-weight: 300; margin-top: 30px; margin-bottom: 20px;'>".$num_rows." Documents Found</h2>";

        // print first table row
        echo '<table style="margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

            echo '<tr><a href="#">';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 90px; background: url(../images/frow.png); "><span style="font-weight:bold;">#</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 170px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">File No</span></td>';
            echo '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; height: 40px; width: 150px; background: url(../images/frow.png); "><span style="font-weight:bold;">Word No</span></td>';
            echo '</a></tr>';

        // print all sql data rows
        while($row = mysqli_fetch_array($result)){
            echo '<tr><a href="#">';

            echo '<td style="padding-left:15px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 70px; background: url(../images/row.png); ">'.$row["id"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["word"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; font-color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["fileNo"].'</td>';
            echo '<td style="padding-left:20px; border: 1px solid; border:none ! important; font-size: 17px; color: #fff; height: 40px; width: 100px; background: url(../images/row.png); ">'.$row["offset"].'</td>';

            echo '</a></tr>';
        }
        echo '</table>';
        // close sql connection
        mysqli_free_result($result);
        mysqli_close($connection);
    }

    // start
    searchWord();

?>
