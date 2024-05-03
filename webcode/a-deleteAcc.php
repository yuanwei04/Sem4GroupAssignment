<?php
session_start();
include 'a-DBconnect.php';

 if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    // Delete related records in child table "fooddonationitem"
    $deleteFoodDonationItemsQuery = "DELETE FROM fooddonationitem WHERE foodDonationID IN 
        (SELECT foodDonationID FROM fooddonation WHERE accountID='$userid')";
    mysqli_query($conn, $deleteFoodDonationItemsQuery);
    
    // Delete related records in child table "fooddonation"
    $deleteFoodDonationsQuery = "DELETE FROM fooddonation WHERE accountID='$userid'";
    mysqli_query($conn, $deleteFoodDonationsQuery);
    
    // Delete the account
    $deleteAccountQuery = "DELETE FROM account WHERE accountID='$userid'";
    mysqli_query($conn, $deleteAccountQuery);
    
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: a-login.php");
    exit();
 } 
 else {
    header("Location: a-login.php");
    exit();
 }

mysqli_close($conn);
?>


