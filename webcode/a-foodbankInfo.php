
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href="a-foodbankInfo.css" rel="stylesheet">
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

<h1 id="title1">FOOD BANK INFO</h1> 

	
<?php 
include('a-DBconnect.php'); // Include database connection

    // Function to retrieve food bank data
    function getFoodBanks($conn) {
        $sql = "SELECT * FROM foodbank";
        $result = mysqli_query($conn,$sql);
		$count=mysqli_num_rows($result);
        $foodBanks = array();

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $foodBanks[] = $row;
            }
        }

        return $foodBanks;
    }
	
	// Retrieve and display food bank data
    $foodBanks = getFoodBanks($conn);
	
	$foodbanksPerRow = 3;
	$rowCount = 0;
	
	echo '<div class="FoodBankInfo">'; // Start the first FoodBankInfo div

    foreach ($foodBanks as $foodBank) {
		if ($rowCount % $foodbanksPerRow === 0 && $rowCount !== 0) {
			echo '</div>'; // Close the previous FoodBankInfo div
			echo '<div class="FoodBankInfo">'; // Start a new FoodBankInfo div
		}
		
        $location = $foodBank['location'];
        $imageAlt = $location . ' Branch';
        $address = $foodBank['address'];
		$contactNum = $foodBank['contactNum'];
		$openHrs = $foodBank['openHour'];
		$closeHrs = $foodBank['closeHour'];
		// Convert openHour and closeHour to user-friendly format
		$openHrs = date('g:i a', strtotime($openHrs));
		$closeHrs = date('g:i a', strtotime($closeHrs));


        echo '<div class="content">';
        echo '<h2 id="contentTitle">' . $location . '</h2>';
        echo '<img src="Img/' . $location . ' Branch.jpg" alt="' . $imageAlt . '">';
        echo '<ul>';
        echo '<li>Address: ' . $address . '</li>';
		echo '<li>Hours: ';
		echo '<br>Open '.$openHrs;
		echo '<br>Close '.$closeHrs;
		echo '</li>';
        echo '<li>Phone: ' . $contactNum . '</li>';
        echo '</ul>';
        echo '</div>';
		
		$rowCount++;
    }
	
    echo '</div>'; // Close the last FoodBankInfo div

// Close the database connection
mysqli_close($conn);
?>

<a href="a-request.php"><button id="requestBtn">REQUEST NOW</button></a>

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
  <a class="CU" href="">&nbsp;&nbsp;&nbsp;Contact Us&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="AU" href="">&nbsp;&nbsp;&nbsp;About Us&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="TOS" href="">&nbsp;&nbsp;&nbsp;Term of Service&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="PP" href="">&nbsp;&nbsp;&nbsp;Privacy Policy&nbsp;&nbsp;&nbsp;</a>
  |
  <a class="CP" href="">&nbsp;&nbsp;&nbsp;Cookie Policy&nbsp;&nbsp;&nbsp;</a>
</div>
 
</div>


</body>
</html>
