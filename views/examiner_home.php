<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Examiner</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>

<body id="index-page">
    <h1> Hello <?php echo $_SESSION["id"] ?>! </h1>
    <h2> You're a  <?php echo $_SESSION["user_type"] ?> </h2>

</body>
</html>