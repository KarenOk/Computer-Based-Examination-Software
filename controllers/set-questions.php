<?php
include "../helpers/connect.php";

// question,option1,option2,option3,option4,option5,answer,examId

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo var_dump($_POST);
    echo "<br> <br>";

    $question = $_POST["question"];
    $option1 = $_POST["option-1"];
    $option2 = $_POST["option-2"];
    $option3 = $_POST["option-3"];
    $option4 = $_POST["option-4"];
    $option5 = $_POST["option-5"];
    $correct_option = $_POST["correct-answer"];
    $examId = $_POST["examId"];

    echo $_POST[$correct_option];
    echo "<br>";

    $sql = "INSERT INTO Question (question, option1, option2, option3, option4, option5, answer, examId) VALUES
            ('$question', '$option1', '$option2', '$option3', '$option4', '$option5', '$_POST[$correct_option]', '$examId')
        ";

    echo $sql;

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: ../views/manage-exam.php?examid=$examId");
    } else {
        echo "An error occured: ";
        echo mysqli_connect_error($result);
    }
}