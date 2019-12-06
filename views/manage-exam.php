<?php
session_start();
ini_set("display_errors", 1); // Display errors

// To setup database connection
require_once '../helpers/connect.php';
require_once '../helpers/timeout.php';

$username = $_SESSION["username"];

$instruction = "";
$duration = "";
$activated = "";
$courseId = "";
$examId = "";
$courseCode = "";
$edit = null;

// Get examid or courseid from url
$url_parts = parse_url($_SERVER['REQUEST_URI']);
parse_str($url_parts['query'], $url_query);

if (!empty($url_query['examid'])) {
    $examId = $url_query['examid'];
    $edit = true;
} else if (!empty($url_query['courseid'])) {
    $courseId = $url_query['courseid'];
    $edit = false;
}

// Get details about the exam
if ($examId) {
    $sql = "SELECT *
        FROM Exam e, Course_Examiner ce, Course c
        WHERE ce.username='$username' and ce.courseId=e.courseId and e.examId='$examId' and c.courseId=e.courseId
        LIMIT 1
        ";
    $queryResult = mysqli_query($conn, $sql);

    if (mysqli_num_rows($queryResult) != 0) {
        mysqli_data_seek($queryResult, 0);
        $exam = mysqli_fetch_object($queryResult);

        // Set necessary variables
        $instruction = $exam->instruction;
        $duration = $exam->timeDuration;
        $durationSplit = explode(":", $duration);
        $activated = $exam->activated;
        $courseId = $exam->courseId;
        $examId = $exam->examId;
        $courseCode = $exam->courseCode;

    } else {
        // If there are no results, then the examiner shouldn't be managing the exam. Redirect.
        header("location: ../index.php");
    }

    // Get Questions
    $sql = "
        SELECT *
        FROM Question q
        WHERE q.examId=$examId
    ";
    $questionsResult = mysqli_query($conn, $sql);

} else {
    $sql = "SELECT courseCode
        FROM Course_Examiner ce, Course c
        WHERE ce.username='$username' and ce.courseId='$courseId'
        LIMIT 1";
    $queryResult = mysqli_query($conn, $sql);

    if (mysqli_num_rows($queryResult) != 0) {
        mysqli_data_seek($queryResult, 0);
        $exam = mysqli_fetch_object($queryResult);

        // Set necessary variables
        $courseCode = $exam->courseCode;

    } else {
        // If there are no results, then the examiner shouldn't be managing the exam. Redirect.
        header("location: ../index.php");
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Examiner</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/manage-exam.css">

</head>

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<body>
    <div class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> University <br> of <br> Lagos </h1>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#exam-details" data-tab="exam-details">
                        Exam Details <span class="notification"> <span>
                    </a>
                </li>

                <li>
                    <a href="#questions" data-tab="questions">
                        Questions <span class="notification">
                    </a>
                </li>
            </ul>

            <div class="action-section text-center">
                <button class="btn btn-lg logout">
                    <a href="../index.php"> Home </a>
                </button>
            </div>

        </nav>

        <!-- Main Content-->
        <main>

            <!-- Exams Tab  -->
            <section class="tab-content exam-details show" id="exam-details">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <header>
                            <h1> <?php echo $edit ? "Edit" : "Create"; ?> Exam For
                                <?php echo $courseCode; ?>
                            </h1>

                        </header>

                        <div>
                            <form method="post" id="examForm" action="../controllers/set-exam.php">
                                <div class="form-group">
                                    <label for="instruction">Exam Instruction</label>
                                    <textarea class="form-control" id="instruction"
                                        name="instruction"> <?php echo $instruction ?></textarea>
                                </div>


                                <div class="input-group">
                                    <label> Exam Duration </label>

                                    <input aria-label="hours" type="number" id="duration-hr" name="duration-hr"
                                        class="form-control" placeholder="HH" value="<?php echo $durationSplit[0] ?>" />
                                    <span class="input-group-text">:</span>

                                    <input aria-label="minutes" type="number" id="duration-min" name="duration-min"
                                        class="form-control" placeholder="MM" min="0" max="59"
                                        value="<?php echo $durationSplit[1] ?>" />
                                    <span class="input-group-text">:</span>

                                    <input aria-label="seconds" type="number" id="duration-sec" name="duration-sec"
                                        class="form-control" placeholder="SS" min="0" max="59"
                                        value="<?php echo $durationSplit[2] ?>" />
                                </div>

                                <fieldset class="form-group">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-2 pt-0 label">Activated: </legend>
                                        <!-- <br> -->
                                        <div class="col-sm-10">
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="activated"
                                                    id="activated-true" value="1"
                                                    <?php if ($activated == '1') {echo ' checked ';}?>>
                                                <label class="form-check-label radio" for="activated-true">
                                                    True
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="activated"
                                                    id="activated-false" value="0"
                                                    <?php if ($activated == '0') {echo ' checked ';}?>>
                                                <label class="form-check-label radio" for="activated-false">
                                                    False
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <input type="hidden" name="lastModified">
                                <input type="hidden" name="edit" value="<?php echo $edit ?>">

                                <?php
if (!$edit) {
    echo '<input type="hidden" name="createdAt">';
    echo '<input type="hidden" name="courseId" value="' . $courseId . '">';

} else {
    echo '<input type="hidden" name="examId" value="' . $examId . '">';

}
?>


                                <footer>
                                    <button type="submit" class="btn btn-save">Save changes</button>
                                </footer>
                            </form>

                        </div>
                    </div>
                </div>
            </section>


            <!-- Set Questions Tab  -->
            <section class="tab-content questions" id="questions">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <?php
if (empty($examId)) {
    echo "<h3>Please create the exam first. </h3>";
    echo "<p> Go the the Exam Details tab. </p> ";
} else {
    ?>
                        <header>
                            <div class="left">
                                <i> <img src="../assets/images/menu-icon.svg" class="menu" alt="menu"></i>
                                <h1> Manage Questions for <?php echo $courseCode; ?> </h1>
                            </div>
                            <div class="right">
                                <form action="" class="search">
                                    <input type="text" name="search-questions" id="search-questions"
                                        placeholder="Search...">
                                </form>
                                <button class="add" data-toggle="modal" data-target="#create-question"> Add Question
                                </button>
                            </div>
                        </header>
                        <section class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Question </th>
                                        <th> Option 1 </th>
                                        <th> Option 2</th>
                                        <th> Option 3 </th>
                                        <th> Option 4</th>
                                        <th> Option 5</th>
                                        <th> Answer </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
while ($question = mysqli_fetch_assoc($questionsResult)) {
        ?>
                                    <tr>
                                        <td hidden class="questionId"> <?php $question["questionId"]?></td>
                                        <td> <?php echo $question["question"] ?> </td>
                                        <td> <?php echo $question["option1"] ?> </td>
                                        <td> <?php echo $question["option2"] ?> </td>
                                        <td> <?php echo $question["option3"] ?> </td>
                                        <td> <?php echo $question["option4"] ?> </td>
                                        <td> <?php echo $question["option5"] ?> </td>
                                        <td> <?php echo $question["answer"] ?> </td>

                                        <td>
                                            <img class="user-action" src="../assets/images/pencil-edit-button.svg"
                                                alt="Edit" title="Edit" aria-label="Edit Course">
                                            <img class="user-action" src="../assets/images/delete.svg" alt="Delete"
                                                title="Delete" aria-label="Delete Course">
                                        </td>
                                    </tr>

                                    <?php }?>
                                </tbody>
                            </table>
                        </section>


                        <!-- Create Course Modal -->
                        <div id="create-question" class="modal" tabindex="-1" role="dialog"
                            aria-labelledby="Add New Question" aria-describedby="Create a course with the form">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <section class="modal-content">

                                    <header class="modal-header">
                                        <h5 class="modal-title"> Add Question </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </header>


                                    <div class="modal-body">
                                        <form method="post" id="createQuestionForm"
                                            action="../controllers/set-questions.php">
                                            <div class="form-group">
                                                <label for="question"> Question </label>
                                                <textarea type="text" id="question" name="question" class="form-control"
                                                    required> </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="option-1"> Option 1 </label>
                                                <input type="text" id="option-1" name="option-1" class="form-control"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="option-2"> Option 2 </label>
                                                <input type="text" id="option-2" name="option-2" class="form-control"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="option-3"> Option 3 </label>
                                                <input type="text" id="option-3" name="option-3" class="form-control"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="option-4"> Option 4 </label>
                                                <input type="text" id="option-4" name="option-4" class="form-control"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="option-5"> Option 5 </label>
                                                <input type="text" id="option-5" name="option-5" class="form-control"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="correct-answer">Correct Answer</label>
                                                <select class="form-control" id="correct-answer" name="correct-answer"
                                                    value="option-1">
                                                    <option value="option-1">Option 1</option>
                                                    <option value="option-2">Option 2</option>
                                                    <option value="option-3">Option 3</option>
                                                    <option value="option-4">Option 4</option>
                                                    <option value="option-5">Option 5</option>
                                                </select>
                                            </div>

                                            <input type="hidden" name="examId" value="<?php echo $examId ?>" />

                                            <footer class="modal-footer">
                                                <button type="submit" class="btn btn-save">Save changes</button>
                                                <button type="button" class="btn btn-cancel"
                                                    data-dismiss="modal">Close</button>
                                            </footer>
                                        </form>
                                    </div>

                                </section>
                            </div>
                        </div>

                    </div>

                    <?php }?>
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
        // window.location.href = 'index.php#home';
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
        console.log(activeTab);

        // Remove show from all tab contents
        $(".tab-content").each(function() {
            $(this).removeClass("show");
        });

        console.log($(`.tab-content.${activeTab}`));
        //  Add show to active tab
        $(`.tab-content.${activeTab}`).addClass("show");


    });

    let edit = document.querySelector("input[name=edit]");
    let lastModified = document.querySelector("input[name=lastModified]");


    document.querySelector("#examForm").addEventListener("submit", (e) => {
        // e.preventDefault();
        let time = (new Date()).toISOString().slice(0, 19).replace('T', ' ');
        lastModified.value = time;

        if (edit.value === "") {
            // If we're not editing

            let createdAt = document.querySelector("input[name=createdAt]");
            createdAt.value = time;
        }
    });
    </script>

</body>

</html>