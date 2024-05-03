<?php
session_start();// Start session 
include 'a-DBconnect.php'; // Include database connection
// Retrieve superuser information from the session
$superuser = $_SESSION['superuser'];
$accountType =  $_SESSION['accountType'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href="a-superprofile.css" rel="stylesheet">
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
	<h2>Superuser Panel</h2>	
	<ul>
		<li><a href="a-superuser.php">Admin Details</a></li>
		<li><a href="a-superuser.php?action=create">Create Admin</a></li>
		<li><a href="a-superprofile.php">
		<i class="fas fa-user-circle" style="font-size:23px;"></i></a>
			<div class="dropDown">
			<a href="a-superprofile.php" ><?=$accountType?>: <?=$superuser?></a>
			<a href="a-logout.php">Logout</a>
			</div>
		</li>
	</ul>
</div>

<?php
$sql="SELECT * FROM account WHERE accountType='Superuser'";
$superuser_result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($superuser_result)):
    $superID = $row['accountID'];
    $superEmail = $row['email'];
    $superPass = $row['password'];
?>
    <div class="super-container">
        <h4>Superuser ID:</h4><?php echo $superID?>
        <h4>Superuser Email (For Login):</h4><?php echo $superEmail?>
        <h4>Superuser Password:</h4><?php echo $superPass?>
        <form action="" method="post">
        <input type="text" name="superPass" value="" placeholder="Change Password" required><br>
        <input type="submit" name="updateSuper" value="Change">
        </form>
    <div>
<?php endwhile ?>
</table>

<!--Superuser Change Password Php-->
<?php 
if (isset($_POST['updateSuper'])){
    $superPass=$_POST['superPass'];

    $sql=" UPDATE account SET password='$superPass' WHERE accountType = 'Superuser' ";
    $result=mysqli_query($conn,$sql);
    if($result){
       $_SESSION['alert']= "Password Changed Successfully";
       header("Location:a-superuser.php");
    }
     else{
     $_SESSION['alert']="Password Change Unsuccessful";
     }
}    
?>
</html>