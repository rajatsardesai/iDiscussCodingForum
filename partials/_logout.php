<?php
session_start();
session_destroy();
header("location:/forum/index.php");
?>