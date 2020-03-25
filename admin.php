<?php 
/**
 * This is the initial file where some spplication
 * wide variables/constants/scripts are loaded.
 * It's most important file for all pages.
 */
require "./init.php";

ob_start();

if (session_status() == PHP_SESSION_NONE) {
  session_start();
} 
$user = $_SESSION['valid_user'];
// Check user is admin or not.
if($_SESSION['utype']!=1)
{
  header("location: main.php");
  exit();
} 

function bufmsg()
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
          $bfmsg = trim($array[4]);
    $_SESSION['bfmsg']=$bfmsg;
          return $bfmsg;
          echo "VALUE:".$bfmsg;
        }
      }
      fclose($file);
}

function checkname($name) {
    $file = fopen('./data.txt', 'r');
    $file1 = "./data.txt";
    $no_of_lines = COUNT(FILE($file1));
    $finduser = false;

    while($no_of_lines > 0)
    {
        $no_of_lines--;
        $line = fgets($file);
        $array = explode(";",$line);
        if(trim($array[0]) == $name)
        {
            $finduser=true;
            break;
        }
    }
    fclose($file);

    if(!$finduser)
    {
        return true;
    } else {return false;}
}   

function makeadmin($line, $bool) {
  $file = fopen('./data.txt', 'r');
  $no_of_lines = $line;
  $count = 0;

  while($no_of_lines > 0){
    $count++;
    $line = fgets($file);
    if($no_of_lines == $count) {
        $array = explode(";",$line);
        $file1 = fopen("./data.txt", "a");
        if($bool == true){
        fputs($file1,trim($array[0]).";".trim($array[1]).";"."1".";".trim($array[3])."\r\n");
        fclose($file);
        }
        else{
        fputs($file1,trim($array[0]).";".trim($array[1]).";"."0".";".trim($array[3])."\r\n");
        fclose($file);
        }
        break;
    }
  }
  return true;
}

 function approveline($line) {
  $file = fopen('./pending.txt', 'r');
  $no_of_lines = $line;
  $count = 0;
  $name = $_SESSION['valid_user'];
  $finduser = false;
  while($no_of_lines > 0){
    $count++;
    $line = fgets($file);
    if($no_of_lines == $count) {
      $array = explode(";",$line);
      $checkname = trim($array[0]);

      if (checkname($checkname)) {
        $finduser = true;
        $file1 = fopen("./data.txt", "a");
        fputs($file1,trim($array[0]).";".trim($array[1]).";".trim($array[2]).";".$name."\r\n");
        fclose($file);
        break;
      }
      break;
    }
  }
  if ($finduser == true) {
    return true;
  }
  return false;
}

function deleteline($dline, $bool) {
    if($bool == true){
    $file = fopen('data.txt', 'r');
    }
    else{
      $file = fopen('pending.txt', 'r');
    }

    $no_of_lines = $dline;
    $count = 0;

      while($no_of_lines > 0){
      $count++;
      $line1 = fgets($file);
      if($no_of_lines == $count) {
          if($bool == true){
            $data = file("data.txt");  
          }
          else{
            $data = file("pending.txt");
          }
          
          $out = array();
          foreach($data as $line) {
              if(trim($line) != trim($line1)) {
                  $out[] = $line;
              }
          if($bool == true){
          $fp = fopen("data.txt", "w+");
          }
          else{
            $fp = fopen("pending.txt", "w+"); 
          }

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

//****************TO DISPLAY USERS*****************//
    function PendingUsers() {

    $file = fopen('./pending.txt', 'r');
    $file1 = "./pending.txt";
    $no_of_lines = COUNT(FILE($file1));
    $count = 0; 

    while($no_of_lines > 0){
        $count++;
        $no_of_lines--;
        $line = fgets($file);
        $array = explode(";",$line);
        $a = trim($array[0]);
echo <<< EOD
              <tr>
                <td>$count</td>
                <td>$a</td>
                <td id='tr_$count'><a href='#tr_$count' onclick='action_user("#tr_$count","$count","approve")'>Approve</a> | <a href='#tr_$count' onclick='action_user("#tr_$count","$count","del")'>Delete</a>
                </td>
              </tr>

EOD;
        }
    }


    function ApprovedUsers() {
    
    $file = fopen('./data.txt', 'r');
    $file1 = "./data.txt";
    $no_of_lines = COUNT(FILE($file1)); 
    $count = 0; 

    while($no_of_lines > 0){
        $count++;
        $no_of_lines--;
        $line = fgets($file);
        $array = explode(";",$line);

        // user name
        $username = trim($array[0]);

        //aproved by
        $apby = trim($array[3]);

        //check user or admin
        
		if($array[2]==1)
          {$type = "admin";}
        elseif($array[2]==0)
          {$type = "user";}

        //Check User upgraded or Downgraded
        if ($type == "user") {$isAd = "mkadm";}
        elseif ($type = "admin") {$isAd = "mkusr";}
        if ($isAd == "mkadm") {$mk = "Make Admin";}
        elseif ($isAd == "mkusr") {$mk = "Make User";}
        
        
echo <<< EOD
              <tr>
                <td>$count</td>
                <td>$username</td>
                <td id='trA_$count'><a href='#trA_$count' onclick='action_user("#trA_$count","$count","delApprove")'>Delete</a>
                </td>
                <td id='trAd_$count'>$type</td>
                <td id='trmkadm_$count'><a href='#trmkadm_$count' onclick='action_user("#trmkadm_$count","$count","$isAd")'>$mk</a></td>
                <td id='trapby_$count'>$apby</td>
              </tr>

EOD;
		}
    }  



if (isset($_GET['ac'])) {
//"admin.php?ac=user&id="+id+"&type"+type_
  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;

// To approve pending user
  if ($type == 'approve') {
    if (approveline($id)) {
      echo "User Approved";
      $bool = false;
      deleteline($id, $bool);
    }
    else{echo "User already existed!";}
  }

// To delete pending user
  elseif ($type == 'del') {
    $bool = false;
    if (deleteline($id, $bool)) {
      echo "User Deleted";
    }
  }


// To delete approved user
  elseif ($type == 'delApprove') {
     $file = fopen('./data.txt', 'r');
     $no_of_lines = $id;
     $count = 0;
     $find = false;

    while($no_of_lines > 0){
    $count++;
    $line = fgets($file);
    if($no_of_lines == $count) {
        $array = explode(";",$line);
        if(trim($array[0]) == "client")
        {
          $find = true;
          echo "Cannot Delete";
        }
        fclose($file);
        break;
    }
  }
    if(!$find)
    {
    $bool = true;
    if (deleteline($id,  $bool)) {
    echo "User Deleted";
    }
  }
}

// To make admin
  elseif ($type == 'mkadm') {

     $file = fopen('./data.txt', 'r');
     $no_of_lines = $id;
     $count = 0;
     $find = false;

    while($no_of_lines > 0){
    $count++;
    $line = fgets($file);
    if($no_of_lines == $count) {
        $array = explode(";",$line);
        if(trim($array[0]) == "client")
        {
          $find = true;
          echo "Cannot Change";
        }
        fclose($file);
        break;
    }
  }
    if(!$find)
    {
    $cool = true;
    if (makeadmin($id, $cool)) {
    echo "User Upgraded";
    $bool = true;
    deleteline($id, $bool);
     }
    }
  }

// To delete chat
     elseif ($type == 'delete') { header('Location: del.php'); }
    
// To make user
  elseif ($type == 'mkusr') {
     $file = fopen('./data.txt', 'r');
     $no_of_lines = $id;
     $count = 0;
     $find = false;

    while($no_of_lines > 0){
    $count++;
    $line = fgets($file);
    if($no_of_lines == $count) {
        $array = explode(";",$line);
        if(trim($array[0]) == "client")
        {
          $find = true;
          echo "Cannot Change";
        }
        fclose($file);
        break;
    }
  }
    if(!$find)
    {
    $cool = false;
    if (makeadmin($id, $cool)) {
    echo "User Downgraded";
    $bool = true;
    deleteline($id, $bool);
    }
  }
  }
 exit();
}

// to save notices

elseif (isset($_POST['notice'])) {
  $a = $_POST['notice'];
        
        $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        $finduser = false;
        while($no_of_lines > 0)
        {   $count++;
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);

        if(trim($array[5]) == $a)
        {
          $finduser = true;
        }
      }
      fclose($file);
      /*fclose($file1);*/

        if ($finduser) {
			$_SESSION['notice']=$a;
          	header('Location:  main.php');
			exit();
        }
        else
        {
        $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        $finduser = false;
        while($no_of_lines > 0)
        {   $count++;
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);
            if(trim($array[0]) == "client" && trim($array[2]) == "1")
            {   $line = $count;
                $finduser = true;
                $file0 = fopen("./data.txt", "a");
                fputs($file0,trim($array[0]).";".trim($array[1]).";".trim($array[2]).";".trim($array[3]).
					  ";".trim($array[4]).";".trim($array[5]).";".$a."\r\n");
                fclose($file0);
                break;
            }
        }
        fclose($file);
        fclose($file1);
        $bool = true;
        deleteline($line, $bool);
		$_SESSION['notice']=$a;	
        header('Location: main.php');
		exit();	
      }
}
// to disable chat

elseif (isset($_POST['dischat'])) {
  $a = $_POST['dischat'];
        
        $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        $finduser = false;
        while($no_of_lines > 0)
        {   $count++;
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);

        if(trim($array[5]) == $a)
        {
          $finduser = true;
        }
      }
      fclose($file);
      /*fclose($file1);*/

        if ($finduser) {
			$_SESSION['dischat']=$a;
          	header('Location: main.php');
			exit();
        }
        else
        {
        $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        $finduser = false;
        while($no_of_lines > 0)
        {   $count++;
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);
            if(trim($array[0]) == "client" && trim($array[2]) == "1")
            {   $line = $count;
                $finduser = true;
                $file0 = fopen("./data.txt", "a");
                fputs($file0,trim($array[0]).";".trim($array[1]).";".trim($array[2]).";".trim($array[3]).
					  ";".trim($array[4]).";".$a."\r\n");
                fclose($file0);
                break;
            }
        }
        fclose($file);
        fclose($file1);
        $bool = true;
        deleteline($line, $bool);
		$_SESSION['dischat']=$a;	
        header('Location: main.php');
		exit();	
      }
}

// to set buffer message value 
elseif (isset($_POST['chat'])) {
  		$_SESSION['bfmsg']=$_POST['chat'];
	
        $file = fopen('./data.txt', 'r');
        $file1 = "./data.txt";
        $no_of_lines = COUNT(FILE($file1));
        $count = 0;
        while($no_of_lines > 0)
        {   $count++;
            $no_of_lines--;
            $line = fgets($file);
            $array = explode(";",$line);
            if(trim($array[0]) == "client" && trim($array[2]) == "1")
            {   $line = $count;
                $file0 = fopen("./data.txt", "a");
                fputs($file0,trim($array[0]).";".trim($array[1]).";".trim($array[2]).";".trim($array[3]).";".$_POST['chat'].";".trim($array[5])."\r\n");
                fclose($file0);
                break;
            }
        }
        fclose($file);
        fclose($file1);
	
        $bool = true;
        deleteline($line, $bool);
		$_SESSION['sbuf']=1;
        header('Location: main.php');
		exit();	
     
}

      
//****************TO DISPLAY USERS****************//

?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel</title>
      
<?php
/**
 * All css inside assets.css.php file
 */
require "./assets.css.php"; 
?>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css"></script>	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.fa.js"></script>	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>	 -->
<script>
	// $("#grid-basic").bootgrid();
</script>	
</head>

<body>
<div class="container">	
<div class="panel panel-default">
<div class="panel-heading">	
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="./admin.php"><b><u>Admin Panel</u></b></a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="./main.php" style="color:red"><b><big>Join Chat</big></b></a></li>
      <li><a href="del.php" onclick="return confirm('Are you sure?')">Delete Chat</a></li>
      <li><a href="./down.php">Download Chat</a></li>
	  <li><a href="./help.php"><b>Help</b></a></li>
      <li><a href="./logout.php" style="color:red"><b>Logout</b></a></li>
    </ul>
       
</div>
</div>	
<div class="panel-body">	
	<form action="" method="post">  
	<h4><b>Notice</b></h4>
     <label class="text-inline">
	<input type="text" name="notice" value="e.g. Ahlan wa Sahlan..."> 
    </label>
	<input type="submit" value="save" />	
	</form>
	
	<form action="" method="post">  
	<h4><b>Disable chat?</b></h4>
     <label class="radio-inline">
	<input type="radio" name="dischat" value="yes"> <span style="color:red"><b>Yes</b></span>
    </label>
    <label class="radio-inline">
      <input type="radio" name="dischat" value="no" checked> No
    </label>
	<input type="submit" value="save" />	
	</form>
	
	
	<form action="" method="post">  
	<h4><b>Select Number of Lines to be shown in Chat at a time: [Now showing: <?php echo bufmsg();?> lines]</b></h4>
     <label class="radio-inline">
      <input type="radio" name="chat" value="25"> 25
    </label>
    <label class="radio-inline">
      <input type="radio" name="chat" value="50"> 50
    </label>
    <label class="radio-inline">
      <input type="radio" name="chat" value="75"> 75
 	 </label>
    <label class="radio-inline">
      <input type="radio" name="chat" value="100"> 100
	 </label>
	<input type="submit" value="save" />	
	</form>
	
    
  
</nav>

      <div class="row">
        <div class="col-md-4">
          <h3 class="list-group-item border border-success ">
            Pending Users
          </h3>
           <div class="table-responsive border border-success"> 
            <table class="table" data-toggle="bootgrid">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    User Name
                  </th>
                  <th>
                    Approve / Remove
                  </th>
                </tr>
              </thead>
              <tbody>
                  <?php PendingUsers(); ?>
              </tbody>
            </table>
           </div>
          </div>
          <div class="col-md-8">
            <h3 class="list-group-item border border-success">
            Approved Users
            </h3>
             <div class="table-responsive border border-success">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      #
                    </th>
                    <th>
                      User Name
                    </th>
                    <th>
                      Remove
                    </th>
                    <th>
                      Type
                    </th>
                    <th>
                      Upgrade / Downgrade
                    </th>
                    <th>
                      Approved By
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php ApprovedUsers(); ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>
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
<?php ob_end_flush(); ?>
