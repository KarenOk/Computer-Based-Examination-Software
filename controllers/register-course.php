<?php
include "../helpers/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseTitle = $_POST["ctitle"];
    $courseCode = $_POST["ccode"];

    $sql = " INSERT INTO Course (courseTitle, courseCode) VALUES ('$courseTitle', '$courseCode')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: ../index.php");
    } else {
        echo "There was an error registering this course";
    }

}