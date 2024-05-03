<?php

// Start session (required for accessing session data)
session_start();
include 'a-DBconnect.php'; // Include database connection

//initialization
 $email="";
 
 if(isset($_POST['submit'])){ //Validate submit
 
	if(!empty($_POST['email'])){
		
        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){ //Validate email
            $email=$_POST['email'];
			
			$sql="SELECT * FROM account WHERE email='$email'";
			$result=mysqli_query($conn,$sql);
			$count=mysqli_num_rows($result);
			
			//check if user is already signed up
			if($count == 0) {
				$emailerror="Email not found. 
				Please check your input or sign up for a new account.";
				$email="";

			}
			else{
				$_SESSION['email'] = $email;
				header("Location:a-resetPassword.php");
				exit();
			}
			
		}	
        else{
            $emailerror= "Email format is incorrect!";//Alert message red
		}
    }
    else{
        $emailerror= "Email is required";
	}
 
 }
 
// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--import the font "Lato" from the Google Fonts service-->
<link href="a-forgotPass.css" rel="stylesheet">
</head>
<body>
<div class="forgotPwForm">
	
	<h1 id="title">Forgot your password ? </h1>
	<p id="subtitle">Enter your email address to receive your password reset instructions</p>
	<form action="a-forgotPassword.php" method="POST" >

		<input type="text" id="email" name="email" placeholder="Enter your email">
		
		<?php if(!empty($emailerror)){?>
		<p class="error"><?php echo "$emailerror";}?></p>

		<button type="submit" name="submit" id="sendBtn">Send</button>
		<a href="a-login.php">Back to Login Page</a>
	</form>
</div>

</body>
</html>