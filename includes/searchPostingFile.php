<?php
    function getSearchPostingFile(){
        // Get Search Input & find
        if(isset($_GET['searchInput'])){
            $word = $_GET['searchInput'];
            //echo $word;
            $chars = str_split($word);

            if($chars[0]=='"'){
                $isStopList = 1;
                for($i=1; $i<count($chars)-1; $i++)
                    $array[$i-1]=$chars[$i];
                $word = implode($array);
            }
            else
                $isStopList = 0;
        }
        else {
            echo "<h2 style='color:white;'>Can't fetch word</h2>";
            return;
        }
        $bla = "bla";
        $rows = explode(" ", $word);


        $numOfWords = count($rows);
        //$isStopList = 0;
        $replace = " REPLACE(word, ' ', '') ";
        $queryToEx = "select
			word as Word,
            fileNo as FileNum ,
            sum(hits) as HitsFromFile
            from Hits
            where ".$replace." = '".$word."'
            AND isStopList=".$isStopList."
            group by FileNum
            order by FileNum";

        // connect
        include('connection.php');

        $getWordId = "select id from Hits where REPLACE(word, ' ', '') = '".$word."' LIMIT 1 ";
        $result = mysqli_query($connection, $getWordId);
        while($ID = mysqli_fetch_array($result)){
            $wordId = $ID["id"];
        }

        if($numOfWords == 1){
            // if the word is different from OR, AND, NOT
            if( strcmp($rows[0],"OR")!=0
                 && strcmp($rows[0],"AND")!=0
                 && strcmp($rows[0],"NOT")!=0){
                    //$queryToEx .= " WHERE ".$replace.' ="'.$word.'" ;
                    // debbuging
                    //echo "<Br><H2 style='color:white; font-size: 20px;'>".$queryToEx."</h2>";
            }
        } else if($numOfWords == 2){
            // if $rows[0] == "NOT"
            if (strcmp($rows[0],"NOT")==0){
                //  "NOT" statement was found
                //$queryToEx .= " WHERE NOT ".$replace.' ="'.$rows[1].'"  '.$andStopList.' ';
                // ****************************************************
                // gal: need to fix this :
                //notStatement($rows[1] , 0);
                //return;
            } else{
                //echo "<Br><H2 style='color:white; font-size: 20px;'>Please provide another values</h2>";
            }
        } else if($numOfWords == 3){
            if( strcmp($rows[1],"AND")==0 || strcmp($rows[1],"&&")==0 ){
                // ****************************************************
                // gal: need to fix this :
                // andStatement($rows[0] , $isStopListA , $rows[2] , $isStopListB);
                // return;
            } else if( strcmp($rows[1],"OR")==0 || strcmp($rows[1],"||")==0 || strcmp($rows[1],"|")==0 ){
                // ****************************************************
                // gal: need to fix this :
                 //orStatement($rows[0] , $isStopListA , $rows[2] , $isStopListB);
                // return;
            } else {
                //echo "<Br><H2 style='color:white; font-size: 20px;'>Please provide another values</h2>";
            }
        }


        $tdOpen = '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span style="font-family: "Levenim MT" , arial;">';

        $tdOpenID = '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span id="ffn" style="font-family: "Levenim MT" , arial;">';


        $tdClose = '</span></td>';

        // connect
        include('connection.php');


        // send query to sql hits table
        $result = mysqli_query($connection, $queryToEx)
            or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$queryToEx."</h2>" );

        // count the rows in the results
        $num_rows = mysqli_num_rows($result);


        // headline
        if($num_rows==0) {
            echo "<h2 style='font-family: Levenim MT , arial;
            color : #ffa8a8 ; font-size: 25px; margin-left: 400px; font-weight: 300; margin-top: 30px; margin-bottom: 20px;'>No Results</h2>";
            return;
        } else{
            echo "<h2 style='font-family: Levenim MT , arial;
            color : aliceblue; font-size: 25px; margin-left: 360px; font-weight: 300;'>".$num_rows." Documents Found</h2>";
        }


        // table definition
        echo '<table style="margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';

        // first table row print
        echo '<tr ><a href="#">';
        {
            echo $tdOpen.' Word '.$tdClose;
            echo $tdOpen.' From File No. '.$tdClose;
            echo $tdOpen.' Hits '.$tdClose;
        }
        echo'</a></tr>';

        $w = "";
        $i = "";
        // table
        while($row = mysqli_fetch_array($result)){
            $w = $row["Word"];
            $i = $row["FileNum"];
            echo '<tr style="cursor:pointer;" onclick="javascript:toFile('.$i.','.$wordId.');"><a href="#">';

            echo '<script type="text/javascript">
                function toFile(value, id){
                    path =  "../data/file"+value+".txt";
                    window.open("getLyrics.php?file="+value+"&word="+id+"", "", "width=700,height=800");
                }
             </script>';
            {
                echo $tdOpen.$row["Word"].$tdClose;
                echo $tdOpenID.$row["FileNum"].$tdClose;
                echo $tdOpen.$row["HitsFromFile"].$tdClose;
            }
            echo'</a></tr>';
        }
        echo '</table>';

        //free memory
        mysqli_free_result($result);

        // close sql connection
        mysqli_close($connection);

        searchWord2($w);
    }

    function searchWord2( $word )
    {
        // craate sql connection
        include('connection.php');

        $counter = 0;

        // make query to sql hits table
        $mainTable = "SELECT id,fileNo,word,offset
        FROM Hits
        WHERE word='".$word."'";

        // send query to sql hits table
        $result = mysqli_query($connection,$mainTable) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$mainTable."</h2>");

        $num_rows = mysqli_num_rows($result);

        echo "<h2 style='font-family: Levenim MT , arial;
    color : aliceblue; font-size: 25px; margin-left: 400px; font-weight: 100; color: #fff; margin-top: 30px;'>".$num_rows." Results</h2>";

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
    getSearchPostingFile();

//    function notStatement($word , $andStopList)
//    {
//        $dropM1 = "drop view if exists  m1";
//        $dropM2 = "drop view if exists  m2";
//
//        $m2 = "create view m2 as (
//                Select fileNo
//                From Hits
//                group by fileNo)";
//
//        $m1 = "create view  m1 as(
//                Select fileNo
//                From myDB.Hits
//                where REPLACE(word,' ','') = ('".$word"') ANd isStopList=".$andStopList." )";
//
//        $tdOpen = '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span style="font-family: "Levenim MT" , arial;">';
//
//        $tdClose = '</span></td>';
//
//        // craate sql connection
//        include('connection.php');
//
//        // send query to sql hits table
//        $result = mysqli_query($connection,$dropM1) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$dropM1."</h2>");
//
//        $result = mysqli_query($connection,$dropM2) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$dropM2."</h2>");
//
//        $result = mysqli_query($connection,$m2) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$m2."</h2>");
//
//        $result = mysqli_query($connection,$m1) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$m1."</h2>");
//
//        $queryToEx = "SELECT * FROM m2 WHERE fileNo NOT IN (SELECT * FROM m1) ";
//
//        $result = mysqli_query($connection,$queryToEx) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$queryToEx."</h2>");
//
//
//
//        // count the rows in the results
//        $num_rows = mysqli_num_rows($result);
//
//        // close sql connection
//        mysqli_close($connection);
//
//        // headline
//        if($num_rows==0) {
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : #ffa8a8 ; font-size: 25px; margin-left: 400px; font-weight: 300; margin-top: 30px; margin-bottom: 20px;'>No Results</h2>";
//            return;
//        } else{
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : aliceblue; font-size: 25px; margin-left: 360px; font-weight: 300;'>".$num_rows." Documents Found</h2>";
//        }
//
//        // table definition
//        echo '<table style="margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';
//
//        // first table row print
//        echo '<tr ><a href="#">';
//        {
//            echo $tdOpen.' Word '.$tdClose;
//            echo $tdOpen.' From File No. '.$tdClose;
//            //echo $tdOpen.' Hits '.$tdClose;
//        }
//        echo'</a></tr>';
//
//        // print table
//        while($row = mysqli_fetch_array($result)){
//            $i = $row["fileNo"];
//            echo '<tr><a href="#">';
//            {
//                echo $tdOpen."NOT ".$word.$tdClose;
//                echo $tdOpen.$i.$tdClose;
//                //echo $tdOpen.$row["HitsFromFile"].$tdClose;
//            }
//            echo'</a></tr>';
//        }
//        echo '</table>';
//
//        //free memory
//        mysqli_free_result($result);
//
//        return;
//    }

//    function orStatement($wordA , $slA, $wordB, $slB)
//    {
//        $queryToEx = "Select fileNo
//                    From Hits
//                    where
//                    REPLACE(word,' ','') = ('".$wordA."') ANd isStopList=".$slA."
//                    OR
//                    REPLACE(word,' ','') = ('".$wordB."') ANd isStopList=".$slB."
//                    group by fileNo";
//
//        $tdOpen = '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span style="font-family: "Levenim MT" , arial;">';
//
//        $tdClose = '</span></td>';
//
//        // craate sql connection
//        include('connection.php');
//
//        $result = mysqli_query($connection,$queryToEx) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$queryToEx."</h2>");
//
//
//        // count the rows in the results
//        $num_rows = mysqli_num_rows($result);
//
//        // close sql connection
//        mysqli_close($connection);
//
//        // headline
//        if($num_rows==0) {
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : #ffa8a8 ; font-size: 25px; margin-left: 400px; font-weight: 300; margin-top: 30px; margin-bottom: 20px;'>No Results</h2>";
//            return;
//        } else{
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : aliceblue; font-size: 25px; margin-left: 360px; font-weight: 300;'>".$num_rows." Documents Found</h2>";
//        }
//
//        // table definition
//        echo '<table style="margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';
//
//        // first table row print
//        echo '<tr ><a href="#">';
//        {
//            echo $tdOpen.' Word '.$tdClose;
//            echo $tdOpen.' From File No. '.$tdClose;
//            //echo $tdOpen.' Hits '.$tdClose;
//        }
//        echo'</a></tr>';
//
//        // print table
//        while($row = mysqli_fetch_array($result)){
//            $i = $row["fileNo"];
//            echo '<tr><a href="#">';
//            {
//                echo $tdOpen.$wordA." OR ".$wordB.$tdClose;
//                echo $tdOpen.$i.$tdClose;
//                //echo $tdOpen.$row["HitsFromFile"].$tdClose;
//            }
//            echo'</a></tr>';
//        }
//        echo '</table>';
//
//        //free memory
//        mysqli_free_result($result);
//
//        return;
//    }
//
//    function andStatment($wordA , $slA, $wordB, $slB)
//    {
//        $dropM1 = "drop view if exists  m1";
//        $dropM2 = "drop view if exists  m2";
//
//        $m2 = "create view  m2 as(
//            Select fileNo
//            From myDB.Hits
//            where REPLACE(word,' ','') = ('".$wordB."') ANd isStopList=".$slB." group by fileNo)";
//
//        $m1 = "create view  m1 as(
//            Select fileNo
//            From myDB.Hits
//            where REPLACE(word,' ','') = ('".$wordA."') ANd isStopList=".$slA." group by fileNo)";
//
//        $tdOpen = '<td style="padding-left:20px; border:none ! important; font-size: 20px; color: #fff; font-color: #fff; height: 40px; width: 130px; background: url(../images/frow.png); "><span style="font-family: "Levenim MT" , arial;">';
//
//        $tdClose = '</span></td>';
//
//        // craate sql connection
//        include('connection.php');
//
//        // send query to sql hits table
//        $result = mysqli_query($connection,$dropM1) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$dropM1."</h2>");
//
//        $result = mysqli_query($connection,$dropM2) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$dropM2."</h2>");
//
//        $result = mysqli_query($connection,$m2) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$m2."</h2>");
//
//        $result = mysqli_query($connection,$m1) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$m1."</h2>");
//
//        $queryToEx = "SELECT * FROM m2 WHERE fileNo IN (SELECT * FROM m1) ";
//
//        $result = mysqli_query($connection,$queryToEx) or die("<h2 style='font-family: Levenim MT , arial; color : aliceblue;'>Error : ".mysqli_error($connection)."<br>".$queryToEx."</h2>");
//
//                // count the rows in the results
//        $num_rows = mysqli_num_rows($result);
//
//        // close sql connection
//        mysqli_close($connection);
//
//        // headline
//        if($num_rows==0) {
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : #ffa8a8 ; font-size: 25px; margin-left: 400px; font-weight: 300; margin-top: 30px; margin-bottom: 20px;'>No Results</h2>";
//            return;
//        } else{
//            echo "<h2 style='font-family: Levenim MT , arial;
//            color : aliceblue; font-size: 25px; margin-left: 360px; font-weight: 300;'>".$num_rows." Documents Found</h2>";
//        }
//
//        // table definition
//        echo '<table style="margin: 0px auto; border-collapse: collapse; cellspacing="0" cellpadding="0";">';
//
//        // first table row print
//        echo '<tr ><a href="#">';
//        {
//            echo $tdOpen.' Word '.$tdClose;
//            echo $tdOpen.' From File No. '.$tdClose;
//            //echo $tdOpen.' Hits '.$tdClose;
//        }
//        echo'</a></tr>';
//
//        // print table
//        while($row = mysqli_fetch_array($result)){
//            $i = $row["fileNo"];
//            echo '<tr><a href="#">';
//            {
//                echo $tdOpen.$wordA." AND ".$wordB.$tdClose;
//                echo $tdOpen.$i.$tdClose;
//                //echo $tdOpen.$row["HitsFromFile"].$tdClose;
//            }
//            echo'</a></tr>';
//        }
//        echo '</table>';
//
//        //free memory
//        mysqli_free_result($result);
//
//        return;
//    }
?>
