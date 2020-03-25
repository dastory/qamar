<?php
/**
 * This is the initial file where some spplication
 * wide variables/constants/scripts are loaded.
 * It's most important file for all pages.
 */
require "./init.php";

session_start();
if (!$_SESSION["valid_user"])
{
    // User not logged in, redirect to login page
    header('Location: index.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
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

  <script>
	window.setTimeout(function () {
        window.location.href= 'main.php'; // the redirect goes here
	},5000); // 5 seconds 
	</script>  

</head>
	
	
<body>
<div class="container">	
<div class="panel panel-default">
<div class="panel-heading">
<span style="color:brown"><big><b>Group Chat Now</b></big></span>
</div>
<div class="panel-body" align="center" > 

 <img src="dua.jpeg" height="400" alt="">	
	
	 
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
