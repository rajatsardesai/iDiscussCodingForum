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

    <?php include 'partials/_dbconnect.php'; ?>

    <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE `thread_id`=$id";
    $result=mysqli_query($conn,$sql);
    // use a for loop to iterate through categories
    while ($row=mysqli_fetch_assoc($result)) {
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];

        //query the users table to get name of OP
        $sql2="SELECT `user_email` FROM `users` WHERE `sno`=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
    }
    ?>

    <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if ($method=='POST') {
        //insert comment into db
        $comment=$_POST['comment'];
        //string replacement
        $bodytag = str_replace("<", "&lt", $comment);
        $bodytag = str_replace(">", "&gt", $comment);
        $sno=$_POST['userid'];
        $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', current_timestamp(), '$sno')";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been added.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title ?></h1>
            <p class="lead"><?php echo $desc ?></p>
            <hr class="my-4">
            <p><ul>
                <li>No Spam / Advertising / Self-promote in the forums. ...</li>
                <li>Do not post copyright-infringing material. ...</li>
                <li>Do not post “offensive” posts, links or images. ...</li>
                <li>Do not cross post questions. ...</li>
                <li>Remain respectful of other members at all times.</li>
                </ul></p>
            <p>Posted By <em><b><?php echo $posted_by?></b></em></p>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container my-4">
        <h1 class="py-2">Post a Comment</h1>
        <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="userid" value="'. $_SESSION['userid'] .'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Post a Comment</h1>
            <div class="alert alert-dark" role="alert">
                Please login to comment.
            </div>
        </div>';
            
    }
    ?>

    <div class="container my-4">
        <h1>Discussions</h1>

        <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `comments` WHERE `thread_id`=$id";
    $result=mysqli_query($conn,$sql);
    $noResult=true;
    // use a for loop to iterate through categories
    while ($row=mysqli_fetch_assoc($result)) {
        $noResult=false;
        $id=$row['comment_id'];
        $content=$row['comment_content'];
        $comment_time=$row['comment_time'];
        $comment_by=$row['comment_by'];
        $sql2="SELECT `user_email` FROM `users` WHERE `sno`=$comment_by";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);

    echo '
    <div class="media my-4 py-3">
        <img src="img/user.jpg" width="64px" height="64px" class="mr-3" alt="...">
        <div class="media-body">
        <p class="font-weight-bold my-0">'. $row2['user_email'] .'  at '. $comment_time .'</p>
            '. $content .'
        </div>
    </div>
    <hr>';
    }
    // echo var_dump($noResult);
    if ($noResult) {
        echo '
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <p class="display-4">No Comments Found.</p>
                <p class="lead"><b>Be the first person to comment.</b></p>
            </div>
        </div>';
    }
    ?>
    </div>


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

</html>