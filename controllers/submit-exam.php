<?php
// header("location: ../index.php");
ini_set("display_errors", 1); // Display errors
require_once '../helpers/connect.php';

// Can be a modal that redirects to result page
// echo var_dump($_POST);
// echo var_dump($_POST['correct_answer[1]']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    $studentId = $_POST['studentId'];
    $examId = $_POST['examId'];
    $submitTime = $_POST['submitTime'];
    $noOfQuestions = $_POST['noOfQuestions'];

    foreach ($_POST['answer'] as $index => $answer) {
        // echo $index . " : " . $answer . "<br>";
        // echo "Correct Answer:" . $_POST['correct_answer'][$index] . "";
        // echo "<br><br><br>";

        if (trim($answer) === trim($_POST['correct_answer'][$index])) {
            $score++;
        }
    }

    echo "<h1> Your Score is: " . $score . "</h1>";
    $sql = "INSERT INTO Student_Result VALUES ($studentId, $examId, $score, $noOfQuestions, '$submitTime') ON DUPLICATE KEY UPDATE score=$score, submitTime='$submitTime';";
    echo $sql;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "There was an error processing your result: " . mysqli_error($conn);
        // die('Connect Error: ' . mysqli_connect_error());
        // header("location: ../index.php");

    } else {
        header("location: ../index.php#results");
    }
    ;
}