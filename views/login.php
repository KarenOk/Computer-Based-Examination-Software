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

                    mysqli_stmt_bind_result($stmt, $username, $db_password);
                    // echo $hashed_password + "echoo";
                    if (mysqli_stmt_fetch($stmt)) {

                        /**
                         *
                         *
                         *
                         * TODO: CHECK FOR HASHED PASSWORDS
                         *
                         *
                         *
                         * **/
                        if ($db_password == $password) {
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
        <button onclick="toggleModal()"> Login </button>
        <?php echo $sql ?>
    </main>

    <section class="overlay" aria-hidden="false">
        <dialog class="login-form" aria-modal="true" aria-labelledby="login" aria-describedby="login">
            <h2> Login </h2>
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
                    <button type="button" class="btn cls" onclick="toggleModal()"> Cancel </button>
                    <input type="submit" class="btn" value="Login">
                </div>



            </form>
        </dialog>
    </section>

    <script>
    let overlay = document.querySelector(".overlay");
    let dialog = document.querySelector("dialog");

    function toggleModal() {
        dialog.open = !dialog.open;
        overlay.hidden = !dialog.open ? true : false;
        overlay.style.display = dialog.open ? "block" : "none";
    }

    // var bool = "<?php echo json_encode($loginerr) ?>";
    // console.log(bool);

    // window.onload = function mountModal() {
    //     if (bool === "true"){
    //         dialog.open = true;
    //         overlay.hidden =  true;
    //         overlay.style.display = "block" ;
    //     }

    // }
    </script>

</body>

</html>