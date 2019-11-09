<?php

if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header("location: views/login.php");
    exit;
}

if ($_SESSION["user_type"] != "Student") {
    header("location: index.php");
    exit;
}

include "helpers/connect.php";

ini_set("display_errors", 1);
$username = $_SESSION["username"];

$queryResult = mysqli_query($conn, "SELECT * FROM Student WHERE username=$username");
$studentObj = mysqli_fetch_object($queryResult);

$queryResult = mysqli_query($conn, "SELECT * from Student_Result WHERE studentId=.$username.");
if ($queryResult) {
    $examResults = mysqli_fetch_object($queryResult);
} else {
    $examResults = array();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/student.css">

</head>

<body>
    <s class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> University <br> of <br> Lagos </h1>
            </div>

            <!-- <ul class="list-unstyled components">
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
            </ul> -->

            <div class="logout-section text-center">
                <button class="btn btn-lg logout">
                    <a href="process/logout.php"> Submit </a>
                </button>
            </div>

        </nav>

        <!-- Main Content-->
        <main>
            <!-- Home Tab -->
            <section class="tab-content instructions show" id="instructions">
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
                        <div class="exam-item">
                            <span class="course-code"> EEG 509 </span>
                            <div>
                                <p class="course-name"> Electromagnetic Wave Theory </p>
                                <span class="duration"> Duration: 00:20:00 </span>
                            </div>
                            <button class="start-exam"> Start Exam <span> &#x25b6; </span> </button>
                            <div>
                            </div>
                        </div>

                        <div class="exam-item">
                            <span class="course-code"> EEG 203 </span>
                            <div>
                                <p class="course-name"> Signals and Systems </p>
                                <span class="duration"> Duration: 01:20:00 </span>
                            </div>
                            <button class="start-exam"> Start Exam <span> &#x25b6; </span> </button>
                            <div>
                            </div>
                        </div>
            </section>


            <!-- Show Results Tab  -->
            <section class="tab-content results" id="results">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <?php
if (empty($examResults)) {
    echo "<h3> You have no results yet. </h3>";
    echo "<p> Start by taking an exam. </p> ";
}?>

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
            $(".menu").on("click", function() {
                $('#sidebar').toggleClass('active');
                $('main').toggleClass('active');
            });

        });

        $('#myModal').on('shown.bs.modal', function() {
            $('#myInput').trigger('focus')
        })

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
        </script>

</body>

</html>