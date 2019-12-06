<?php
// session_start();

include "helpers/timeout.php"; // Handle the session timeout after inactivity

ini_set("display_errors", 1);
$username = $_SESSION["username"];

$queryResult = mysqli_query($conn, "SELECT * FROM Examiner WHERE username='$username' LIMIT 1");
$examinerObj = mysqli_fetch_object($queryResult);
$examArr = array();
$examResults = mysqli_query($conn, "SELECT * from Student_Result WHERE studentId=$username");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Examiner</title>

    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/examiner.css">

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
                        Manage Exams <span class="notification"> <span>
                    </a>
                </li>

                <li>
                    <a href="#gradebook" data-tab="gradebook">
                        Gradebook <span class="notification">
                    </a>
                </li>
            </ul>

            <div class="logout-section text-center">
                <button class="btn btn-lg logout">
                    <a href="helpers/logout.php"> Logout </a>
                </button>
            </div>

        </nav>

        <!-- Main Content-->
        <main>
            <!-- Home Tab -->
            <section class="tab-content home show" id="home">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">

                        <img class="rounded-circle avatar" src="assets<?php echo $examinerObj->imageUrl ?>"
                            alt="Student avatar">
                        <h1 class="welcome-message">
                            <span class="greeting"> Good day,</span>
                            <br>
                            <?php echo $examinerObj->firstName . " " . $examinerObj->lastName ?>
                        </h1>
                        <p class="time"> </p>
                    </div>
                </div>
            </section>

            <!-- Exams Tab  -->
            <section class="tab-content exams" id="exams">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">

                        <?php
$sql = "
    SELECT *
    FROM Course_Examiner ce, Course c
    WHERE ce.username='$username' and ce.courseId=c.courseId
    ";

$queryResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($queryResult) == 0) {
    echo "<h3 style='text-align:center'> You have not been assigned any courses. <br> Contact the administrator. </h3>";

    mysqli_data_seek($queryResult, 0);
} else {
    $i = 0;
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $sql = " SELECT examId FROM Exam e WHERE e.courseId='" . $row['courseId'] . "'";
        $exam = mysqli_query($conn, $sql);

        //  Determine if any exam has been created for it
        if (mysqli_num_rows($exam) > 0) {
            mysqli_data_seek($exam, 0);
            $exam = mysqli_fetch_object($exam);
            $examArr[] = $exam->examId;
            ?>
                        <!-- Print each course assigned to the examiner -->
                        <div class="exam-item">
                            <span class="course-code"><?php echo $row['courseCode'] ?> </span>
                            <div>
                                <p class="course-name"> <?php echo $row['courseTitle']; ?> </p>
                            </div>

                            <button class="edit-exam"
                                onclick="window.location.href='./views/manage-exam.php?examid=<?php echo $exam->examId; ?>'">
                                Edit Exam
                                <span> &#9998; </span>

                            </button>
                            <div>
                            </div>
                        </div>

                        <?php } else {?>

                        <!-- Print each course assigned to the examiner -->
                        <div class="exam-item">
                            <span class="course-code"><?php echo $row['courseCode'] ?> </span>
                            <div>
                                <p class="course-name"> <?php echo $row['courseTitle']; ?> </p>
                            </div>
                            <button class="create-exam"
                                onclick="window.location.href='views/manage-exam.php?courseid=<?php echo $row['courseId']; ?>'">
                                Create Exam <span> &#8853; </span>

                            </button>
                            <div>
                            </div>
                        </div>

                        <?php
}}}
;
?>

                    </div>
                </div>
            </section>


            <!-- Show Gradebook Tab  -->
            <section class="tab-content gradebook" id="gradebook">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <?php
if (count($examArr) == 0) {
    echo "<h3> No results to display.</h3>";
    echo "<p> Start by creating an exam. </p> ";

} else {
    $i = 0;

    foreach ($examArr as $examId) {
        $sql = "SELECT  c.courseCode, c.courseTitle FROM Exam e, Course c WHERE e.examId ='$examId' and e.courseId = c.courseId";
        $courseResult = mysqli_query($conn, $sql);
        $i++;

        while ($courseRow = mysqli_fetch_assoc($courseResult)) {

            ?>

                        <!-- Show each course -->
                        <section class="result-cont">
                            <div class="result-item" data-toggle="collapse" data-target="#result-<?php echo $i ?>">
                                <span class="course-code"> <?php echo $courseRow['courseCode'] ?> </span>
                                <div>
                                    <p class="course-name"> <?php echo $courseRow['courseTitle'] ?> </p>
                                </div>
                                <span class="collapse-icon"> &#8964; </span>
                                <div> </div>
                            </div>

                            <div class="result-details collapse" id="result-<?php echo $i ?>">
                                <section class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Student Name </th>
                                                <th> Score</th>
                                                <th> Obtainable Score </th>
                                                <th> Submit Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
// Get and loop through each student for a particular course
            $sql = "SELECT s.firstName, s.lastName, sr.score, sr.scoreOverall, sr.submitTime FROM Exam e, Student_Result sr, Student s WHERE e.examId ='$examId' and e.examId = sr.examId and studentId = s.username";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                                            <tr>
                                                <td> <?php echo $row['firstName'] . " " . $row['lastName'] ?></td>
                                                <td> <?php echo $row['score'] ?> </td>
                                                <td> <?php echo $row['scoreOverall'] ?> </td>
                                                <td> <?php echo $row['submitTime'] ?> </td>
                                            </tr>

                                            <?php }?>
                                        </tbody>
                                    </table>
                                </section>

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
    </script>

</body>

</html>

<?php

?>

</body>

</html>