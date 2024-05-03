<?php
session_start();// Start session 
include 'a-DBconnect.php'; // Include database connection
//initialization
$email="";
$pass="";

// Check if the user is already logged in
  if (isset($_SESSION['userid'])) {
    echo '<script>';
    echo 'if (confirm("You are already logged in. Do you want to log out?")) {';
    echo '   window.location.replace("a-logout.php");'; // Redirect to logout page
    echo '} else {';
    echo '   window.location.replace("a-homepage.php");'; // Redirect to homepage if user cancels
    echo '}';
    echo '</script>';
    exit();
  }

  if(isset($_POST['submit'])) {//Validate submit
	if(!empty($_POST['email']) && !empty($_POST['password'])) {
    
        $email = $_POST['email']; 
        $pass = $_POST['password'];

        $sql = "SELECT * FROM account WHERE email='$email'";
        $result = mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);

        if ($count == 1) {
        
           $row = mysqli_fetch_assoc($result);

           if ($_POST['password'] == $row['password']){
			   
			   // Set a session variable to indicate successful login
				$_SESSION['loginSuccess'] = true;
			   //if admin login
               if ($row['accountType'] == "admin"){
               
                  $_SESSION['admin'] = $_POST['email'];
                  $_SESSION['accountType'] = $row['accountType'];
 
                  header("Location: a-admin.php");
                  exit();
               }
			   
			   //if superuser login
			   if ($row['accountType'] == "superuser"){
               
                  $_SESSION['superuser'] = $_POST['email'];
                  $_SESSION['accountType'] = $row['accountType'];
 
                  header("Location: a-superuser.php");
                  exit();
               }
			   
			   //if user login	
               else 
               {
                  $_SESSION['userid'] = $row['accountID']; 
                  $_SESSION['email'] = $row['email']; 
                  $_SESSION['password'] = $row['password']; 
                  $_SESSION['accountType'] = $row['accountType'];
  
                  header("Location: a-homepage.php");
                  exit();
               }

           }
           else {
             $passerror = "Incorrect password";
           }
        }
         else {
             $errormsg = "Email not found";
        }

    }
    else 
    {
        if(!empty($_POST['email'])){

            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {//Validate email
                $email=$_POST['email'];
                
            }        
            else{
                $emailerror= "Email format is incorrect!";//Alert message red
            }	
        }
        else   {
            $emailerror= "Email is required";
        }
    
    
    
        if(!empty($_POST['password']))
        {
            
            $pattern='/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#%$&])[0-9A-Za-z!@#$%&]{8,12}$/'; //(?=.*[A-Za-z]) means at least one A-Za-z, 
                                                                                       //!@#$%& as special character, {8,12} 8-12character
            if(preg_match($pattern,$_POST['password'])) {//Validate password    
                $pass=$_POST['password'];
            }
            else{
                $passerror= "Password at least 8-12 with a uppercase, 
                      lowercase, number and special character!";}//Alert message red
        }
        else{	
            $passerror= "Password is required";
        }

    }
  }

// Close the database connection
mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Help Centre</title>
<link href="a-login.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css">
<!--SweetAlert files [for JavaScript Alert]-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!--Font Awesome link [for icon]-->
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<!--import the font "Lato" from the Google Fonts service-->

</head>
<body>

<!--top nav bar-->
<div class="menu">
	<img src="Img/Logo header.png"alt="logo">
	<p id="logoTitle">Food Help Centre</p>
     <ul>
        <li><a href="a-homepage.php">Home</a></li>
		<li><a href="a-about.html">About</a></li>
        <li>
		<a href="#">Services</a>
		<div class="dropDown">
		<a href="a-foodbankInfo.php">Food Bank</a>
		<a href="a-request.php">Requests</a>
		</div>
		</li>	
        <li><a href="a-contact.php">Contact</a></li>
		<li style="margin-right:0;"><a href="a-login.php">Login</a></li>
		<li style="margin-right:0;"><a href="a-profile.php">
		<i class="fas fa-user-circle" style="font-size:23px;"></i></a>
		</li>

     </ul>
</div>

<!--Login Form-->
<div class="loginForm">

    <h1 id="title">Login to Your Account</h1>
    <p id="subtitle">Join Us in the Fight Against Hunger</p>
    <form action="a-login.php" method="POST" >
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter your email"
		value="<?=$email?>">
		
		<?php if(!empty($emailerror)){?>
        <p class="error"><?php echo "$emailerror";}?></p>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password"><br>
        
		<?php if(!empty($passerror)){?>
        <p class="error"><?php echo "$passerror";}?></p>
        
        <button type="submit" name="submit" id="logInBtn">Log In</button>
        <a id="forgotPw" href="a-forgotPassword.php">Forgot password?</a><br>
		<?php if(!empty($errormsg)){?>
        <p class="error" style="text-align:center;"><?php echo "$errormsg";}?></p>
			<hr>
			<div class="signUp">
				<p>Don't have an account? <a href="a-signUp.php">Sign Up.</a></p>
		</div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['signupSuccess']) && $_SESSION['signupSuccess']) {
    // Display SweetAlert message using JavaScript
    echo '<script>';
    echo 'Swal.fire("Congrats!", "Your account is created!", "success");';
    echo '</script>';

    // Unset the session variable
    unset($_SESSION['signupSuccess']);
}
?>


</body>
</html>


