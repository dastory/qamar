<?php 
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

//delete sessions from text document'
$name = $_SESSION["valid_user"];

echo "$name";

$data = file("./sessions.txt");

$out = array();
foreach($data as $line) {
    // if(trim($line) != $name) {
    if(explode(";", $line)[0] != $name) {
        $out[] = $line;
    }
}

$fp = fopen("./sessions.txt", "w+");
flock($fp, LOCK_EX);
foreach($out as $line) {
    fwrite($fp, $line);
}
flock($fp, LOCK_UN);
fclose($fp);         


session_unset();
session_destroy();


// Logged out, return home.
header('Location: index.php');
exit();
ob_end_flush();	
?>