<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
} 

$name = $_POST['name'];
$password = $_POST['password'];

$file = fopen('./data.txt', 'r');
$good=0;

while(!feof($file))
{
	$line = fgets($file);
	$array = explode(";",$line);
	$aa=trim($array[0]);
	$bb=trim($array[1]);
	$_SESSION['utype']=trim($array[2]);
	$cc=md5($_POST['password']);		 
	if($aa == $name && $bb == $cc)
	{
		$good=1;
		break;
	}
}

fclose($file);

if($good)
{
	$_SESSION['valid_user'] = $name;
	$_SESSION["valid_time"] = time();
	$_SESSION['info']="আসসালামু আলাইকুম প্রিয় ভাই..";
	$_SESSION['type']=1;  //type 2 = warning. type = 1 success
	header("location: chk2.php"); 
	exit();
}
else
{
	$_SESSION['info']="আপনি ভুল তথ্য দিয়েছেন। আবার চেষ্টা করুন...";
	$_SESSION['type']=2;  //type 2 = warning. type = 1 success
	header("location: index.php"); 
	exit();
}


?>
