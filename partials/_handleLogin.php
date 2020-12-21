<?php

$showError=false;
$showAlert=false;
if ($_SERVER['REQUEST_METHOD']=="POST") {
    include '_dbconnect.php';
    $useremail=$_POST['loginEmail'];
    $pass=$_POST['loginPass'];

    //check if email exists
    $sql="SELECT * FROM `users` WHERE `user_email`='$useremail'";
    $result=mysqli_query($conn,$sql);
    $numRows=mysqli_num_rows($result);
    if ($numRows==1) {
        $row=mysqli_fetch_assoc($result);
        if (password_verify($pass,$row['user_pass'])) {
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['userid']=$row['sno'];
            $_SESSION['useremail']=$useremail;
            echo "logged in" .$useremail;
        }
        header("location:/forum/index.php");
    }
    header("location:/forum/index.php");
}

?>