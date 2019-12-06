<!-- TODO: restrict anyhow movement  -->

<!-- TODO: Cache exam page with service workers  -->


<?php
session_start();
ini_set("display_errors", 1); // Display errors

// To setup database connection
require_once '../helpers/connect.php';
$username = $_SESSION["username"];

// Get exam id from url
$url_parts = parse_url($_SERVER['REQUEST_URI']);
parse_str($url_parts['query'], $url_query);
$examid = $url_query['examid'];

// Get details about the exam
$sql = "SELECT instruction, timeDuration, courseCode, courseTitle
    FROM Exam e, Course_Student cs, Course c
    WHERE cs.username='$username' and cs.courseId=e.courseId and e.examId='$examid' and c.courseId=e.courseId
    LIMIT 1
    ";

$queryResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($queryResult) != 0) {
    mysqli_data_seek($queryResult, 0);
    $exam = mysqli_fetch_object($queryResult);
} else {
    // If there are no results, then the student shouldn't be taking the exam. Redirect.
    header("location: ../index.php");
}

// Get Questions
$sql = "
    SELECT *
    FROM Question q
    WHERE q.examId=$examid
    ";
$questionsResult = mysqli_query($conn, $sql);
?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link rel="stylesheet" href="../assets/css/take-exam.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body id="exam">
    <div class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> University <br> of <br> Lagos </h1>
            </div>

            <div class="timer">
                <span class="duration">
                    <?php echo $exam->timeDuration; ?>
                </span> remaining
            </div>


            <!-- TODO: Shuffle Question -->

            <ul class="question-no-list">
                <!-- Loop through questions and count -->
                <?php
$i = 1;
while ($i <= mysqli_num_rows($questionsResult)) {
    if ($i == 1) {
        echo "<li class='question-no active' data-questionNo='$i' onclick=showQuestion($i)> $i </li>";
    } else {
        echo "<li class='question-no' data-questionNo='$i' onclick=showQuestion($i)> $i </li>";
    }
    $i++;
}
;

mysqli_data_seek($questionsResult, 0);

?>
            </ul>

            <div class="submit text-center">
                <button class="btn btn-lg" form="examForm" onclick="return ConfirmSubmit()">
                    Submit
                </button>
            </div>

        </nav>


        <!-- Main Content-->
        <main>
            <!-- Home Tab -->
            <section class="tab instructions show" id="instructions">

                <div class="tab-flex-cont">

                    <div class="tab-content">
                        <p class="instruction"> <?php echo $exam->instruction; ?> </p>
                        <p> Exam Duration:
                            <span class="duration"> <?php echo $exam->timeDuration; ?> </span>
                        </p>
                        <button class="start-exam" onclick="showQuestion(1)"> Start <span> &#x25b6; </span> </button>
                    </div>

                </div>

            </section>

            <!-- Exams Tab  -->
            <section class="tab questions" id="questions">

                <div class="tab-flex-cont">

                    <div class="tab-content">
                        <header>
                            <div class="headings">
                                <h1> <?php echo $exam->courseCode; ?> </h1>
                                <h2> <?php echo $exam->courseTitle ?> </h2>
                            </div>
                            <div id="clockbox"></div>
                        </header>


                        <form method="POST" action="../controllers/submit-exam.php" id="examForm">

                            <?php
$i = 0;

$questionsArr = array();
while ($row = mysqli_fetch_array($questionsResult)) {
    $questionsArr[] = $row;
}
$shuf = shuffle($questionsArr);

foreach ($questionsArr as $question) {

    $ques = $question['question'];
    $quesId = $question['questionId'];
    $option1 = $question['option1'];
    $option2 = $question['option2'];
    $option3 = $question['option3'];
    $option4 = $question['option4'];
    $option5 = $question['option5'];
    $answer = $question['answer'];

    $i++;
    ?>

                            <section class="question-cont">
                                <span> Q<?php echo $i ?>: </span>
                                <label class="question"> <?php echo stripcslashes($ques) ?> </label>
                                <section class="options-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="answer[<?php echo $quesId ?>]"
                                                value=' <?php echo stripcslashes($option1) ?> '> A:
                                            <?php echo stripcslashes($option1); ?>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="answer[<?php echo $quesId ?>]" value=' <?php echo $option2 ?> '>
                                            B:
                                            <?php echo stripcslashes($option2) ?>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="answer[<?php echo $quesId ?>]" value=' <?php echo $option3 ?> '>
                                            C:
                                            <?php echo stripcslashes($option3) ?>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="answer[<?php echo $quesId ?>]" value=' <?php echo $option4 ?> '>
                                            D:
                                            <?php echo stripcslashes($option4) ?>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="answer[<?php echo $quesId ?>]" value=' <?php echo $option5 ?> '>
                                            E:
                                            <?php echo stripcslashes($option5) ?>
                                        </label>
                                    </div>

                                    <input type="hidden" name="correct_answer[<?php echo $quesId ?>]"
                                        value='<?php echo $answer ?>' />

                                </section>
                            </section>
                            <?php
}
;
?>
                            <input type="hidden" name="examId" value='<?php echo $examid ?>' />
                            <input type="hidden" name="studentId" value='<?php echo $username ?>' />
                            <input type="hidden" name="noOfQuestions" value='<?php echo $i ?>' />
                            <input type="hidden" name="submitTime" />


                            <section class="question-control">
                                <button type="button" class="btn" onclick="nav(-1)"> &laquo; Previous </button>
                                <button type="button" class="btn" onclick="nav(1)"> Next &raquo; </button>

                            </section>

                        </form>

                    </div>

                </div>

            </section>

        </main>





    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>



    <script>
    let started = false;
    var answers;
    var inputs = document.querySelectorAll(".question-cont input[type='radio']");
    var studentId = document.querySelector("input[name='studentId']").value;
    var examId = document.querySelector("input[name='examId']").value;
    var store = `exam-${studentId}-${examId}`;
    var timeStore = `time-${studentId}-${examId}`;


    // Define what happens when page loads
    $(document).ready(function() {
        $(".menu").on("click", function() {
            $('#sidebar').toggleClass('active');
            $('main').toggleClass('active');
        })

        console.log("Loaded!");
        // Check if the storage object exists
        if (localStorage[store]) {
            document.querySelector(".start-exam").innerHTML = "RESUME <span> &#x25b6; </span>";
            restoreForm();
        } else {
            answers = new Array(inputs.length).fill(null);
        }

    });


    // Restore form values on resume
    function restoreForm() {
        var restoredAnswers = JSON.parse(localStorage.getItem(store));
        answers = restoredAnswers;

        // Replace time with remaining time
        timeLeft = localStorage.getItem(timeStore);
        document.querySelector(".timer .duration").innerText = localStorage.getItem(timeStore);
        document.querySelector(".instructions .duration").innerText = timeLeft;
        duration = timeLeft;
        splitDuration = duration.split(":");
        durationHour = Number(splitDuration[0]);
        durationMin = Number(splitDuration[1]);
        durationSec = Number(splitDuration[2]);


        var counter = 0;

        inputs.forEach((elem) => {
            if (elem.type === "radio") {
                elem.checked = restoredAnswers[counter];
                counter++;
            }
        });

    }

    // Add event listener that updates storage on change
    inputs.forEach((elem, index) => {
        addEventListener('change', () => {
            if (elem.type === "radio") {
                answers[index] = elem.checked;
                localStorage.setItem(store, JSON.stringify(answers));
            }

        });
    });

    // After clicking Start, remove Instructions
    $(".start-exam").on("click", function(event) {
        $(`.tab.instructions`).removeClass("show");
        $(`.tab.questions`).addClass("show");
        started = true;
        countDown = window.setInterval(timer, 1001);
    });


    $("#sidebar li").on("click", function(event) {

        // After clicking any question number, remove exam instructions
        if (started === false) {
            $(`.tab.instructions`).removeClass("show");
            $(`.tab.questions`).addClass("show");
            started = true;
            countDown = window.setInterval(timer, 1001);
        };

    });

    let questionContainers = document.querySelectorAll(".question-cont");
    let questionNavList = document.querySelectorAll(".question-no-list li");
    let questionControls = document.querySelectorAll(".question-control .btn");
    let currentQuestion = 0;


    function showQuestion(i) {
        questionContainers.forEach(elem => {
            elem.classList.remove("show");
        })

        questionNavList.forEach(elem => {
            elem.classList.remove("active");
        });

        questionContainers[i - 1].classList.add("show");
        questionNavList[i - 1].classList.add("active");

        currentQuestion = i - 1;

        // Check boundaries of prev and next buttons
        questionControls[0].disabled = (currentQuestion === 0) ? true : false;
        questionControls[1].disabled = (currentQuestion >= questionNavList.length - 1) ? true : false;
    }

    function nav(offset) {
        if (currentQuestion + offset >= 0 && currentQuestion + offset < questionNavList.length) {
            showQuestion(currentQuestion + offset + 1); // 1 is added to account for the -1 in showQuestion function
        };
    };

    let countDown;
    let durationElem = document.querySelector(".timer .duration");
    let duration = durationElem.innerText;
    let splitDuration = duration.split(":");
    let durationHour = Number(splitDuration[0]);
    let durationMin = Number(splitDuration[1]);
    let durationSec = Number(splitDuration[2]);


    function timer() {
        if (durationSec === 0) {
            durationSec = 59;
            if (durationMin === 0) {
                durationMin = 59
                durationHour--;
            } else {
                durationMin--;
            }
        } else {
            durationSec--;
        }

        // Hours is only padded if its a single digit
        duration = (String(durationHour).length < 2 ? padNo(durationHour, 2) : durationHour) + ":" + padNo(
            durationMin, 2) + ":" + padNo(durationSec, 2);
        durationElem.innerText = duration;

        localStorage.setItem(timeStore, duration);
        localStorage.setItem(store, JSON.stringify(answers));


        // Stop at 00:00:00
        if (durationSec === 0 && durationMin === 0 && durationHour === 0) {
            window.clearInterval(countDown);

            let submitTime = (new Date()).toISOString().slice(0, 19).replace('T', ' ');
            document.querySelector('input[name="submitTime"').value = submitTime;
            document.getElementById("examForm").submit();
        }
    }

    // Function to pad numbers
    function padNo(num, size) {
        numStr = String(num)
        if (numStr.length < size) {
            while (numStr.length < size) {
                numStr = "0" + numStr
            }
        }
        return numStr;
    }


    function ConfirmSubmit() {
        let submitTime = (new Date()).toISOString().slice(0, 19).replace('T', ' ');
        document.querySelector('input[name="submitTime"]').value = submitTime;

        if (!confirm("Are you sure you want to submit?")) {
            return false;
        }

        // Clear local storage on submit
        localStorage.removeItem(store);
        localStorage.removeItem(timeStore);
    }

    // TODO: Put this in a separate file

    var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
        "November", "December"
    ];

    function GetClock() {
        var d = new Date();
        var nday = d.getDay(),
            nmonth = d.getMonth(),
            ndate = d.getDate(),
            nyear = d.getFullYear();
        var nhour = d.getHours(),
            nmin = d.getMinutes(),
            ap;
        if (nhour == 0) {
            ap = " AM";
            nhour = 12;
        } else if (nhour < 12) {
            ap = " AM";
        } else if (nhour == 12) {
            ap = " PM";
        } else if (nhour > 12) {
            ap = " PM";
            nhour -= 12;
        }

        if (nmin <= 9) nmin = "0" + nmin;

        var clocktext = "" + tday[nday] + ", <br> " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br> " +
            nhour + ":" + nmin + ap + "";
        document.getElementById('clockbox').innerHTML = clocktext;
    }

    GetClock();
    setInterval(GetClock, 1000);
    </script>
    </div>
</body>

</html>