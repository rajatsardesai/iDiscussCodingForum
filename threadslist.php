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
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE `category_id`=$id";
    $result=mysqli_query($conn,$sql);
    // use a for loop to iterate through categories
    while ($row=mysqli_fetch_assoc($result)) {
        $catName=$row['category_name'];
        $catDesc=$row['category_description'];
    }
    ?>

    <!-- insert threads into db -->
    <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if ($method=='POST') {
        //insert therad into db
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        //string replacement
        $bodytag = str_replace("<", "&lt", $th_title);
        $bodytag = str_replace(">", "&gt", $th_title);
        $bodytag = str_replace("<", "&lt", $th_desc);
        $bodytag = str_replace(">", "&gt", $th_desc);
        $sno=$_POST['userid'];
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_user_id`, `thread_cat_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$sno', '$id', current_timestamp());";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }
    ?>

    <!-- jumbotron for thread -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catName ?></h1>
            <p class="lead"><?php echo $catDesc ?></p>
            <hr class="my-4">
            <p><ul>
                <li>No Spam / Advertising / Self-promote in the forums. ...</li>
                <li>Do not post copyright-infringing material. ...</li>
                <li>Do not post “offensive” posts, links or images. ...</li>
                <li>Do not cross post questions. ...</li>
                <li>Remain respectful of other members at all times.</li>
                </ul></p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <!-- start a discussion login details -->
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container my-4">
    <h1 class="py-2">Start a discussion</h1>
    <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">Keep your title short and crisp as possible.</small>
    </div>
    <input type="hidden" name="userid" value="'. $_SESSION['userid'] .'">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Start a discussion</h1>
            <div class="alert alert-dark" role="alert">
                Please login to ask a question.
            </div>
        </div>';
            
    }

    ?>

    <!-- threads count -->
    <div class="container">
        <h1 class="py-3">Browse Question</h1>
        <?php
        $id=$_GET['catid'];
        $sql="SELECT * FROM `threads` WHERE `thread_cat_id`=$id LIMIT 10";
        $result=mysqli_query($conn,$sql);
        $noResult=true;
        // use a for loop to iterate through categories
        while ($row=mysqli_fetch_assoc($result)) {
            $noResult=false;
            $id=$row['thread_id'];
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $time=$row['timestamp'];
            $thread_user_id=$row['thread_user_id'];
            $sql2="SELECT `user_email` FROM `users` WHERE `sno`=$thread_user_id";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);

        echo '
        <div class="media my-3 py-3">
            <img src="img/user.jpg" width="64px" height="64px" class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='. $id .'">'. $title .'</a></h5>
                '. $desc .'
            </div>
            <p class="font-weight-bold my-0">'. $row2['user_email'] .' at '. $time .'</p>
        </div>
        <hr>';
        }
        // echo var_dump($noResult);
        if ($noResult) {
            echo '
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Threads Found</p>
                    <p class="lead"><b>Be the first person to ask a question</b></p>
                </div>
            </div>';
        }
        ?>
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

</html>