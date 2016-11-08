<?php
    $filesCounter = 1;
    $interval = 0;

    // full folder address
    $checkTest = getcwd()."/data/";
    $files1 = scandir($checkTest);

    // display
    print_r('sizeof($files1) : '.sizeof($files1).'<br>');
    print_r('$interval : '.$interval.'<br>');

    // search for free slot
    for( $interval ; $interval < sizeof($files1) ; $interval++){
        if(!filter_var($files1[$interval], FILTER_SANITIZE_NUMBER_INT)) continue;
        print_r('$files1['.$interval.'] : '.$files1[$interval].'<br>');
        if( filter_var($files1[$interval], FILTER_SANITIZE_NUMBER_INT) != $filesCounter){
            break;
        }
        else $filesCounter++;
    }
    print_r('available free slot : text'.$filesCounter.'.txt');

    // get the file name to include
    $filename = $_GET['filename'];

    // get file from path
    $path = getcwd()."/source/".$filename."";

    // creating new file
    $newfile = getcwd()."/data/".$filename."";

    if( !file_exists( $newfile ) ){
        copy($path, $newfile);
        return;
    }
?>
