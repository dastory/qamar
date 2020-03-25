<?php
/**
 * This script will read any files other than php from server
 * and send json formatted data to client
 */

//  TODO: Read sessions.txt file and convert content into json then response json data.
function activeuser() {
	$file = fopen('./sessions.txt', 'r');
    $file1 = "./sessions.txt";
    $no_of_lines = COUNT(FILE($file1)); 

    $lines = array();
    while($no_of_lines > 0){
        $no_of_lines--;
        $line = explode(";", rtrim(fgets($file), "\n"));
        array_push($lines, array( 
            'name' => $line[0],
            'time' => (end($line) === $line[0]) ? "" : end($line),
        ));
    }
    return json_encode($lines);
}
if( $_REQUEST['get'] == "activeUsers" ){
    echo activeuser();
}

exit;