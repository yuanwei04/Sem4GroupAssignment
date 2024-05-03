<?php 
session_start();// Start session 
// Include database connection
include('a-DBconnect.php');

 //initialization
 $date="";
 $time="";
 $contactNum="";
 $address="";
 $postcode="";
 $state="";
 $city=""; 
 $itemDonate="";
 $qty="";
 $foodbank="";
 
 if(isset($_POST['submit'])) {  //Validate submit
	// Check if the user is already logged in
	if (!isset($_SESSION['userid'])) {
		echo '<script>';
		echo 'if (confirm("Please log in to access the donation request area. Do you want to login?")) {';
		echo '   window.location.replace("a-login.php");'; // Redirect to login page
		echo '} else {';
		echo '   window.location.replace("a-request.php");';
		echo '}';
		echo '</script>';
		exit();
	}
	else{
  //validate form fields	
  $hasEmptyFields = false;  // Flag to track empty fields
  
  if (empty($_POST['date'])) {
	$dateError = "Date is required";
	$hasEmptyFields = true; 
  }
  else{
	//converts the submitted date into a "Y/m/d" format 
	$date = date("Y/m/d", strtotime($_POST['date']));  
  }
  if (empty($_POST['time'])){
	  $timeError = "Time is required";
	  $hasEmptyFields = true; 
  } 
  else{
	  $time = $_POST['time'];
  }
  if (empty($_POST['contactNum'])){
	  $conError = "Contact number is required";
	  $hasEmptyFields = true; 
  } 
  else{
	  //escape and sanitize user input to prevent SQL injection attacks
	$contactNum = mysqli_real_escape_string($conn, $_POST['contactNum']);
  }
  if (empty($_POST['address'])){
	   $addError = "Address is required";
	   $hasEmptyFields = true; 
  } 
  else{
	$address = mysqli_real_escape_string($conn, $_POST['address']); 
  }
  if (empty($_POST['postcode'])){
	  $pError = "Postcode is required";
	  $hasEmptyFields = true; 
  } 
  else{
	 $postcode = mysqli_real_escape_string($conn, $_POST['postcode']); 
  }
  if (empty($_POST['state'])){
	  $sError = "State is required";
	  $hasEmptyFields = true; 
  } 
  else{
	  $state = mysqli_real_escape_string($conn, $_POST['state']);
  }
  if (empty($_POST['city'])){
	  $cError = "City is required";
	  $hasEmptyFields = true; 
  }
  else{
	   $city = mysqli_real_escape_string($conn, $_POST['city']);
  }
  if (empty($_POST['foodbank'])){
	  $fbError = "Please choose a foodbank to donate";
	  $hasEmptyFields = true; 
  } 
  else{
	   $foodbank = mysqli_real_escape_string($conn, $_POST['foodbank']);
  }
  // Validation checks for non-empty fields
    if(!$hasEmptyFields){
		// Get the selected food items and entered quantities as an array
		$itemDonate = $_POST['itemDonate'];
        $qty = $_POST['itemQty'];
		
			//Check for duplicate items
			$selectedFoodItems = array(); // Array to store selected food items
			$hasDuplicate = false; // Flag to track duplicate items
			
			// Loop through the selected items and check for duplicates
			for ($i = 0; $i < count($itemDonate); $i++) {
				$foodItem = mysqli_real_escape_string($conn, $itemDonate[$i]);

				if (in_array($foodItem, $selectedFoodItems)) {
					// Duplicate item found, set flag and break loop
					$hasDuplicate = true;
					break;
				}

				// Add the item to the array if not duplicate
				$selectedFoodItems[] = $foodItem;
			}
			
			if ($hasDuplicate) {
				$itemError = "You have already selected this food item.";
			}
			
			
			//Check for invalid items
			$validItems = array(); // Store valid items and quantities
			$invalidItems = false; //Flag to track invalid items
			
			for ($i=0; $i < count($itemDonate); $i++){
				if(empty($itemDonate[$i]) && !empty($qty[$i])) {
					$invalidItems = true;
					$itemError = "Please select a food item for all entered quantities.";
					break;
				}
				else if (!empty($itemDonate[$i]) && empty($qty[$i])){
					$invalidItems = true;
					$qtyError = "Please enter a quantity for all selected food items.";
					echo $qty[$i];
					break;
				}
				else if (!empty($itemDonate[$i]) && !empty($qty[$i]) && intval($qty[$i]) <= 0){ //convert the text input into an 
					$invalidItems = true;														// integer before comparing it against 0
					$qtyError = "Quantity must be greater than zero.";
					echo $qty[$i];
					break;
					
				}
				else if (!empty($itemDonate[$i]) && !empty($qty[$i])){
					//If both not empty, add them to validItems
					$foodItem = mysqli_real_escape_string($conn, $itemDonate[$i]);
					$quantity = mysqli_real_escape_string($conn, $qty[$i]);
					
					$validItems[] = array(
                    'foodItem' => $foodItem,
                    'quantity' => $quantity
					);
					
				}
			} 
			
			//Database insertion
			if (!$invalidItems && !$hasDuplicate && count($validItems) > 0) {
			// Retrieve user information from the session
			$userid = $_SESSION['userid'];
			// SQL
            $sql = "INSERT INTO foodDonation(date, time, contactNum, address, city, postcode, state, status, foodBankNo, accountID)
                    VALUES('$date', '$time', '$contactNum', '$address', '$city', '$postcode', '$state', 'pending', '$foodbank', '$userid')";
            $result = mysqli_query($conn, $sql);
			// Retrieve the last auto-generated ID
			$donationID = mysqli_insert_id($conn);

            // Insert each valid food item and its quantity into the foodDonationItem table
            foreach ($validItems as $item) {
				//foodItem and quantity is the key in array "$item"
				$foodItemName = mysqli_real_escape_string($conn,$item['foodItem']); //Get the selected food item's name
                $quantity = mysqli_real_escape_string($conn,$item['quantity']);
				
				//fetch corresponding foodItemID from foodItem table
				$foodItemQuery = "SELECT foodItemID FROM foodItem 
								  WHERE name = '$foodItemName'";
				$foodItemResult = mysqli_query($conn,$foodItemQuery);
				$foodItemRow = mysqli_fetch_assoc($foodItemResult);
				$foodItemID = $foodItemRow['foodItemID'];

                $sql2 = "INSERT INTO foodDonationItem(foodDonationID, foodItemID, quantity)
                                  VALUES($donationID, '$foodItemID', $quantity)";
                $result2 = mysqli_query($conn, $sql2);
				
				
            }

            // Show success message and redirect
            echo "<script>alert('Request sent successfully.');";
            echo " window.location.replace('a-request.php');</script>";
            exit(); // Redirect user to request page
        
			}
		
    }
 }
 }
	

?>

<!DOCTYPE html>
<html >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Food Help Centre</title>
<link rel="stylesheet" href="a-request.css"/>
<script src="a-request.js" async></script>
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
<!--form-->
    <div class="container">
      <form action="a-request.php" method="POST">
        <div class="row">
          <div class="col">
            <h1 class="title">Donation Request Area</h1>

		<h3>Step 1: Donation Detail</h3>
<!--contact num-->		
        <div class="inputBox">
              <label>Contact Number</label> 
              <input type="text" placeholder="+60 160232287" name="contactNum" />
			<?php if(!empty($conError)){?>
			<p class="error" ><?php echo "$conError";}?></p>
        </div>
		
<!--Foodbank-->

	<!--PHP code to retrieve food bank options -->
	<?php
	$foodBankOptionsQuery = "SELECT foodBankNo, location FROM foodbank";
	$foodBankOptionsResult = mysqli_query($conn, $foodBankOptionsQuery);

	$foodBankOptions = array();

	while ($row = mysqli_fetch_assoc($foodBankOptionsResult)) {
		$foodBankOptions[$row['foodBankNo']] = $row['location'];
	}
	
	// Close the database connection
	mysqli_close($conn);
	?>


	<!--generating HTML form-->
	<div class="inputBox">
		<label>Where to Donate</label>
		
		<?php foreach ($foodBankOptions as $foodBankNo => $foodBankName) { ?>
			<input type="radio" name="foodbank" value="<?php echo $foodBankNo; ?>"> 
			<?php echo $foodBankName; ?>
		<?php } ?>
		
		<?php if (!empty($fbError)) { ?>
        <p class="error"><?php echo $fbError; } ?></p>
		
	</div>	

<!--Food item-->					
		<div class="food-items-container" id="food-items-container">
			<div class="food-item" id="food-item">
              <label>Food Item 1:</label>
			<div class="flexDonate">
			  <div class="flexInputBox">
                <select name="itemDonate[]">
					<option value="Bread">Bread</option>
					<option value="Rice">Rice</option>
					<option value="Canned Food">Canned Food</option>
					<option value="Cooking Oil">Cooking Oil</option>
					<option value="Cereal">Cereal</option>
				</select>
				<?php if(!empty($itemError)){?>
				<p class="error" ><?php echo "$itemError";}?></p>
			  </div>
			  <div class="flexInputBox">
			     <input type="number" name="itemQty[]" placeholder="Quantity" min="1" oninput="quantityZero(event)"/>
				 <?php if(!empty($qtyError)){?>
				 <p class="error" ><?php echo "$qtyError";}?></p>
			 </div>	

			</div>
			  
			</div>
		</div>	
		
			 <!--button to add column-->
			<button id="add-food-item-btn">
			  <i class='fas fa-plus-circle' style='font-size:16px; margin-top:-4px;'></i> ADD
			</button>

			 <!--button to remove column-->
			<button id="remove-food-item-btn">
			  <i class="fas fa-minus-circle"></i>  REMOVE
			</button>
		

		<h3>Step 2: Pickup Detail</h3>
<!--Pickup date and time-->				
		<div class="flex">
            <div class="flexInputBox">
              <label>Pickup Date</label>
              <input type="date" id="date" name="date" />
			  <?php if(!empty($dateError)){?>
			  <p class="error" ><?php echo "$dateError";}?></p>
			</div>
		
			<div class="flexInputBox">
              <label>Pickup Time</label>
              <input type="time" id="time" name="time" value="" />
			  <?php if(!empty($timeError)){?>
			  <p class="error" ><?php echo "$timeError";}?></p>
			</div>	
		</div>
<!--Pickup Address-->					
        <div class="inputBox">
              <label>Pickup Address</label>
              <input type="text" placeholder="room - street - locality" name ="address" />
			  <?php if(!empty($addError)){?>
			  <p class="error" ><?php echo "$addError";}?></p>
        </div>
		
            
		<div class="inputBox">
              <label>City :</label>
              <input type="text" name="city" placeholder="Cheras" />
			  <?php if(!empty($cError)){?>
			  <p class="error" ><?php echo "$cError";}?></p> 
        </div>
	    
        <div class="flex">
              <div class="flexInputBox">
                <label>State :</label>
                <input type="text" placeholder="Kuala Lumpur" name="state" />
				<?php if(!empty($sError)){?>
				<p class="error" ><?php echo "$sError";}?></p>
              </div>
	    			  
              <div class="flexInputBox">
                <label>Postcode :</label>
                <input type="text" placeholder="56100" name="postcode" />
                <?php if(!empty($pError)){?>
				<p class="error" ><?php echo "$pError";}?></p>
			  </div>
		  
		</div>
			
          </div>
        </div>
<!--Submit button-->		
        <input type="submit" name="submit" value="DONATE NOW" class="submit-btn"/>
      </form>
    </div>	
  </body>
</html>







