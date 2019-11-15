<!-- TODO: Check if questions exist for an exam  -->

<!-- TODO: Display exam only if it doesn't have a result -->


<?php
// session_start();

include "helpers/timeout.php"; // Handle the session timeout after inactivity

ini_set("display_errors", 1);
$username = $_SESSION["username"];

$queryResult = mysqli_query($conn, "SELECT * FROM Student WHERE username=$username LIMIT 1");
$studentObj = mysqli_fetch_object($queryResult);

$examResults = mysqli_query($conn, "SELECT * from Student_Result WHERE studentId=$username");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>

    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/student.css">

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> University <br> of <br> Lagos </h1>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#home" data-tab="home"> Home </a>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                </li>

                <li>
                    <a href="#exams" data-tab="exams">
                        Exams <span class="notification"> <span>
                    </a>
                </li>

                <li>
                    <a href="#results" data-tab="results">
                        Results <span class="notification">
                    </a>
                </li>
            </ul>

            <div class="logout-section text-center">
                <button class="btn btn-lg logout">
                    <a href="process/logout.php"> Logout </a>
                </button>
            </div>

        </nav>

        <!-- Main Content-->
        <main>
            <!-- Home Tab -->
            <section class="tab-content home show" id="home">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">

                        <img class="rounded-circle avatar" src="assets<?php echo $studentObj->imageUrl ?>"
                            alt="Student avatar">
                        <h1 class="welcome-message">
                            <span class="greeting"> Good day,</span>
                            <br>
                            <?php echo $username ?>!
                        </h1>
                        <p class="time"> </p>
                        <p> You're a <?php echo $_SESSION["usertype"] ?> </p>
                    </div>
                </div>
            </section>

            <!-- Exams Tab  -->
            <section class="tab-content exams" id="exams">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">

                        <?php
$sql = "
    SELECT examId, timeDuration, courseCode, courseTitle
    FROM Course_Student cs, Course c, Exam e
    WHERE cs.username=$username and c.courseId=e.courseId and cs.courseId=c.courseId
    ";

$queryResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($queryResult) == 0) {
    echo "<h3 style='text-align:center'> You have no pending exams. </h3>";

    mysqli_data_seek($queryResult, 0);
} else {
    $i = 0;
    while ($info = mysqli_fetch_assoc($queryResult)) {
        ?>
                        <!-- Print each pending exam -->
                        <div class="exam-item">
                            <span class="course-code"><?php echo $info['courseCode'] ?> </span>
                            <div>
                                <p class="course-name">
                                    <?php echo $info['courseTitle']; ?> </p>
                                <span class="duration"> Duration: <?php echo $info['timeDuration']; ?>
                                </span>
                            </div>
                            <button class="start-exam"
                                onclick="window.location.href='views/take-exam.php?examid=<?php echo $info['examId']; ?>'">
                                Start Exam <span> &#x25b6; </span>
                            </button>
                            <div>
                            </div>
                        </div>

                        <?php
}}
;
?>



                    </div>
                </div>
            </section>


            <!-- Show Results Tab  -->
            <section class="tab-content results" id="results">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <?php
if (mysqli_num_rows($examResults) == 0) {
    echo "<h3> You have no results yet. </h3>";
    echo "<p> Start by taking an exam. </p> ";

    mysqli_data_seek($examResults, 0);
} else {
    $i = 0;

    while ($examResult = mysqli_fetch_assoc($examResults)) {
        $sql = "SELECT c.courseCode, c.courseTitle FROM Exam e, Course c WHERE e.examId = " . $examResult['examId'] . " and e.courseId = c.courseId";
        $result = mysqli_query($conn, $sql);
        $i++;

        while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <!-- Show each result -->
                        <section class="result-cont">
                            <div class="result-item" data-toggle="collapse" data-target="#result-<?php echo $i ?>">
                                <span class="course-code"> <?php echo $row['courseCode'] ?> </span>
                                <div>
                                    <p class="course-name"> <?php echo $row['courseTitle'] ?> </p>
                                </div>
                                <span class="collapse-icon"> &#8964; </span>
                                <div> </div>
                            </div>
                            <div class="result-details collapse" id="result-<?php echo $i ?>">
                                <p> Score: <span class="score"> <?php echo $examResult['score'] ?> </span> out of <span
                                        class="score-ovrl"> <?php echo $examResult['scoreOverall'] ?> </span>
                                </p>
                                <p> Submitted: <span class="submit-time"> <?php echo $examResult['submitTime'] ?>
                                    </span> </p>
                            </div>
                        </section>

                        <?php }}}?>

                    </div>
                </div>

            </section>

        </main>





    </div>

    <script src="assets/js/date.js"> </script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>



    <script>
    $(document).ready(function() {
        window.location.href = 'index.php#home';
        $(".menu").on("click", function() {
            $('#sidebar').toggleClass('active');
            $('main').toggleClass('active');
        });

        let resultSubmitTimes = document.querySelectorAll(".result-cont .submit-time");
        resultSubmitTimes.forEach(elem => {
            let time = GetClock(new Date(elem.innerText.trim().replace(' ', 'T')));
            elem.innerHTML = time;
        });

    });

    $("#sidebar li").on("click", function(event) {

        let ref_this = $("#sidebar li.active");
        let target = $(event.target);

        ref_this.removeClass("active");
        target.parent().addClass("active");


        // Get active tab
        let activeTab = target.data("tab");

        // Remove show from all tab contents
        $(".tab-content").each(function() {
            $(this).removeClass("show");
        });

        console.log($(`.tab-content.${activeTab}`));
        //  Add show to active tab
        $(`.tab-content.${activeTab}`).addClass("show");


    });

    var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
        "November", "December"
    ];

    function GetClock(d) {
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

        var clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br>" +
            nhour + ":" + nmin + ap + "";

        return clocktext;
    }
    </script>

</body>

</html>

<?php

?>