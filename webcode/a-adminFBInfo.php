<?php
session_start();// Start session 
include 'a-DBconnect.php'; // Include database connection

// Retrieve user information from the session
$admin = $_SESSION['admin'];
$accountType =  $_SESSION['accountType'];

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href="a-adminFBInfo.css" rel="stylesheet">
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


<!-- Container for side navigation and main content -->
<div class="container">

<!-- Side navigation bar -->
<div class="sidenav">
    <a href="?action=view">View Food Banks</a>
    <a href="?action=add">Add Food Bank</a>
    <a href="?action=edit">Edit Food Bank</a>
    <a href="?action=delete">Delete Food Bank</a>
</div>

<!-- Main content area -->
  <div class="main">

   <?php

    // Handle actions based on selected link
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'view':
				echo '<h3>View Food Banks</h3>';

				// Function to retrieve food bank data
				function getFoodBanks($conn) {
					$sql = "SELECT * FROM foodbank";
					$result = mysqli_query($conn, $sql);

					$foodBanks = array();

					if ($result) {
						while ($row = mysqli_fetch_assoc($result)) {
							$foodBanks[] = $row;
						}
					}

					return $foodBanks;
				}
				$foodBanks = getFoodBanks($conn);

				echo '<table class="viewTable">';
				echo '<tr><th>Location</th><th>Contact Number</th><th>Address</th>
				<th>Opening Hour</th><th>Closing Hour</th><th>Actions</th></tr>';

				foreach ($foodBanks as $foodBank) {
					echo '<tr>';
					echo '<td>' . $foodBank['location'] . '</td>';
					echo '<td>' . $foodBank['contactNum'] . '</td>';
					echo '<td>' . $foodBank['address'] . '</td>';
					echo '<td>' . $foodBank['openHour'] . '</td>';
					echo '<td>' . $foodBank['closeHour'] . '</td>';
					echo '<td><a href="?action=edit&id=' . $foodBank['foodBankNo'] . '">
					Edit</a> | <a href="?action=delete&id=' . $foodBank['foodBankNo'] . '">Delete</a></td>';
					echo '</tr>';
				}

				echo '</table>';

                break;

            case 'add':
			 
				// Function to insert a new food bank
				function insertFoodBank($conn, $location, $contactNum, $address, $openHour, $closeHour) {
					$sql = "INSERT INTO foodbank (location, contactNum, address, openHour, closeHour) VALUES ('$location', '$contactNum', '$address', '$openHour', '$closeHour')";
					mysqli_query($conn, $sql);
				}
			    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$location = $_POST['location'];
					$contactNum = $_POST['contactNum'];
					$address = $_POST['address'];
					$openHour = $_POST['openHour'];
					$closeHour = $_POST['closeHour'];

					insertFoodBank($conn, $location, $contactNum, $address, $openHour, $closeHour);

					echo 'Food bank added successfully!';
				}
				
				echo '<h3>Add Food Bank</h3>';
				echo '<form method="POST" class="addForm">';
				echo '<label for="location">Location:</label>';
				echo '<input type="text" name="location" required><br>';
				echo '<label for="contactNum">Contact Number:</label>';
				echo '<input type="text" name="contactNum" required><br>';
				echo '<label for="address">Address:</label>';
				echo '<textarea name="address" required></textarea>';
				echo '<label for="openHour">Opening Hour:</label>';
				echo '<input type="time" name="openHour" required><br>';
				echo '<label for="closeHour">Closing Hour:</label>';
				echo '<input type="time" name="closeHour" required><br>';
				echo '<input type="submit" value="ADD">';
				echo '</form>';
               

				
                break;

            case 'edit':

				if (!isset($_GET['id'])) {
					echo '<p>Please choose a food bank to edit</p>';
					echo '<a href="?action=view">View Food Banks</a>';
				} 
				else {
					$foodBankNo = $_GET['id'];
				
				// Function to retrieve a specific food bank by its ID
				function getFoodBankById($conn, $foodBankNo) {
					$sql = "SELECT * FROM foodbank WHERE foodBankNo = '$foodBankNo'";
					$result = mysqli_query($conn, $sql);
					$foodBank = mysqli_fetch_assoc($result);
					return $foodBank;
				}
				
				$foodBank = getFoodBankById($conn, $foodBankNo);
				
				// Function to update an existing food bank
                function updateFoodBank($conn, $foodBankNo, $location, $contactNum, $address, $openHour, $closeHour) {
					$sql = "UPDATE foodbank SET location = '$location', contactNum = '$contactNum', 
					address = '$address', openHour = '$openHour', closeHour = '$closeHour' 
					WHERE foodBankNo = '$foodBankNo'";
					mysqli_query($conn, $sql);
				}
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$location = $_POST['location'];
					$contactNum = $_POST['contactNum'];
					$address = $_POST['address'];
					$openHour = $_POST['openHour'];
					$closeHour = $_POST['closeHour'];

					updateFoodBank($conn, $foodBankNo, $location, $contactNum, $address, $openHour, $closeHour);

					echo 'Food bank updated successfully!';
				}
				
				echo '<h3>Edit Food Bank</h3>';
				echo '<form method="post" class="editForm">';
				echo '<label for="location">Location:</label>';
				echo '<input type="text" name="location" value="' . $foodBank['location'] . '" required><br>';
				echo '<label for="contactNum">Contact Number:</label>';
				echo '<input type="text" name="contactNum" value="' . $foodBank['contactNum'] . '" required><br>';
				echo '<label for="address">Address:</label>';
				echo '<input type="text" name="address" value="' . $foodBank['address'] . '" required><br>';
				echo '<label for="openHour">Opening Hour:</label>';
				echo '<input type="time" name="openHour" value="' . $foodBank['openHour'] . '" required><br>';
				echo '<label for="closeHour">Closing Hour:</label>';
				echo '<input type="time" name="closeHour" value="' . $foodBank['closeHour'] . '" required><br>';
				echo '<input type="submit" value="Update">';
				echo '</form>';
				
				}
				
				break;

            case 'delete':
			
				if (!isset($_GET['id'])) {
					echo '<p>Please choose a food bank to delete</p>';
					echo '<a href="?action=view">View Food Banks</a>';
				} 
				else {
					$foodBankNo = $_GET['id'];
				// Function to delete a food bank
				function deleteFoodBank($conn, $foodBankNo) {
					$sql = "DELETE FROM foodbank WHERE foodBankNo = '$foodBankNo'";
					mysqli_query($conn, $sql);
				}
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					deleteFoodBank($conn, $foodBankNo);
					echo 'Food bank deleted successfully!';
				} 
				else {
					echo '<h3>Delete Food Bank</h3>';
					echo '<p>Are you sure you want to delete this food bank?</p>';
					echo '<form method="post">';
					echo '<input type="submit" value="Yes">';
					echo '</form>';
				}
				}
				break;

            default:
			// Display a message if the action is not recognized
                echo "Invalid action!";
                break;
        }
    }
    ?>
  </div>
  
</div>

</body>
</html>
