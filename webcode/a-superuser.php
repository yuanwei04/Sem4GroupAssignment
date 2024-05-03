<!--Connect to Database-->
<?php
session_start();// Start session 
include 'a-DBconnect.php'; // Include database connection
// Retrieve superuser information from the session
$superuser = $_SESSION['superuser'];
$accountType =  $_SESSION['accountType'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Food Bank Website</title>
<link href="a-superuser.css" rel="stylesheet">

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
	<h2>Superuser Panel</h2>	
	<ul>
		<li><a href="a-superuser.php">Admin Details</a></li>
		<li><a href="?action=create">Create Admin</a></li>
		<li><a href="a-superprofile.php">
		<i class="fas fa-user-circle" style="font-size:23px;"></i></a>
			<div class="dropDown">
			<a href="a-superprofile.php" ><?=$accountType?>: <?=$superuser?></a>
			<a href="a-logout.php">Logout</a>
			</div>
		</li>
	</ul>
</div>
<?php
    if(isset($_SESSION['alert'])){
        echo '<script>alert("'.$_SESSION['alert'].'");</script>';
        unset($_SESSION['alert']);
    }

?>
<div class='main'>
<?php
$sql="SELECT * FROM account WHERE accountType='Admin'";
$admin_result = mysqli_query($conn,$sql);
?>
            <div class="table-container">          
            <table class='viewTable'>
                <h3>Admin Details Table</h3>
            <tr>
                <th>Admin ID</th>
                <th>Admin Email</th>
                <th>Admin Password</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
<?php
            while($row = mysqli_fetch_array($admin_result)):
                $adminID=$row['accountID'];
                $adminEmail=$row['email'];
                $adminPass=$row['password'];

?>
            <tr>
                <td><?php echo $adminID?></td>
                <td><?php echo $adminEmail?></td>
                <td><?php echo $adminPass?></td>
                <td><a href="a-superuser.php?action=edit&eid=<?=$adminID?>">EDIT</td>
                <td><a href="a-superuser.php?action=delete&did=<?=$adminID?>">DELETE</td>
            </tr>
<?php       endwhile;?>
            </table>
            </div>

<?php
if(isset($_GET['action']))
{
    $action=$_GET['action'];

    switch($action)
    {
        case 'create':
            $error="";
            if(isset($_POST['createAdmin']))
            {
                if(isset($_POST['adminID'])){
                    $adminID=$_POST['adminID'];
                }
            
                if(!empty($_POST['adminEmail'])){
                    $adminEmail=$_POST['adminEmail'];
                }
            
                if(!empty($_POST['adminPassword'])){
                    $adminPassword=$_POST['adminPassword'];
                }
            
                if(isset($adminID) && isset($adminEmail) && isset($adminPassword))
                {
                    $result1=mysqli_query($conn,"SELECT * FROM account WHERE accountID='$adminID'");
                    $result2=mysqli_query($conn,"SELECT * FROM account WHERE email='$adminEmail'");
                    if(mysqli_num_rows($result1) > 0){
                       $error="AdminID is already Used";
                       $adminID="";
                    }
                    else if(mysqli_num_rows($result2)){
                        $error="Admin Email is already Used";
                        $adminEmail="";
                    }
                    else{
                        $sql="INSERT INTO account(accountID,email,password,accountType) VALUES ('$adminID','$adminEmail','$adminPassword','admin')";
                        $result=mysqli_query($conn,$sql);
                       if($result) {
                            $_SESSION['alert']="Admin Create Successfully";
                            header ("Location:a-superuser.php");
                        }
                    }
                }else{
                    $error="Date must be set";
                }
            }

?>

                <!---Create Admin Form-->
                <h3 style="text-align:center; margin-top:40px;">Create Admin Account Form</h3>

                <form class="formDesign" action="?action=create" method="post">
                AdminID:
                <input type="text" name="adminID"><br>
                Admin Email (For Login):
                <input type="text" name="adminEmail"><br>
                Admin Password:
                <input type="password" name="adminPassword">
                <br>
                <?php if(!empty($error)){?>
                <p class="warning"><?=$error?></p>
                <?php }?>
                <input type="submit" name="createAdmin" value="Create">
                </form>

                
<?php
            break;

        case 'edit':
            $error="";
            if(isset($_GET['eid'])){
                $adminID=$_GET['eid'];
               
                $sql="SELECT * FROM account WHERE accountID='$adminID' ";
                $edit_result=mysqli_query($conn,$sql);
            
                if($row=mysqli_fetch_assoc($edit_result)){
                    $adminID=$row['accountID'];
                    $adminEmail=$row['email'];
                    $adminPass=$row['password'];
                  }
                  else
                    $_SESSION['alert'] = "User not found!";
            }

            if (isset($_POST['updateAdmin'])){

                $adminID=$_POST['editAdmin'];
                if(!empty($_POST['editEmail'])){
                    $editEmail=$_POST['editEmail'];	
                }

                if(!empty($_POST['editPass'])){
                    $editPass=$_POST['editPass'];	
                }


                if(isset($adminID) && isset($editEmail) && isset($editPass))
                {
                    $sql=" UPDATE account SET email='$editEmail', password='$editPass' WHERE accountID = '$adminID' ";             
                    $result=mysqli_query($conn,$sql);

                    if($result){                
                        $_SESSION['alert']="Update Admin Successfully";               
                        header("Location:a-superuser.php");               
                    }             
                    else{              
                        $_SESSION['alert']="Admin Data Updated Fail!";             
                    }
                }
                else{
                    $error="Edit Data must be set";
                }

            } 
?>
            <!--Edit Admin Form-->
            <h3 style="text-align:center; margin-top:40px;">Edit Admin Form</h3>
            <form class="formDesign"action="?action=edit" method="post">
            Admin ID:
            <input type="text" name="editAdmin" value="<?=$adminID?>" readOnly><br>
            Email:<br>
            <input type="text" name="editEmail" value="<?=$adminEmail?>" placeholder="Edit Email"><br>
            Password:<br>
            <input type="text" name="editPass" value="<?=$adminPass?>" placeholder="Edit Password"><br>
            <?php if(!empty($error)){?>
            <p class="warning"><?=$error?></p>
            <?php }?>
            <input type="submit" name="updateAdmin" value="Update">
            </form>
<?php
            break;

        case 'delete':
            
            if(isset($_GET['did'])){
                $adminID=$_GET['did'];
                $sql="DELETE FROM account WHERE accountID='$adminID' "; 
                $delete_admin = mysqli_query($conn,$sql);
                if($delete_admin){
                    $_SESSION['alert']= "Delete Admin Successfully!";
                    header("Location:a-superuser.php");
                }
            }
?>

<?php
    }
}
?>
</div>
</body>
</html>


