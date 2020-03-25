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
<div class="panel-heading"><h3 style="color:brown">Login Please</h3></div>
<div class="panel-body"> 

<?php 

if(isset($_SESSION['info'])) { 
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
<form class="form-inline" action="chk1.php"  method="post">
	
<div class="form-group">
<tr><td> 
<h4>Name</h4>
</td><td> 
<input class="txt" id="txtName" type="text" name="name" value="" autofocus><br>
<span id="spnNameStatus" style="color:red">Required</span>   
</td></tr>
</div>    

<div class="form-group">    
<tr> <td> 
<h4>Password</h4> 
</td><td> 
<input class="txt" id='txtPass' type="password" name="password" maxlength="12" value=""><br> 
<span id="spnPassStatus" style="color:red">Required</span>       
</td></tr>
</div>  
	
<div class="form-group">    
<div class="btn-group">   
<tr><td></td><td> <button id="mysub" type="submit" class="btn btn-primary" disabled="true">Login</button></td></tr>
</div>     
</div>      

<div class="form-group col-xs-3">
<tr><td></td><td> <h4><a href="reg.php">Register</a></h4></td></tr>
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