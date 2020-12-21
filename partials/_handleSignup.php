<?php

$showError=false;
$showAlert=false;
if ($_SERVER['REQUEST_METHOD']=="POST") {
    include '_dbconnect.php';
    $useremail=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];

    //check if email exists
    $existsSql="SELECT * FROM `users` WHERE `user_email`='$useremail'";
    $result=mysqli_query($conn,$existsSql);
    $numRows=mysqli_num_rows($result);
    if ($numRows>0) {
        $showError="Email already exists";
    }
    else{
        if ($pass==$cpass) {
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ('$useremail', '$hash', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if ($result) {
                $showAlert=true;
                header("location:/forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError="Password do not match";
        }
    }
    header("location:/forum/index.php?signupsuccess=false&error=$showError");
}

?>