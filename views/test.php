<?php 
ini_set('display_errors', 1);

$link = mysqli_connect("127.0.0.1", "pmauser", "password", "CBE");

if(!$link){
    die("Connection failed: " .mysqli_connect_error());
}

$query = "SELECT User.id, User.username, start_exam.course, start_exam.category, start_exam.exam_tag, start_exam.exam_duration, start_exam.question_limit
FROM User, start_exam
WHERE User.username = '15040850' AND User.user_type = 'student'
ORDER BY User.id DESC LIMIT 1";

$users = mysqli_query($link, $query);


$usersArr=mysqli_fetch_array($users);
$etexamtag = $usersArr['exam_tag'];
$etques = $usersArr['question_limit'];


$select = mysqli_query($link, "SELECT * 
FROM ".$usersArr['course']."_".$usersArr['category']." 
WHERE exam_tag='$etexamtag' 
LIMIT ".$usersArr['question_limit']."");


while ($row = mysqli_fetch_array($select)){
    echo $row["question"];
}


if($link){
    echo " \n \n I workedddd";
}

?>

<html> 
<body> 
<?php 

?>

</body>


</html>
