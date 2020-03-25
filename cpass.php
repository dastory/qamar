<?php
/**
 * This is the initial file where some spplication
 * wide variables/constants/scripts are loaded.
 * It's most important file for all pages.
 */
require "./init.php";

 if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

if (isset($_POST['cngpass']) && isset($_SESSION["valid_user"])){
   $user = $_SESSION["valid_user"];
   $oldPass = md5($_POST['oldPass']);
   $newPass = md5($_POST['newPass']); 

        $file = fopen('data.txt', 'r');
        $file1 = "data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        while($no_of_lines > 0)
        {
            $count++;
            $no_of_lines--;
            $lines = fgets($file);
            $array = explode(";",$lines);
            if($newPass == $oldPass || trim($array[1]) != $oldPass)
				{$_SESSION['info']="Wrong Info. Please Try Again..";
				$_SESSION['type']=2;  //type 2 = warning. type = 1 success
				}
            else
            {
                if(trim($array[0]) == $user && trim($array[1]) == $oldPass)
                { 
                       addline($count, $newPass);
                       deleteline($count);
                       $_SESSION['info']="Password Changed Successfully";
                       $_SESSION['type']=1;  //type 2 = warning. type = 1 success
					   header('Location: main.php');
					   exit();
                }
               
            }
        }
        fclose($file);
    }


function addline($line, $newPass) {
    $file = fopen('./data.txt', 'r');
    $no_of_lines = $line;
    $count = 0;
    while($no_of_lines > 0){
        $count++;
        $line = fgets($file);
        if($no_of_lines == $count) {
            $array = explode(";",$line);
            $file1 = fopen("data.txt", "a");
            fputs($file1,trim($array[0]).";".$newPass.";".trim($array[2]).";".trim($array[3]).
                    ";".trim($array[4]).";".trim($array[5])."\r\n");
            fclose($file);
            fclose($file1);
            break;
        }
    }
}

function deleteline($dline) {

    $file = fopen('data.txt', 'r');
    $no_of_lines = $dline;
    $count = 0;

    while($no_of_lines > 0){
        $count++;
        $line1 = fgets($file);
        if($no_of_lines == $count) {
            $data = file("data.txt");    
            $out = array();
            foreach($data as $line) {
                if(trim($line) != trim($line1)) {
                    $out[] = $line;
                }
            $fp = fopen("data.txt", "w+");

            flock($fp, LOCK_EX);
            foreach($out as $line) {
            fwrite($fp, $line);
            }
            flock($fp, LOCK_UN);
            fclose($fp);
            }
            break;
        }
    }
    return true;
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Group Chat</title>
    
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
<div class="panel-heading"><h3 style="color:brown; text-decoration:none;">Change Password</h3>
      <a href="./main.php" style="color:red; text-decoration:none;"><b><big>Join Chat</big></b></a>
      <a href="./logout.php" style="color:brown; text-decoration:none;"><b>Logout</b></a>
</div>
<div class="panel-body"> 

<?php 
session_start();    
if($_SESSION['info']) { 
	if($_SESSION['type'] ==1) { ?>
<div class="alert alert-success" align="center">
<?php echo $_SESSION['info']; unset($_SESSION['info']); unset($_SESSION['type']); ?>
</div>
<?php
 } else { ?>
<div class="alert alert-danger" align="center">
<?php echo $_SESSION['info']; unset($_SESSION['info']); unset($_SESSION['type']);?>
</div>	
	
<?php }
	} 
?>	
	

<div class="table-responsive">     
<table class="table table-hover table-bordered">
<form class="form-inline" action=""  method="post">
    
<div class="form-group">
<tr><td> 
<h4>Old password</h4>
</td><td> 
<input class="txt" id="oldPass" type="password" name="oldPass" value=""><br>
<span id="spnNameStatus" style="color:red">Required</span>   
</td></tr>
</div>    

<div class="form-group">    
<tr> <td> 
<h4>New password</h4> 
</td><td> 
<input class="txt" id='newPass' type="password" name="newPass" maxlength="12" value=""><br> 
<span id="spnPassStatus" style="color:red">Required</span>       
</td></tr>
</div>  
    
<div class="form-group">    
<div class="btn-group">   
<tr><td></td><td> <button id="mysub" type="submit" class="btn btn-primary" disabled="true" name="cngpass">Change Password</button></td></tr>
</div>     
</div>      

</form> 
</table>    
</div>  
<div class="panel-footer" align="right" style="color:brown"><small>Developed by IT Section </small></div>    
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