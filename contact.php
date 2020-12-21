<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>iDiscuss-Coding Forum</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>

    <!-- sql to add contact to database -->
    <?php
        $showError=false;
        $showAlert=false;
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            include 'partials/_dbconnect.php';
            $name=$_POST['name'];
            $email=$_POST['email'];
            $contact=$_POST['contact'];
            $message=$_POST['message'];

            $bodytag = str_replace("<", "&lt", $name);
            $bodytag = str_replace(">", "&gt", $name);
            $bodytag = str_replace("<", "&lt", $email);
            $bodytag = str_replace(">", "&gt", $email);
            $bodytag = str_replace("<", "&lt", $contact);
            $bodytag = str_replace(">", "&gt", $contact);
            $bodytag = str_replace("<", "&lt", $message);
            $bodytag = str_replace(">", "&gt", $message);

            // check if email already exists
            $existsSql="SELECT * FROM `contact` WHERE `contact_email`='$email'";
            $result=mysqli_query($conn,$existsSql);
            $numRows=mysqli_num_rows($result);
            if ($numRows>0) {
                $showError="Email already exists";
            }
            else{
                $sql="INSERT INTO `contact` (`contact_name`, `contact_email`, `contact_number`, `contact_desc`, `timestamp`) VALUES ('$name', '$email', '$contact', '$message', current_timestamp())
                ";
                $result=mysqli_query($conn,$sql);
                if ($result) {
                    $showAlert=true;
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> We\'ll soon get in touch with you.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
            }
        }
    ?>


    <!-- form starts here -->
    <div class="container">
        <h1 class="text-center my-3">Contact Us</h1>
        <form action="contact.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                <div class="invalid-feedback">Please enter valid name.</div>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
                <div class="invalid-feedback">Please enter valid email.</div>
            </div>
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" id="contact" name="contact"
                    placeholder="Enter your contact number" maxlength="10">
                <div class="invalid-feedback">Please enter valid contact number.</div>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                <div class="invalid-feedback">Please enter valid message.</div>
            </div>
            <button class="btn btn-success" id="submit">Submit</button>
        </form>
    </div>

    <!-- footer -->
    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

</body>

<script src="js/index.js"></script>

</html>