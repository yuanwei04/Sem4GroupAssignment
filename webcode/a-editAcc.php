<?php
session_start();// Start session
include 'a-DBconnect.php'; // Include database connection

// Retrieve user ID from the session
$userid = $_SESSION['userid'];
$hasEmptyFields = false;  // Flag to track empty fields
if (isset($_POST['submit'])) {
    if(!empty($_POST['newUsername'])){
		$newUsername = $_POST["newUsername"];
	}
	else{
		$hasEmptyFields = true; 
		echo "<script>";
        echo "alert('Username cannot be empty !');";
		echo "window.location.href = 'a-profile.php';";
		echo "</script>";
	}
	
	if(!empty($_POST['newAge'])){
		$newAge = $_POST["newAge"];
	}
	else{
		$hasEmptyFields = true; 
		echo "<script>";
        echo "alert('Age cannot be empty !');";
		echo "window.location.href = 'a-profile.php';";
		echo "</script>";
	}
	
	if(!empty($_POST['newPw'])){
		$newPassword = $_POST["newPw"];
	}
	else{
		$hasEmptyFields = true; 
		echo "<script>";
        echo "alert('Password cannot be empty !');";
		echo "window.location.href = 'a-profile.php';";
		echo "</script>";
	}
	
    if(!$hasEmptyFields){
    // Update user information in the database
    $updateQuery = "UPDATE account SET name='$newUsername', age=$newAge, password='$newPassword'
					WHERE accountID='$userid'";
	$result = mysqli_query($conn, $updateQuery);				
    
    if ($result) {
		
		$_SESSION['username']=$newUsername;
		$_SESSION['age']=$newAge;
		$_SESSION['password']=$newPassword;
       // Display a JavaScript alert and redirect
        echo "<script>";
        echo "alert('Thank you for updating your details!');";
        echo "window.location.href = 'a-profile.php';"; // Redirect to the profile page
        echo "</script>";
    } 
	else {
        echo "Error updating user information: " . mysqli_error($conn);
    }
    
	}

}
 mysqli_close($conn);
?>
