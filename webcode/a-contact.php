<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Bank Website</title>
<link href="a-contact.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<!--Font Awesome link [for icon]-->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<!--import the font "Bebas Neue" from the Google Fonts service-->
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


<form method="POST" action="#">
	<h1 id="title">Contact us</h1>
	<p id="subtitle">
	To ensure we can answer your query quickly and efficiently,
	please provide answers to as many of the following questions as possible.
	</p>
	
	<input type="text" id="name" name="fname" placeholder="First Name">
	<input type="text" id="name" name="lname" placeholder="Last Name">
	<br>
	<input type="text" name="email" placeholder="Your email address">
	<br>
	<select name="Type of user" placeholder="Type of user">
       <option name="userType">Select</option>
       <option value="For donors">For donors</option>
       <option value="For existing fundraisers on our site">For existing fundraisers on our site</option>
       <option value="For potential fundraisers">For potential fundraisers</option>
       <option value="Others">Others</option>
	</select>
	<br>
	<textarea name="message" placeholder="How can we help you?"></textarea>
	<br>
	<input type="submit" name="Submit" value="Send message">
	
</form>
</body>
</html>