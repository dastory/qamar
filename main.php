<?php
/**
 * This is the initial file where some spplication
 * wide variables/constants/scripts are loaded.
 * It's most important file for all pages.
 */
require "./init.php";

/* Object buffer added to avoid strict header redirection rules */
ob_start(); 

session_start();

if(isset($_SESSION["valid_user"]))  
{  
    if((time() - $_SESSION['valid_time']) > 1620) // 900 = 15 * 60  
    {  
        header("location:./logout.php");  
    }  
    else  
    {  
        $_SESSION['valid_time'] = time();  

    }  
}  
else  
{  
    header('location:./index.php'); 
    exit();
}  

/* --------------------------------------------- */
$name = $_SESSION["valid_user"];
$loginTime = $_SESSION["valid_time"];
global $name;

// save sessions -> text document
$file = file_get_contents("./sessions.txt");

if(!strstr($file, "$name"))
{
    $myFile = "./sessions.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    $file = "$name;$loginTime\n";
    fwrite($fh, $file);
    fclose($fh);
}

function activeuser() {
	$file = fopen('./sessions.txt', 'r');
    $file1 = "./sessions.txt";
    $no_of_lines = COUNT(FILE($file1)); 

    while($no_of_lines > 0){
        $no_of_lines--;
        $line = fgets($file);
        echo $line." ";
        }
}

// if buffer and diable chat session variable is not yet set, then set it

if(!isset($_SESSION['bfmsg']) || !$_SESSION['dischat'])
{
    $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        $finduser = false;
        while($no_of_lines > 0)
        {   
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);

        if(trim($array[0]) == "client" && trim($array[2]) == 1)
        {
            $_SESSION['bfmsg']=trim($array[4]);
            $_SESSION['dischat']=trim($array[5]);	
            }
        }
        fclose($file);
}

// Name of the message buffer file. You have to create it manually with read and write permissions for the webserver.
$messages_buffer_file = 'messages.json';
// Number of most recent messages kept in the buffer
$messages_buffer_size = isset($_SESSION['bfmsg']) ? $_SESSION['bfmsg'] : '';

if ( isset($_POST['content']) and isset($_POST['name']) )
{
	// Open, lock and read the message buffer file
	$buffer = fopen($messages_buffer_file, 'r+b');
	flock($buffer, LOCK_EX);
	$buffer_data = stream_get_contents($buffer);
	
	// Append new message to the buffer data or start with a message id of 0 if the buffer is empty
	$messages = $buffer_data ? json_decode($buffer_data, true) : array();
	$next_id = (count($messages) > 0) ? $messages[count($messages) - 1]['id'] + 1 : 0;
	$messages[] = array('id' => $next_id, 'time' => time(), 'name' => $_POST['name'], 'content' => $_POST['content']);
	
	// Remove old messages if necessary to keep the buffer size
	if (count($messages) > $messages_buffer_size)
		$messages = array_slice($messages, count($messages) - $messages_buffer_size);
	
	// Rewrite and unlock the message file
	ftruncate($buffer, 0);
	rewind($buffer);
	fwrite($buffer, json_encode($messages));
	flock($buffer, LOCK_UN);
	fclose($buffer);
	
	// Optional: Append message to log file (file appends are atomic)
	file_put_contents('chatlog.txt', strftime('%F %T') . "\t" . strtr($_POST['name'], "\t", ' ') . "\t" . strtr($_POST['content'], "\t", ' ') . "\n", FILE_APPEND);
	
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Chat Room</title>

<?php
/**
 * All css inside assets.css.php file
 */
require "./assets.css.php"; 
?>

</head>
	
<body>
<div class="container">	
<div class="panel panel-default">
<div class="panel-heading">
<span style="color:brown"><big><b>Group Chat Now</b></big></span>
<span align="right">
<div id="refresh">
<?php 
if($_SESSION['utype'] == 1)
	{
	echo 'Welcome <big><b>'.$_SESSION['valid_user'].'</b></big> | ';
	echo '<a href="./admin.php">Admin Panel</a> | ';
	echo '<a href="./cpass.php" style="text-decoration:none;">Change Password</a> | 
	<a href="./logout.php"  style="color:red; text-decoration:none;"><b>Logout</b></a><br>';
	echo '<big><b>Notice: </b>'.$_SESSION['notice'].'</big>';
	}
else
	{
	echo '<a href="./cpass.php" style="text-decoration:none;">Change Password</a> | 
	<a href="./logout.php"  style="color:red; text-decoration:none;"><b>Logout</b></a><br>';
	echo '<big><b>Notice: </b>'.$_SESSION['notice'].'</big>';
	}
?>


</div>
</span>	
</div>

<div class="panel-body"> 
<!-- jump to new msg -->
<a href="javascript:" id="jump-to-last"><i class="icon-chevron-up">&#9660;</i></a>
<?php 
if(isset($_SESSION['info'])) { 
	if($_SESSION['type'] ==1) { ?>
<div class="alert alert-success fade in" align="center"><b>
<?php echo $_SESSION['info']; unset($_SESSION['info']); unset($_SESSION['type']); ?>
</b></div>
<?php
 } else { ?>
<div class="alert alert-danger fade in" align="center"><b>
<?php echo $_SESSION['info']; unset($_SESSION['info']); unset($_SESSION['type']);?>
</b></div>	
	
<?php }
} 
	
if(isset($_SESSION['dischat']) && $_SESSION['dischat']=="no"){
	?>
<ul id="messages">
        	<li>loadingÃ¢â‚¬Â¦</li>
</ul>
<?php } 
	
else echo "Chat Disabled for now by Admin..";	
	
?>
	
</div>	
<div class="panel-footer">
<?php 
if(isset($_SESSION['dischat']) && $_SESSION['dischat']=="no")
{
?>        
<form id="my_form" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_COMPAT, 'UTF-8'); ?>" method="post" name="my_form">
<textarea name="content" id="content" autofocus ></textarea>
</form>
<b style="color:brown">Users Active Now: </b><span id="activeUserList"><?php //echo activeuser();?></span>
		
<?php 
} 
	
if (isset($_SESSION['sbuf']) && $_SESSION['sbuf']==1)	
{
	header("Refresh:0");
}	
$_SESSION['sbuf']=0;	
?>	
	
</div>    
</div>	
</div>

<!-- All Javascript Below before end of Body tag :: speed up pageload -->
<?php
/**
 * All javascript inside assets.js.php file
 */
require "./assets.js.php"; 
?>

</body>
</html>
<?php ob_end_flush(); ?>
