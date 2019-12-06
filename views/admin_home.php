<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="assets/css/admin.css">

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
                    <a href="#manage-users" data-tab="manage-users"> Manage Users </a>
                </li>

                <li>
                    <a href="#manage-courses" data-tab="manage-courses"> Manage Courses </a>
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
            <div class="tab-content home show" id="home">
                <img class="rounded-circle avatar" src="assets/images/admin.png" alt="Admin avatar">
                <h1 class="welcome-message">
                    <span class="greeting"> Good day,</span>
                    <br>
                    <?php echo $_SESSION["username"] ?>!
                </h1>
                <p class="time"> </p>
            </div>

            <!-- Manage Users Tab  -->
            <div class="tab-content manage-users" id="manage-users">
                <header>
                    <div class="left">
                        <i> <img src="assets/images/menu-icon.svg" class="menu" alt="menu"></i>
                        <h1> Manage Users </h1>
                    </div>
                    <div class="right">
                        <form action="" class="search">
                            <input type="text" name="search-users" id="search-users" placeholder="Search...">
                        </form>
                        <button data-toggle="modal" data-target="#create-user" class="add"> Add User </button>
                    </div>
                </header>
                <section class="user-table table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>User Type</th>
                                <th>Assigned Courses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
$sql = "SELECT *, 'Student' as usertype FROM Student
                                    UNION
                                    SELECT *, 'Examiner' as usertype FROM Examiner
                                    UNION
                                    SELECT username, firstName, lastName, imageUrl, '-' as gender, pw , 'Administrator' as usertype FROM Administrator
                                    ORDER BY firstName ASC";

$users = mysqli_query($conn, $sql);
while ($user = mysqli_fetch_array($users)) {
    ?>
                            <tr>
                                <td> <img class='user-image' src='assets<?php echo $user['imageUrl'] ?>'
                                        alt='<?php echo $user['firstName'] . " " . $user['lastName'] ?>'>
                                </td>
                                <td> <?php echo $user['username'] ?> </td>
                                <td> <?php echo $user['firstName'] . " " . $user['lastName'] ?> </td>
                                <td> <?php echo $user['gender'] ?> </td>
                                <td> <?php echo $user['usertype'] ?> </td>
                                <td>
                                    EEG502 <br>
                                    CPE520 <br>
                                    GEG510 <br>
                                </td>
                                <td>
                                    <img class='user-action' src='assets/images/pencil-edit-button.svg' alt='Edit'
                                        title='Edit'>
                                    <img class='user-action' src='assets/images/delete.svg' alt='Delete' title='Delete'>
                                    <img class='user-action' src='assets/images/padlock.svg' alt='Reset Password'
                                        title='Reset Password'>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </section>

                <!-- Create User Modal -->
                <div id="create-user" class="modal" tabindex="-1" role="dialog" aria-labelledby="Add New User"
                    aria-describedby="Create a course with the form">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <section class="modal-content">

                            <header class="modal-header">
                                <h5 class="modal-title">Register User </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>
                            <!-- username,firstName,lastName,imageUrl,gender,password -->

                            <div class="modal-body">
                                <form method="post" id="createUserForm" action="controllers/register-user.php">
                                    <div class="form-group">
                                        <label for="user-type">User Category</label>
                                        <select class="form-control" id="user-type" name="user-type">
                                            <option value="administrator">Admin</option>
                                            <option value="student">Student</option>
                                            <option value="examiner">Examiner</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="username"> Username </label>
                                        <input type="text" id="username" name="username" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname"> First Name </label>
                                        <input type="text" id="fname" name="fname" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lname"> Last Name </label>
                                        <input type="text" id="lname" name="lname" class="form-control" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="user-gender">Gender</label>
                                        <select class="form-control" id="user-gender" name="user-gender">
                                            <option value="female">Female</option>
                                            <option value="male">Male</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="password"> Password </label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cpassword"> Confirm Password </label>
                                        <input type="password" id="cpassword" name="cpassword" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="img-url"> Image URL </label>
                                        <input type="text" id="img-url" name="img-url" class="form-control" required>
                                    </div>

                                    <footer class="modal-footer">
                                        <button type="submit" class="btn btn-save">Save changes</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                    </footer>
                                </form>
                            </div>

                        </section>
                    </div>
                </div>

            </div>


            <!-- Manage Course Tab  -->
            <div class="tab-content manage-courses" id="manage-courses">
                <header>
                    <div class="left">
                        <i> <img src="assets/images/menu-icon.svg" class="menu" alt="menu"></i>
                        <h1> Manage Courses </h1>
                    </div>
                    <div class="right">
                        <form action="" class="search">
                            <input type="text" name="search-courses" id="search-courses" placeholder="Search...">
                        </form>
                        <button class="add" data-toggle="modal" data-target="#create-course"> Add Course </button>
                    </div>
                </header>
                <section class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course Title </th>
                                <th> Course Code</th>
                                <th> Assigned <br> Students </th>
                                <th> Assigned <br> Examiners</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$sql = "SELECT * FROM Course
    ORDER BY courseTitle ASC";

$courses = mysqli_query($conn, $sql);

while ($course = mysqli_fetch_array($courses)) {
    ?>
                            <tr>
                                <td> <?php echo $course['courseTitle'] ?></td>
                                <td> <?php echo $course['courseCode'] ?> </td>
                                <td>
                                    150408502 <br>
                                    130459604 <br>
                                    190559604 <br>
                                </td>
                                <td>
                                    oluseyibo <br>
                                    adelabu <br>
                                </td>
                                <td>
                                    <img class='user-action' src='assets/images/pencil-edit-button.svg' alt='Edit'
                                        title='Edit' aria-label='Edit Course'>
                                    <img class='user-action' src='assets/images/users.svg' alt='Assign/Unassign Users'
                                        title='Assign/Unassign Users' aria-label='Assign/Unassign Users to Course'>
                                    <img class='user-action' src='assets/images/delete.svg' alt='Delete' title='Delete'
                                        aria-label='Delete Course'>
                                </td>
                            </tr>
                            <?php
}
?>

                            <!-- <tr>
                                <td>Signals and Systems</td>
                                <td>EEG203 </td>
                                <td>
                                    150408502 <br>
                                    130459604 <br>
                                    190559604 <br>
                                </td>
                                <td>
                                    oluseyibo <br>
                                    adelabu <br>
                                </td>
                                <td>
                                    <img class="user-action" src="assets/images/pencil-edit-button.svg" alt="Edit"
                                        title="Edit" aria-label="Edit Course">
                                    <img class="user-action" src="assets/images/users.svg" alt="Assign/Unassign Users"
                                        title="Assign/Unassign Users" aria-label="Assign/Unassign Users to Course">
                                    <img class="user-action" src="assets/images/delete.svg" alt="Delete" title="Delete"
                                        aria-label="Delete Course">
                                </td>
                            </tr>
                            <tr>
                                <td>Electromagnetic Weve Theory</td>
                                <td>EEG509 </td>
                                <td>
                                    150408502 <br>
                                    130459604 <br>
                                    190559604 <br>
                                </td>
                                <td>
                                    prof_mowe <br>
                                    gbengailori <br>
                                </td>
                                <td>
                                    <img class="user-action" src="assets/images/pencil-edit-button.svg" alt="Edit"
                                        title="Edit" aria-label="Edit Course">
                                    <img class="user-action" src="assets/images/users.svg" alt="Assign/Unassign Users"
                                        title="Assign/Unassign Users" aria-label="Assign/Unassign Users to Course">
                                    <img class="user-action" src="assets/images/delete.svg" alt="Delete" title="Delete"
                                        aria-label="Delete Course">
                                </td>
                            </tr> -->

                        </tbody>
                    </table>
                </section>


                <!-- Create Course Modal -->
                <div id="create-course" class="modal" tabindex="-1" role="dialog" aria-labelledby="Add New Course"
                    aria-describedby="Create a course with the form">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <section class="modal-content">

                            <header class="modal-header">
                                <h5 class="modal-title">Register Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>


                            <div class="modal-body">
                                <form method="post" id="createCourseForm" action="controllers/register-course.php">
                                    <div class="form-group">
                                        <label for="ctitle"> Course Title </label>
                                        <input type="text" id="ctitle" name="ctitle" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="ccode"> Course Code </label>
                                        <input type="text" id="ccode" name="ccode" class="form-control" required>
                                    </div>

                                    <footer class="modal-footer">
                                        <button type="submit" class="btn btn-save">Save changes</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                    </footer>
                                </form>
                            </div>

                        </section>
                    </div>
                </div>

            </div>

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

    document.querySelector("#cpassword").addEventListener("change", e => {
        var input = e.target;
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Passwords do not match');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    });
    </script>

</body>

</html>