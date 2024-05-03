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
<link rel="stylesheet" href="a-adminDeleteUser.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!--Font Awesome link [for icon]-->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<!--import the font "Bebas Neue" from the Google Fonts service-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--import the font "Lato" from the Google Fonts service-->

</head>
<body>
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

<!--Delete User Form-->
<?php

	if(!empty($_GET['aid'])){
		$accountID=$_GET['aid'];
	}
	
	$sql="SELECT * FROM account WHERE accountID='$accountID'";
	$result=mysqli_query($conn,$sql);
	
	if(mysqli_num_rows($result)>0){
		if($row=mysqli_fetch_assoc($result)){
			$accountID=$row['accountID'];
			$name=$row['name'];
		}  
	}
?>
<!--button redirect back to admin page-->
<div class="back-btn">
<a href="a-admin.php"><button id="backBtn"><i class="fa fa-arrow-left"></i> &nbsp Back</button></a>
</div>
<!--delete form-->
<div class="deleteArea">
<h3>Delete User Form</h3>
<form action="" method="post" class="deleteForm">
<label>Account ID:</label>
<input class="userID" type="text" name="accountID" value="<?=$accountID?>" readOnly>
<br><br>
<label>Name:</label>
<input class="userID" type="text" name="name" value="<?=$name?>" readOnly>
<br>
<input type="submit" name="submit" value="Delete" 
onclick="return confirm('Are you sure you want to delete this user?');">

</form>

</div>

<?php
if(isset($_POST["submit"])){
    if(!empty($_POST['accountID'])){
     $aid=$_POST['accountID'];
     $sql="DELETE FROM account WHERE accountID = '$aid'";

     $result=mysqli_query($conn, $sql);
     if($result){
        echo "User record deleted successfully!";
     }
     else
     echo("User recrod deletion failed:" . mysqli_error());
    }
 }
 mysqli_close($conn);
 ?>


</body>
</html>