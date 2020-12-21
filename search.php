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



    <!-- search results -->
    <div class="container my-3">
        <h1 class="py-2">Search results for <?php echo $_GET['search']?> </h1>
        <?php
        $noResults=true;
        $query=$_GET['search'];
        $sql="SELECT * FROM `threads` WHERE MATCH (`thread_title`,`thread_desc`) against ('$query')";
        $result=mysqli_query($conn,$sql);
        // use a for loop to iterate through categories
        while ($row=mysqli_fetch_assoc($result)) {
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_id=$row['thread_id'];
            $url="thread.php?threadid=".$thread_id;
            echo '<div class="result"></div>
                    <h3><a href="'. $url .'" class="text-dark"> '. $title .'</a></h3>
                    <p>'. $desc .'</p>
                    </div>';
            $noResults=false;
        }
        if ($noResults) {
            echo '<div class="container my-4">
            <h1>Discussions</h1>
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Results Found.</p>
                    <p class="lead"><b>Suggestions:<ul>
                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</b></p></li></ul>
                </div>
            </div>    
            </div>';
        }

    ?>

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