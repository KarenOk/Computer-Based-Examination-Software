<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}

require "../helpers/connect.php";

// Define variables and initialize with empty values
$username = $password = $usertype = "";
$username_err = $password_err = $usertype_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check if user type is empty
    if (empty(trim($_POST["user-type"]))) {
        $usertype_err = "Please select user category.";
    } else {
        $usertype = ucwords(trim($_POST["user-type"]));
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT username, pw FROM $usertype WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            // $table_name = $usertype;
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables

                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["usertype"] = $usertype;

                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Patua+One&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <h1> University <br> of <br> Lagos </h1>
        <img src="../assets/images/unilag-logo.webp" alt="University of Lagos" />
    </header>

    <main>
        <p> Online Examination System </p>
        <button data-toggle="modal" data-target="#login-form"> Login </button>

    </main>

    <!-- Login Modal -->
    <div id="login-form" class="modal login-form" aria-modal="true" tabindex="-1" role="dialog" aria-labelledby="login"aria-describedby="login">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <section class="modal-content">

                <header class="modal-header">
                    <h2 class="modal-title">Login </h2>
                </header>

                <div class="modal-body">
                    <p>Please fill in your details to login.</p>
                    <form method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="username"> Username </label>
                            <input type="text" id="username" name="username" class="form-control"
                                value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="user-type">User Category</label>
                            <select class="form-control" id="user-type" name="user-type">
                                <option value="administrator">Admin</option>
                                <option value="student">Student</option>
                                <option value="examiner">Examiner</option>
                            </select>
                            <span class="help-block"><?php echo $usertype_err; ?></span>
                        </div>

                        <div class="form-group button-group">
                            <button type="button" class="btn cls" data-dismiss="modal"> Cancel </button>
                            <input type="submit" class="btn" value="Login">
                        </div>

                    </form>

                </div>

            </section>
        </div>
    </div>


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>


    <script>
    // $(function() {
    //     $('.login-form').bind('click', function(event) {
    //         event.preventDefault(); // using this page stop being refreshing

    //         $.ajax({
    //             type: 'POST',
    //             url: 'login.php',
    //             data: $('.login-form').serialize(),
    //             success: function() {
    //                 console.log('form was submitted');
    //             }
    //         });

    //     });
    // });
    </script>


</body>

</html>