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

if($_SESSION['utype']!=1)
{
  header("location: main.php");
  exit();
} 
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

<ul class="list-group">
  <li class="list-group-item">চ্যাট রুম <b><u>ডিসেবল বা বন্ধ </u></b> করে রাখা জন্য। “yes” দিয়ে সেভ দিলে চ্যাট রুম বন্ধ হয়ে যাবে। “no” দিয়ে সেভ দিলে 
	  আবার পুনরায় চালু হয়ে যাবে।</li>
  <li class="list-group-item"><b><u>Select Number of Lines to be shown in Chat at a time</b></u>:<br>
চ্যাট রুমে একবারে কতটা করে মেসেজ দেখাবে সেটা সেট করার জন্য। যেমনঃ যদি ২৫ হয় তাহলে পুর্বের ২৫টি মেসেজ দেখাবে। কোন ভাই ক্লাসে দেরি করে উপস্থিত হলে 
	  পুর্বের ২৫ টি মেসেজ দেখতে পারবেন , বাকি গুলো দেখাবে না। এটা সেট করার জন্য নিচের অপসান থেকে বাছাই করে সেভ দিতে হবে।<br>
	  বিঃদ্রঃ এতে চ্যাট হিস্টোরি থেকে মুছে যাবে না। হিস্টোরি পরে ডাউনলোড অপশনের মাধ্যমে ডাউনলোড করা যাবে।
</li>
  <li class="list-group-item"><b><u>[Now showing: 25 lines] </b></u><br>
	বর্তমানে কতটি মেসেজ সেট করা আছে সেটা দেখাবে। যেমনঃ এখন দেখাচ্ছে ২৫টি লাইন।
	</li>
	
	<li class="list-group-item"><b><u>Download Chat</b></u>: চ্যাট হিস্টোরি ডাউনলোড করার জন্য।
		
	</li>
		<li class="list-group-item"><b><u>Delete Chat</b></u>: চ্যাট হিস্টোরি ডিলিট করার জন্য।<br>
		বিঃদ্রঃ ডিলিট করার আগে অবশ্যই ডাউনলোড করে নিবেন।
	</li>
		<li class="list-group-item"><b><u>Pending Users </b></u>: এটি অপেক্ষামান তালিকা। অর্থাৎ রেজিস্ট্রেশন করার পর আইডি গুলো এখানে show করবে। 
			<br><b><u>approve </b></u> অপশনের মাধ্যমে অনুমোদন দিতে হবে। 
			<br>আর অনুমোদন না দিতে চাইলে <b><u>Delete </b></u> অপশনের মাধ্যমে ডিলেট করে দেওয়া যাবে।
		
	</li>
		<li class="list-group-item"><b><u>Approved users</b></u>: অনুমোদনপ্রাপ্ত ভাইদের লিস্ট এখানে দেখাবে।<br> 
			<b><u>Delete</b></u> অপশনের মাধ্যমে ডিলেট করে দেওয়া যাবে। <br>
			<b><u>Make Admin </b></u> অপশনের মাধ্যমে ভাইদের প্রমোশন করিয়ে এডমিনের দায়িত্ত দেওয়া যাবে। <br>
			<b><u>Make User</b></u> অপশনের মাধ্যমে ডিমোশন করে দেওয়া যাবে।  <br>
			বিঃদ্রঃ মুল এডমিন হলো client । এজন্য মুল এডমিন এর আইডি প্রমোশন, ডিমোসান বা ডিলেট হবে না। শুধু পাসওয়ার্ড চেঞ্জ করা যাবে। <br>
			<b><u>Type</b></u> এ কে এডমিন এবং কে উইজার সেটা সো করবে। <br>
			<b><u>Approved by</b></u>: কোন ভাইকে কোন এডমিন অনুমোদন দিয়েছেন সেটা সো করবে।
	</li>
		<li class="list-group-item">
		
	</li>
</ul> 

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