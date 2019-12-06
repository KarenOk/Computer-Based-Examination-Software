<?php
include "../helpers/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo var_dump($_POST);
    // echo "<br> <br>";

    $usertype = $_POST["user-type"];
    $username = $_POST["username"];
    $firstName = $_POST["fname"];
    $lastName = $_POST["lname"];
    $imageUrl = $_POST["img-url"];
    $gender = $_POST["user-gender"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password !== $cpassword) {
        die("Password and Confirm Password don't match.");
    }

    if ($usertype === "administrator") {
        $sql = " INSERT INTO Administrator (username, firstName, lastName, imageUrl, pw) VALUES ('$username', '$firstName', '$lastName', '$imageUrl', '$hashed_password')";

    } else if ($usertype === "examiner") {
        $sql = " INSERT INTO Examiner (username, firstName, lastName, imageUrl, gender, pw) VALUES ('$username', '$firstName', '$lastName', '$imageUrl', '$gender', '$hashed_password')";

    } else if ($usertype === "student") {
        $sql = " INSERT INTO Student (username, firstName, lastName, imageUrl, gender, pw) VALUES ('$username', '$firstName', '$lastName', '$imageUrl', '$gender', '$hashed_password')";

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