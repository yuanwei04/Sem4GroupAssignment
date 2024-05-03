<?php

// Start session (required for accessing session data)
session_start();
include 'a-DBconnect.php'; // Include database connection
//initialization
 $newPass = "";
 $conPass = "";
 
  if(isset($_POST['submit'])){ //Validate submit
  
	  if(!empty($_POST['newPass'])){
		
        $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%&])[0-9A-Za-z!@#$%&]{8,12}$/'; //(?=.*[A-Za-z]) means at least one A-Za-z, 
                                                                                   //!@#$%& as special character, {8,12} 8-12character
		if(preg_match($pattern,$_POST['newPass'])) {//Validate password 
			$newPass=$_POST['newPass'];
		
			if(!empty($_POST['conPass'])){
		
				$conPass=$_POST['conPass'];
		
					if($newPass != $conPass) {
						$errormsg="Passwords do not match.";//Alert message red
			
					}
					else{
						$email = $_SESSION['email'];
						//change new password in database
						$sql="UPDATE account SET password='$newPass' 
							  WHERE email='$email'";
						$result=mysqli_query($conn,$sql);
				
						echo "<script>alert('Password reset successfully. You can now log in with your new password.'); window.location.replace('a-login.php');</script>";
						exit(); //redirect user to login page
				
					}
			}
			else{
				 $errormsg= "Comfirm password cannot be empty"; //Alert message red
			}
        }
        else{
			
            $passerror= "Password at least 8-12 with a uppercase, 
			lowercase, number and special character!";//Alert message red
		}
	  }
	  else{
        $passerror= "New password is required"; //Alert message red
		
	  }
	  
	  if(!empty($newPass) && !empty($conPass)) {
	  // Check if new password same as old one
			$sql="SELECT * FROM account WHERE password='$newPass'";
			$result=mysqli_query($conn,$sql);
			$count=mysqli_num_rows($result);

			if($count > 0) {
				$passerror=" Please enter a new password different from your current one.";//Alert message red
				$newPass="";
			}

			
	  }
	  

	}
 
// Destroy the session to log the user out
//session_destroy();

// Close the database connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head>
<title>Food Bank Reset Password</title>
<link href="a-resetPassword.css" rel="stylesheet">     <!--link to css-->
<!--import the font "Lato" from the Google Fonts service-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
<div class="resetPwForm">
    <h1 id="title">Reset Password</h1>
    <p id="subtitle">Enter your new password here</p>

    <form action="a-resetPassword.php" method="POST">
        New Password: <input type="password" name="newPass" id="newPass"><br>
		<?php if(!empty($passerror)){?>
		<p class="error"><?php echo "$passerror";}?></p>

        Confirm Password: <input type="password" name="conPass" id="conPass"><br>
		<?php if(!empty($errormsg)){?>
		<p class="error"><?php echo "$errormsg";}?></p>
		
        <button type="submit" name="submit" id="sendBtn">Confirm</button>
        <a href="a-login.php">Back to Login Page</a>
    </form>

</div>
    
</body>
</html>