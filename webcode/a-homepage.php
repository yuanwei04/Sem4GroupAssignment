<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Help Centre</title>
<link href="a-homepage.css" rel="stylesheet">
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

<!--hero section-->
<div class="heroImage">

	<div class="heroText">
	
	<h1>Helping Malaysians in Need</h1>
	<h2> Food Banks at Your Service</h2>
	
	<a href="a-request.php"><button id="donateBtn" >Donate</button></a>
	<a href="a-foodbankInfo.php"><button id="searchBtn">Search</button></a>
	
	</div>
</div>
<!--who we are-->
<div class="whoWeAre">
	<h2 id="title1">WHO WE ARE</h2>
	<div id="para1">
	<p><strong>Food Bank Centre</strong> is a beacon of hope, dedicated to addressing the critical challenge 
	of food insecurity in Malaysia. We are a compassionate collective of individuals, united by a shared 
	mission to uplift our communities and ensure that no one goes hungry. Discover who we are and how our 
	unwavering commitment drives us to make a meaningful impact in the lives of those facing adversity.
	</p>
	
	<p>Our mission is to provide essential food support to those in need throughout Malaysia. 
	As a dedicated organization, we strive to address the pressing issue of food insecurity and ensure that no one goes hungry. 
	</p>
	
	<p>Discover who we are, our values, and the impactful initiatives we undertake to make a tangible 
	difference in the lives of individuals and communities across the country.
	</p>
	</div>
	<a href="a-about.html"><button id="aboutBtn">LEARN MORE</button></a>
	
</div>
<!--what we do-->
<div class="whatWeDo">
     <h2 id="title2">WHAT WE DO</h2>
         <div class="services">
            <div class="content content-1">
               
               <h3 id="contentTitle">
                  Food Donation
               </h3>
			   <img src="Img/cashDonation.jpg" alt="Cash Donation Image">
               <p>
                 We actively collaborate with local businesses, donors, and the community to collect food donations. These donations can include 
				 perishable and non-perishable food items, fresh produce, and packaged goods. Our dedicated team works tirelessly to ensure that we receive
				 a steady supply of food donations from various sources, including supermarkets, wholesalers, and individuals.
               </p>
			   
              
            </div>
            <div class="content content-2">
               
               <h3 id="contentTitle">
                  Food Secure
               </h3>
			   <img src="Img/foodSecure.jpg" alt="Food Secure Image">
               <p>
			   We take part in food rescue programs, which involve rescuing surplus food from restaurants, hotels, and other establishments 
			   that would otherwise go to waste. By redirecting this surplus food to our food bank, we prevent it from being discarded and 
			   ensure that it reaches those facing food insecurity. This process not only reduces food waste but also provides additional 
			   resources to support individuals and families in need.
               </p>
              
            </div>
            <div class="content content-3">
               
               <h3 id="contentTitle">
                  Advocacy
               </h3>
			   <img src="Img/foodDrive.jpg" alt="Food Drives">
               <p>
			  Advocacy is a crucial component of our organization's mission. We actively engage with policymakers, government officials, 
			  and the public to raise awareness about food insecurity issues and advocate for systemic changes. Our goal is to promote policies
			  that address the root causes of hunger, improve access to nutritious food, and support initiatives that foster sustainable solutions for food insecurity.
               </p>
              
            </div>
         </div>
</div>
<!--searching food banks-->
<div class="foodBankSection">
  <p>Through our website, users can search for nearby food banks, request food donation collections, 
  and learn about volunteer opportunities. We also collaborate with local businesses and organizations to organize food drives and awareness campaigns.
  </p>
  <h2 id="title3">Discover Local Food Banks</h2>
  <a href="a-foodbankInfo.php"><button id="discoverBtn">DISCOVER NOW</button></a>	
  
  
</div>
<!--Footer-->
<div class="footer">

	<div class="logo"><img src="Img/Logo footer dark forest(edit).png"></div>
	<div class="infos"><br><br><p>09-04 Bukit Jalil&nbsp;.&nbsp;Jalan Durian&nbsp;.&nbsp;Taman Impian Indah&nbsp;.&nbsp;57000 Kuala Lumpur</p><hr></div>
	<div class="infos">		
			<div class="info"><p>01139383370</p></div>
			<div class="info"><p>danielfin04@gmail.com</p></div>
		</div>

	<div class="row">
		<div class="icon"><a href="#"><img src="Img/facebook.png"></a></div> 
		<div class="icon"><a href="#"><img src="Img/instagram.png"></a></div>
		<div class="icon"><a href="#"><img src="Img/twitter.png"></a></div> 
	</div>

<div class="company">
  <a class="CU" href="a-contact.php">&nbsp;&nbsp;&nbsp;Contact Us&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="AU" href="a-about.html">&nbsp;&nbsp;&nbsp;About Us&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="TOS" href="a-about.html">&nbsp;&nbsp;&nbsp;Term of Service&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="PP" href="a-about.html">&nbsp;&nbsp;&nbsp;Privacy Policy&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="CP" href="a-about.html">&nbsp;&nbsp;&nbsp;Cookie Policy&nbsp;&nbsp;&nbsp;</a>
</div>
 
</div>

<?php
    // Check and display the welcome alert
    if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']) {
?>
    <!-- Display a welcome alert using JavaScript -->
    <script>
	window.onload = function() {
		alert("Welcome! You have successfully logged in.");
	}	
    </script>
<?php
     // Unset the loginSuccess session variable
    unset($_SESSION['loginSuccess']);
    }
?>

</body>
</html>