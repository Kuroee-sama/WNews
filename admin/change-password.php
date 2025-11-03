<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
//Current Password hashing 
$password=$_POST['password'];
$options = ['cost' => 12];
$hashedpass=password_hash($password, PASSWORD_BCRYPT, $options);
$adminid=$_SESSION['login'];
// new password hashing 
$newpassword=$_POST['newpassword'];
$newhashedpass=password_hash($newpassword, PASSWORD_BCRYPT, $options);

date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
$sql=mysqli_query($con,"SELECT AdminPassword FROM  tbladmin where AdminUserName='$adminid' || AdminEmailId='$adminid'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $dbpassword=$num['AdminPassword'];

if (password_verify($password, $dbpassword)) {

 $con=mysqli_query($con,"update tbladmin set AdminPassword='$newhashedpass', updationDate='$currentTime' where AdminUserName='$adminid'");
$msg="Password Changed Successfully !!";
}
}
else
{
$error="Old Password not match !!";
}
}
?>




<?php include('includes/topheader.php');?>
<!-- Top Bar End -->

<script type="text/javascript">
function valid() {
    if (document.chngpwd.password.value == "") {
        alert("Current Password Filed is Empty !!");
        document.chngpwd.password.focus();
        return false;
    } else if (document.chngpwd.newpassword.value == "") {
        alert("New Password Filed is Empty !!");
        document.chngpwd.newpassword.focus();
        return false;
    } else if (document.chngpwd.confirmpassword.value == "") {
        alert("Confirm Password Filed is Empty !!");
        document.chngpwd.confirmpassword.focus();
        return false;
    } else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("Password and Confirm Password Field do not match  !!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>
