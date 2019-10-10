<?php
session_start();

if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header("location: views/login.php");
    exit;
}

include "helpers/connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="shortcut icon" href="assets/images/unilag-logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body id="index-page">
    <?php
if ($_SESSION["usertype"] === "Administrator") {
    echo (include "views/admin_home.php");
} elseif ($_SESSION["usertype"] === "Examiner") {
    include "views/examiner_home.php";
} elseif ($_SESSION["usertype"] === "Student") {
    include "views/student_home.php";
}
?>

    <button style="background-color: black; width: 6em;"> <a href="process/logout.php"
            style="margin: 5px; color:white;"> Logout </a> </button>
</body>

</html>