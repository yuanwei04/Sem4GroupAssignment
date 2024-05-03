<?php
session_start();// Start session 
include('a-DBconnect.php'); // Include database connection

// Retrieve admin information from the session
$admin = $_SESSION['admin'];
$accountType =  $_SESSION['accountType'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Food Help Centre</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Bank Website</title>
<link rel="stylesheet" href="a-admin.css">
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
<!--Search-->
<?php
// Check if the form 'search' button was clicked
if(isset($_POST['search'])){
    $valueSearch = $_POST['valueSearch'];
    $sql = "SELECT * FROM account 
            WHERE accountType='user'
            AND (`name` LIKE '%$valueSearch%'
            OR `age` LIKE '%$valueSearch%'
            OR CONCAT(`accountID`, `email`, `password`) LIKE '%$valueSearch%')";

    $search_result = filterTable($conn,$sql); // Call the function to filter the database table based on the query
}
 else{ // If the search button wasn't clicked, select all records from the table
    $sql = "SELECT * FROM account
            WHERE accountType='user'";
    $search_result = filterTable($conn,$sql);
}

function filterTable($conn,$sql){
	
    // Execute the SQL query and store the results in $filter_Result
    $filter_Result = mysqli_query($conn,$sql);
    
    // Return the results of the query
    return $filter_Result;
}

?>

<div class="search">
<form action="a-admin.php" method="post">
<input type="text" name="valueSearch" placeholder="Search">
<button type="submit" name ="search" id="searchBtn"><i class="fa fa-search"></i></button>
</div>

<!--User Details Table-->
<div class="UserDetails">
<table class="viewTable">
    <tr>
        <th>User ID</th> 
        <th>Name</th> 
        <th>Age</th> 
        <th>Email</th> 
        <th>Password</th>
        <th>Edit</th> 
        <th>Delete</th>
    </tr>

<?php 
while($row = mysqli_fetch_array($search_result)):
    $accountID=$row['accountID'];
    $name=$row['name'];
    $age=$row['age'];
    $email=$row['email'];
    $password=$row['password'];

?>
    <tr>
        <td><?php echo $accountID?></td> 
        <td><?php echo $name?></td>
        <td><?php echo $age?></td> 
        <td><?php echo $email?></td> 
        <td><?php echo $password?></td> 
        <td><a href="a-adminEditUser.php?aid=<?=$accountID?>">EDIT</a></td>
        <td><a href="a-adminDeleteUser.php?aid=<?=$accountID?>">DELETE</a></td>
    </tr>
<?php 

	endwhile;

?>
  </table>
</form>
</div>
</body>
</html>