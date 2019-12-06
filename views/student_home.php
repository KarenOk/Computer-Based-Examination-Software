<?php
/*require_once('connect.php');*/
ini_set('display_errors', 1);

// if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false || !($_SESSION["usertype"] == "Student")) {
//     header("Location:login.php");
// }

$link = mysqli_connect("127.0.0.1", "pmauser", "password", "CBE");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

/*$a= mysqli_query("SELECT * FROM student_login WHERE id=".$_SESSION['student_id']. "");*/
/*$b=mysqli_fetch_array($a); */
$b = array("registration" => '15040850', "l_name" => $_SESSION['username']);
$qid = 0;
$qid = $qid++;
$etaker = mysqli_query($link, "SELECT User.id, User.username, start_exam.course, start_exam.category, start_exam.exam_tag, start_exam.exam_duration, start_exam.question_limit
FROM User, start_exam
WHERE User.username = " . $b['registration'] . " AND User.user_type = 'student'
ORDER BY User.id DESC LIMIT 1");

$etaker1 = mysqli_fetch_array($etaker);
$etexamtag = $etaker1['exam_tag'];
$etques = $etaker1['question_limit'];

$select = mysqli_query($link, "SELECT *
FROM " . $etaker1['course'] . "_" . $etaker1['category'] . "
WHERE exam_tag='$etexamtag'
LIMIT " . $etaker1['question_limit'] . "");

?>

<!doctype>
<html>
<head>
<meta charset="utf-8"> <meta name="viewport"
content="width=device-width, maximum-scale=1,
initial-scale=1, user-scalable=no">
<title>CBE-Objective</title>
<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'> <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link href="https://fonts.googleapis.com/css?family=DM+Serif+Display|Raleway&display=swap" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="css/custom.css">
<link rel="stylesheet" type="text/css" href="css/style.css"> -->
<link rel="stylesheet" type="text/css" href="./assets/css/student_home.css">

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body onLoad="cd();" oncontextmenu="return false" oncopy="return false"
oncut="return false" onpaste="return false" onkeydown="return (event.keyCode != 116)" style="font-family: 'Raleway', sans-serif;">
<div class="navbar-fixed-top fixed-top" style="background-color: #8f4747;">
<div class="container">
<div class="row">
<div class="col-md-6" style="padding:3px;">
<img class="img-responsive" src="https://unilag.edu.ng/wp-content/uploads/Untitled-7-5.png" style="width:120px;">
</div>
<div class="col-md-6 text-right">

<span style="font-size: 20px; color: white"><i class="glyphicon glyphicon-user"></i>
Welcome, <?php echo $b['l_name'] ?> </span>
<button style="background-color: black;"> <a href="helpers/logout.php" style="margin: 5px; color:white;"> Logout </a> </button>

</div>
            </div>
        </div>
    </div>

    <div style="margin-top:80px;"> </div>
    <div class="timer">
        <span style="margin-right:8px; "> Time Left </span> <button class="btn btn-warning naming"><i
                class="glyphicon glyphicon-time"></i>
            <b><span id="show"></span></b></button>
    </div>

    <div>
        <div style="margin-bottom:40px;"> </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2" style="margin-top:20px; marginbottom:40px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3></h3>
                        </div>
                        <div class="panel-body" style="padding:10px;">
                        <form name="form1" action="test-completed.php" enctype="multipart/form-data" method="post">
                                <div id="qContainer">
                                    <input type='hidden' value='quizId' name='quizId'>


<?php
while ($rs_row = mysqli_fetch_array($select)) {
    $qid++;
    $id = "" . $rs_row['id'] . "";
    $ask_question = "" . $rs_row['question'] . "";
    $opt_A1 = "" . $rs_row['optionA'] . "";
    $opt_B1 = "" . $rs_row['optionB'] . "";
    $opt_C1 = "" . $rs_row['optionC'] . "";
    $opt_D1 = "" . $rs_row['optionD'] . "";
    $opt_E1 = "" . $rs_row['optionE'] . "";
    $correct_ans = "" . $rs_row['correct_ans'] . "";

    ?>

<div class='qPanel'>

   <input type='hidden'>
    <div class='qText'>
        <div><img name="" src="admin/?php echo $rs_row['image'] ?>"
                style="max-width:400px;" class="img-responsive" alt=""></div>

        <div style="width:600px;"> </div>

        <span style="font-size:14px;">
            <b>

            </b>
        </span>
        <br>
    </div>


<?php
/* if(($rs_row['image']=="../images/examination/") || ($rs_row['image']=="images/examination/")) {?> <?php }
    else { ?> <div><img name="" src="admin/<?php echo $rs_row['image'] ?>" style= "max-width:400px;" class="img-responsive" alt=""></div> <?php } */
    ?>
<?php

    if (empty($rs_row['instruction'])) {?> <?php } else {?>
<div style="width:600px;"> <?php echo $rs_row['instruction'] ?></div> <?php }?>
<span style="font-size:14px;">
    <b>
    <?php echo 'Q' . $qid ?>
    <?php echo $ask_question; ?>
    </b>
</span>
<br>
</div>

<div class='options'>
A. <input type='radio' name='answer[<?php echo $id ?>]' value='<?php echo $opt_A1 ?>' >
<label for='opt_1'> <?php echo $opt_A1 ?> </label>
<br>
B. <input type="radio" name='answer[<?php echo $id ?>]' value='<?php echo $opt_B1 ?>' >
<label for='opt_2'> <?php echo $opt_B1 ?> </label>
<br>
C. <input type="radio" name='answer[<?php echo $id ?>]' value='<?php echo $opt_C1 ?>' >
<label for='opt_3'> <?php echo $opt_C1 ?> </label>
<br>
D. <input type="radio" name='answer[<?php echo $id ?>]' value='<?php echo $opt_D1 ?>'>
<label for="opt_4"> <?php echo $opt_D1 ?> </label>
<br>
<?php
if (empty($rs_row['opt_E'])) {?>
<?php
} else {
        ?>
E. <input type="radio" name='answer[<?php echo $id ?>]' value='<?php echo $opt_E1 ?>' id='opt_5'>
<label for='opt_5'> <?php echo $opt_E1 ?> </label>
<br>
<?php }?>
<input type="hidden" name="canswer[<?php echo $id ?>]"  value="<?php echo $correct_ans ?>">

</div>
</div>
<?php

}
?>


        </div>
        <div id='nav'>
        <div class="disable_text_highlighting">
        <a class='navbutton' id='previousbutton' onclick='nav(-1)'>&laquo; Previous
            Question</a>
        <a id='nextbutton' class='navbutton' onclick='nav(1)'>Next Question &raquo;
        </a><br><br>
        </div>
        <div style="display:flex; justify-content: flex-start;">

        <div style=" margin:10px;">
            <a class='qButton' onclick="">
            </a>
        </div>

        </div>
        </div>



        <input type="hidden" name="qid" value="?php echo $qid ?> ">
        <div><input type="submit" class="btn btn-prim subb" value="Submit Answers"
        name="Submit_ans" /> </div>
        </form>

</div>
                    </div>
                </div>
            </div>
            <!-- <button style="background-color: black;"> <a href="./helpers/logout.php" style="margin: 5px; color:white;"> Logout </a> </button> -->
            <div class="footer navbar-fixed-bottom" style="background-color: #8f4747;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-right" style="padding:15px 0px; color:#FFF; text-align: center;">
                            &copy;2019
                        </div>
                    </div>
                </div>
                <script src="js/jquery.js"></script>
                <script src="js/bootstrap.js"></script>
                <!--<script src="js/arrange.js"></script>-->
                <script>

                    var mins = 0;
                    var secs = 0;
                    var interval;
                    function cd() {
                        console.log("CD");
                        mins = 1 * m("?php echo $etaker1['exam_duration']; ?>"); // change minutes here
                        secs = 0 + s(":00"); // change seconds here (always add an additional second to your total)
                        redo();
                    }
                    function m(obj) {
                        for (var i = 0; i < obj.length; i++) {
                            if (obj.substring(i, i + 1) === ":")
                                break;
                        }
                        return (obj.substring(0, 1));
                    }

                    function s(obj) {
                        for (var i = 0; i < obj.length; i++) {
                            if (obj.substring(i, i + 1) === ":") break
                        }
                        return (obj.substring(i + 1, obj.length));
                    }

                    function dis(mins, secs) {
                        var disp;

                        if (mins <= 9) { disp = "0"; }
                        else {
                            disp = " ";
                        }

                        disp += mins + ":";
                        if (secs <= 9) { disp += "0" + secs; }
                        else { disp += secs; }
                    }
                    function redo() {
                        secs -= 1;
                        if (secs === -1) {
                            secs = 59;
                            mins -= 1
                        };

                        if ((mins === 1) && (secs === 0)) {
                            window.alert("Only 1 minute remains... \nSpeed Up");
                        }
                        document.getElementById("show").innerHTML = " " + mins + " min " + secs + " sec";
                        if ((mins === 0) && (secs === 0)) {
                            window.clearInterval(interval);
                            window.alert("Time is up. Press OK to continue.");
                            //window.location = "test-completed.php";
                            document.getElementsByClassName("btn btn-primary subb")[0].click();
                            console.log("submitted");
                        }
                    }


                    // document.getElementById("show").innerHTML =  dis(mins,secs);

                    var numQuestions, navs;
                    function init() {
                        "redo()"
                        cd();
                        interval = window.setInterval(redo, 999);
                        numQuestions = document.getElementsByClassName("qButton").length;
                        navs = document.getElementsByClassName('navbutton');
                        show(0);
                    }
                    window.onload = init;
                    var currentQuestion = 0;


                    document.getElementsByClassName("qPanel")[0].className += " active"; document.getElementsByClassName("qButton")[0].className += " current";
                    function show(i) {
                        document.getElementsByClassName("current")[0].className = "qButton";
                        document.getElementsByClassName("active")[0].className = "qPanel";
                        document.getElementsByClassName("qPanel")[i].className += " active";
                        document.getElementsByClassName("qButton")[i].className += " current";
                        navs[0].style.display = i === 0 ? 'none' : "";
                        navs[1].style.display = i === numQuestions - 1 ? 'none' : "";
                        currentQuestion = i;
                    }
                    function nav(offset) {
                        var targetQuestion = currentQuestion + offset;
                        if (targetQuestion >= 0 && targetQuestion < document.getElementsByClassName("qButton").length) { show(targetQuestion) };
                    }
                </script>



                <script type="text/javascript">
                    $(function () {
                        setTimeout(function () {
                            $('input[name="submit button1"]').trigger('click');
                        });
                    });

                </script>

            </div>
        </div>
    </div>


</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>

<body id="index-page">
    <h1> Hello <?php echo $_SESSION["username"] ?>! </h1>
    <h2> You're a <?php echo $_SESSION["user_type"] ?> </h2>

</body>
</html> -->