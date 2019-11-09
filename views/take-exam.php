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
    WHERE cs.username=$username and cs.courseId=e.courseId and e.examId=$examid and c.courseId=e.courseId
    LIMIT 1
    ";

$queryResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($queryResult) != 0) {
    $exam = mysqli_fetch_object($queryResult);
} else {
    // TODO: Redirect

    // If there are no results, then the student shouldn't be taking the exam. Redirect.
    // header("location: student.php");
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
    <s class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> University <br> of <br> Lagos </h1>
            </div>

            <div class="timer">
                <!-- TODO: Get Time and Countdown when start is clicked -->
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
                <button class="btn btn-lg">
                    <a href="../process/submit-exam.php"> Submit </a>
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

                        <form>

                            <?php
$i = 1;
while ($question = mysqli_fetch_assoc($questionsResult)) {
    $ques = $question['question'];
    $option1 = $question['option1'];
    $option2 = $question['option2'];
    $option3 = $question['option3'];
    $option4 = $question['option4'];
    $option5 = $question['option5'];
    $answer = $question['answer'];

    echo '
                                        <section class="question-cont">
                                            <span> Q' . $i . ': </span>
                                            <label>' . stripcslashes($ques) . '</label>
                                            <section class="options-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio" value=' . $option1 . '>'
    . stripcslashes($option1) .
    '</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio" value=' . $option2 . '>'
    . stripcslashes($option2) .
    '</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio" value=' . $option3 . '>'
    . stripcslashes($option3) .
    '</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio" value=' . $option4 . '>'
    . stripcslashes($option4) .
    '</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio" value=' . $option5 . '>'
    . stripcslashes($option5) .
        '</label>
                                                </div>

                                            </section>
                                        </section>';
    $i++;
}
;
?>

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
        $(document).ready(function() {
            $(".menu").on("click", function() {
                $('#sidebar').toggleClass('active');
                $('main').toggleClass('active');
            });

        });

        // After clicking Continue, remove Instructions
        $(".start-exam").on("click", function(event) {
            $(`.tab.instructions`).removeClass("show");
            $(`.tab.questions`).addClass("show");
            started = true;

        });

        $("#sidebar li").on("click", function(event) {

            // let ref_this = $("#sidebar li.active");
            // let target = $(event.target);

            // ref_this.removeClass("active");
            // target.parent().addClass("active");


            // // Get active tab
            // let activeTab = target.data("tab");

            // // Remove show from all tab contents
            // $(".tab").each(function() {
            //     $(this).removeClass("show");
            // });

            // console.log($(`.tab.${activeTab}`));
            // //  Add show to active tab
            // $(`.tab.${activeTab}`).addClass("show");


            // After clicking any question number, remove exam instructions
            if (started = false) {
                $(`.tab.instructions`).removeClass("show");
                $(`.tab.questions`).addClass("show");
                started = true;
            };

        });

        questionContainers = document.querySelectorAll(".question-cont");
        questionNavList = document.querySelectorAll(".question-no-list li");
        questionControls = document.querySelectorAll(".question-control .btn");
        currentQuestion = 0;


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

        let durationElem = document.querySelector(".timer .duration");
        let duration = durationElem.innerText;
        let splitDuration = duration.split(":");
        let durationHour = Number(splitDuration[0]);
        let durationMin = Number(splitDuration[1]);
        let durationSec = Number(splitDuration[2]);

        // function toDate(timeStr, format) {
        //     var now = new Date();
        //     var splitTimeStr= timeStr.split(":");
        //         now.setHours(splitTimeStr[0]);
        //         now.setMinutes(splitTimeStr[1]);
        //         now.setSeconds(splitTimeStr[2]);
        //         return now;

        // }

        function timer() {
            if (durationSec === 0) {
                durationSec = 59;
                if (durationMin === 0) {
                    durationMin = 59
                    durationHour --;
                } else {
                    durationMin--;
                }
            } else {
                durationSec--;
            }

            // Hours is only padded if its a single digit
            duration = (String(durationHour).length < 2 ? padNo(durationHour, 2) : durationHour) + ":" + padNo(durationMin, 2) + ":" + padNo(durationSec, 2);
            durationElem.innerText = duration;

            // Stop at 00:00:00
            if (durationSec=== 0 && durationMin === 0 && durationHour === 0) {
                window.clearInterval(countDown);
            }
        }

        // Function to padd numbers
        function padNo(num, size){
            numStr = String(num)
            if ( numStr.length < size) {
                while (numStr.length < size) {
                    numStr = "0" + numStr
                }
            }
            return numStr;
        }

        let countDown = window.setInterval(timer, 1001);
        </script>

</body>

</html>