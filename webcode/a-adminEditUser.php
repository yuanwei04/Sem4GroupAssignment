<?php
session_start();// Start session 
include('a-DBconnect.php'); // Include database connection

// Retrieve user information from the session
$admin = $_SESSION['admin'];
$accountType =  $_SESSION['accountType'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Food Help Centre</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Bank Website</title>
<link rel="stylesheet" href="a-adminEditUser.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!--Font Awesome link [for icon]-->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<!--import the font "Bebas Neue" from the Google Fonts service-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--import the font "Lato" from the Google Fonts service-->

</head>

<body>

<!--Edit User Form-->
<?php

if(!empty($_GET['aid'])){
    $accountID=$_GET['aid'];

  $sql="SELECT * FROM account WHERE accountID='$accountID'";
  $result=mysqli_query($conn,$sql);

  if($row=mysqli_fetch_assoc($result)){
    $accountID=$row['accountID'];
    $name=$row['name'];
    $age=$row['age'];
    $email=$row['email'];
    $password=$row['password'];
  }
  else
    echo "User not found!";
}

mysqli_close($conn);//close connection
?>
<!-- Top navigation bar -->
<div class="topnav">

	<img src="Img/Admin Logo Header.png" alt="logo">
	<h2>Admin Panel</h2>	
	
    <ul>
		<li><a href="a-admin.php">User Details</a></li>
		<li><a href="a-adminRqst.php">User Request</a></li>
		<li><a href="a-adminFBInfo.php">Foodbank Info</a></li>
		<li><a href="#">
		<i class="fas fa-user-circle" style="font-size:23px;"></i></a>
			<div class="dropDown">
			<a href="#"><?=$accountType?>: <?=$admin?></a>
			<a href="a-logout.php">Logout</a>
			</div>
		</li>
    </ul>
</div>

<!--button redirect back to admin page-->
<div class="back-btn">
<a href="a-admin.php"><button id="backBtn"><i class="fa fa-arrow-left"></i> &nbsp Back</button></a>
</div>
<!--edit form-->
<div class="editArea">
<h3>Edit Form</h3>
<form action="a-adminUpdUser.php" method="post" class="editForm">
<label>Account ID:</label>
<input type="text" name="accountID" value="<?=$accountID?>" readOnly><br>
<label>Name:</label>
<input type="text" name="name" value="<?=$name?>" required><br>
<label>Age:</label>
<input type="text" name="age" value="<?=$age?>" required><br>
<label>Email:</label>
<input type="text" name="email" value="<?=$email?>" required><br>
<label>Password:</label>
<input type="text" name="password" value="<?=$password?>" required><br>
<input type="submit" name="update" value="UPDATE">
<input type="reset" name="reset" value="RESET">
</form>
</div>
</body>
</html>