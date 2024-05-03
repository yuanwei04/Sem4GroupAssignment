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
<link href="a-adminRqst.css" rel="stylesheet">
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
    <a href="?action=view">View Food Request</a>
    <a href="?action=viewitem">View Request Item</a>
    <a href="?action=accept">Accept Food Request</a>
    <a href="?action=reject">Reject Food Request</a>
</div>

<!-- Main content area -->
    <div class="main">
    <?php
    // Handle actions based on selected link
        if (isset($_GET['action'])) 
        {
            $action = $_GET['action'];

            switch($action)
            {
            
                case 'view':
            
                    echo '<h3 style="margin-bottom:5px;">Food Request Information:</h3>';
                    echo '<div class="search">';
                    echo '<form method="POST" action="">';
                    echo '<input type="text" name="valueSearch" placeholder="Search">';
                    echo '<button type="submit" name ="search" id="searchBtn"><i class="fa fa-search"></i></button>';
                    echo '</div>';

                    function filterTable($conn,$sql){
                        // Execute the SQL query and store the results in $filter_Result
                        $filter_Result = mysqli_query($conn,$sql);
                        $foodRequests=array();
                        if($filter_Result){
                            while ($row = mysqli_fetch_assoc($filter_Result)) {
                            $foodRequests[] = $row;
                            }
                        // Return the results of the query
                        return $foodRequests;
                        }
                    }

                    if(isset($_POST['search']))
                    {
                        $valueSearch = $_POST['valueSearch'];
                        $sql="SELECT * FROM fooddonation
                              WHERE CONCAT(`foodDonationID`,`accountID`,`contactNum`,`foodBankNo`,`address`,`status`)
                              LIKE '%$valueSearch%'";
                        
                        $foodRequests=filterTable($conn,$sql);
                    }else{
                        $sql="SELECT * FROM fooddonation";
                        $foodRequests=filterTable($conn,$sql);
                    }



                    echo '<table class="viewTable" border="1">';
    				echo '<tr><th>Food Donation ID</th><th>Account ID</th><th>Contact Number</th>
	                <th>FoodBank No</th><th>Address</th><th>Status</th><th>Action</th></tr>';

                    foreach ($foodRequests as $foodRequest)
                    {
                        echo '<tr>';
                        echo '<td>' . $foodRequest['foodDonationID'] . '</td>';
                        echo '<td>' . $foodRequest['accountID'] . '</td>';
                        echo '<td>' . $foodRequest['contactNum'] . '</td>';
                        echo '<td>' . $foodRequest['foodBankNo'] . '</td>';
                        echo '<td>' . $foodRequest['address'] . '</td>';
                        echo '<td>' . $foodRequest['status'] . '</td>';
                        echo '<td>
                                <a href="?action=viewitem&id='.$foodRequest['foodDonationID'].'">View</a> |
                                <a href="?action=accept&id='.$foodRequest['foodDonationID'].'">Accept</a> |
                                <a href="?action=reject&id='.$foodRequest['foodDonationID'].'">Reject</a>
                              </td>';   
                        echo '</tr>';                   

                    }
                    echo '</table>';

                    break;
                
                case 'viewitem':

                    if (!isset($_GET['id'])) 
                    {
                        echo '<p>Please choose a food request to edit</p>';
                        echo '<a href="?action=view">View Food Request</a>';
                    } 
                    else 
                    {
                        $foodRequestId = $_GET['id'];

                        echo '<div style="text-align:center;">';
                        echo '<h3 style="margin-right:50px;">Food Item Information</h3>';
                        // Function to retrieve a specific food bank by its ID
                        function getFoodItemById($conn,$foodRequest){
                            $sql="SELECT * FROM fooddonationitem a,fooditem b 
                                  WHERE a.foodItemID=b.foodItemID 
                                  AND a.foodDonationID='$foodRequest'";
                            $result=mysqli_query($conn,$sql);
                            $foodItems=array();
                            if($result){
                                while ($row = mysqli_fetch_assoc($result)){
                                    $foodItems[]=$row;
                                }
                            }
                            return $foodItems;
                        }
                        $foodItems=getFoodItemById($conn,$foodRequestId);

                        echo '<table class="viewTable food-content" border="1">';
                        echo '<tr><th>Food Donation ID</th><th>Food Item ID</th><th>Food Item</th><th>Quantity</th><tr>';
    
                        foreach ($foodItems as $foodItem)
                        {
                            echo '<tr>';
                            echo '<td>' . $foodItem['foodDonationID'] . '</td>';
                            echo '<td>' . $foodItem['foodItemID'] . '</td>';
                            echo '<td>' . $foodItem['name'] . '</td>';
                            echo '<td>' . $foodItem['quantity'] . '</td>';
                            echo '</tr>';                   
                        }
                        echo '</table>';

                        echo '<button id="returnBtn" onclick="window.location.href= `?action=view` ">RETURN</button>';
                        echo '</div>';
                    }
                    break;

                case 'accept':

                    if (!isset($_GET['id'])) 
                    {
                        echo '<p>Please choose a food request to accept</p>';
                        echo '<a href="?action=view">View Food Request</a>';
                    } 
                    else 
                    {
                        $foodRequestId = $_GET['id'];



                        function AcceptFoodRequest($conn,$foodRequest)
                        {
                            $sql="SELECT foodBankNo, foodItemID, quantity, status
                                  FROM fooddonation a,fooddonationitem b
                                  WHERE a.foodDonationID=b.foodDonationID
                                  AND b.foodDonationID = '$foodRequest'";
                            $result=mysqli_query($conn,$sql);
                
                            if($result)
                            {
                                while($row = mysqli_fetch_assoc($result)){
                                    $foodbankNo=$row['foodBankNo'];
                                    $foodItemID=$row['foodItemID'];
                                    $quantity=$row['quantity'];
                                    $status=$row['status'];

                                    if($status == 'pending'){
                                        $sql="INSERT INTO foodbankinventory(foodBankNo,foodItemID,quantity)
                                              VALUE ('$foodbankNo','$foodItemID','$quantity')";
                                        mysqli_query($conn,$sql);
                                    } 
                                }

                                if($status == 'pending'){
                                    $sql="UPDATE fooddonation SET status='accepted' WHERE foodDonationID='$foodRequest'";
                                    mysqli_query($conn,$sql);
                                    echo 'Food Request accept Successfully!';
                                }
                                else if($status == 'rejected'){
                                    echo 'Food request is cannot be accepted, it has already been rejected!';
                                }
                                else{
                                    echo 'Food Request is already accepted!';
                                }

                            }
                        }
                        AcceptFoodRequest($conn,$foodRequestId);
                    }
                    break;

                case 'reject':  

                    if (!isset($_GET['id'])) 
                    {
                        echo '<p>Please choose a food request to reject</p>';
                        echo '<a href="?action=view">View Food Request</a>';
                    } 
                    else 
                    {
                        $foodRequestId = $_GET['id'];

                        function RejectFoodRequest($conn,$foodRequest){
                        
                            $result=mysqli_query($conn,"SELECT * FROM fooddonation WHERE foodDonationID='$foodRequest'");
                            $row=mysqli_fetch_assoc($result);
                            $status=$row['status'];
                            
                            if($status == 'pending'){
                                $sql="UPDATE fooddonation SET status='rejected' WHERE foodDonationID='$foodRequest'";         
                                mysqli_query($conn,$sql);
                                echo 'Food Request Rejected Succesfully!';
                            }
                            else if($status == 'accepted'){
                                echo 'Food Request cannot be accepted, it has already been rejected!';
                            }
                            else{
                                echo 'Food Request is already rejected!';
                            }
                        }
                        RejectFoodRequest($conn,$foodRequestId);


                    }
       
            }

        }

    ?>
    </div>
</div>

</body>
</html>