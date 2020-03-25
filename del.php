<?php
 if (session_status() == PHP_SESSION_NONE) {
                session_start();
                } 
  // Check user is admin or not.
     if($_SESSION['utype']!=1)
        {
            header("location: main.php");
			exit();
        } 

//empty test document
function emptyfile()
{
    $myFile = "./chatlog.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "";
	fwrite($fh, $stringData);
	fclose($fh);

	$myFile2 = "./messages.json";
	$fh2 = fopen($myFile2, 'w') or die("can't open file");
	$stringData2 = "";
	fwrite($fh2, $stringData2);
	fclose($fh2);
	
	$myFile3 = "./sessions.txt";
	$fh2 = fopen($myFile3, 'w') or die("can't open file");
	$stringData2 = "";
	fwrite($fh2, $stringData2);
	fclose($fh2);
}

emptyfile();
header("location: admin.php"); 
exit();
?>

