<?php
session_start();// Start session 
include('a-DBconnect.php'); // Include database connection


if (isset($_POST['update'])){

    $accountID=$_POST['accountID'];
    $name=$_POST['name'];	
    $age=$_POST['age'];
    $email=$_POST['email'];	
    $password=$_POST['password'];

        $sql=" UPDATE account 
   	    SET name='$name', age=$age, email='$email', password='$password' 
	    WHERE accountID = '$accountID' ";

        $result=mysqli_query($conn,$sql);
        if($result){
           echo "Data Updated Successful!";
           header("Location:a-admin.php");
        }
        else{
           echo "Data Updated Fail!";
        }


}    
mysqli_close($conn);
?>