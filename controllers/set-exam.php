<?php
include "../helpers/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo var_dump($_POST);
    echo "<br> <br>";

    $edit = $_POST["edit"];
    $instruction = $_POST["instruction"];
    $durationHr = $_POST["duration-hr"];
    $durationMin = $_POST["duration-min"];
    $durationSec = $_POST["duration-sec"];
    $duration = $durationHr . ":" . $durationMin . ":" . $durationSec;
    $activated = $_POST["activated"];
    $lastModified = $_POST["lastModified"];

    if ($edit) {
        // If you're updating an already existing exam
        $examId = $_POST["examId"];
        $sql = "UPDATE Exam
        SET
            instruction='$instruction',
            timeDuration = '$duration',
            activated = '$activated',
            lastModified = '$lastModified'
        WHERE
            examId = '$examId'
        ";

    } else {
        // If you're creating a new exam
        $courseId = $_POST["courseId"];
        $createdAt = $_POST["createdAt"];

        $sql = "INSERT INTO Exam (instruction, timeDuration, activated, createdAt, lastModified, courseId ) VALUES
            ('$instruction', '$duration', '$activated', '$createdAt', '$lastModified', '$courseId')
        ";

    }

    echo $sql;
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: ../index.php");
    } else {
        echo "An error occured: ";
        echo mysqli_connect_error($result);
    }
}