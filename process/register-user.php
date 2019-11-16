<?php
include "../helpers/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo var_dump($_POST);
    // echo "<br> <br>";

    $usertype = $_POST["user-type"];
    $username = $_POST["username"];
    $firstName = $_POST["fname"];
    $LastName = $_POST["lname"];
    $imageUrl = $_POST["img-url"];
    $gender = $_POST["user-gender"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if ($password !== $cpassword) {
        die("Password and Confirm Password don't match.");
    }

    if ($usertype === "administrator") {
        $sql = " INSERT INTO Administrator (username, firstName, LastName, imageUrl, pw) VALUES ('$username', '$firstName', '$LastName', '$imageUrl', '$password')";

    } else if ($usertype === "examiner") {
        $sql = " INSERT INTO Examiner (username, firstName, LastName, imageUrl, gender, pw) VALUES ('$username', '$firstName', '$LastName', '$imageUrl', '$gender', '$password')";

    } else if ($usertype === "student") {
        $sql = " INSERT INTO Student (username, firstName, LastName, imageUrl, gender, pw) VALUES ('$username', '$firstName', '$LastName', '$imageUrl', '$gender', '$password')";

    }

    $result = mysqli_query($conn, $sql);

    // echo $sql;
    // echo "<br> <br>";

    if ($result) {
        header("location: ../index.php");
    } else {
        echo "There was an error registering this user";
        echo mysqli_connect_error($result);
    }
}