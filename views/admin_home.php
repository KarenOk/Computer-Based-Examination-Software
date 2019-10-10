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
        <!-- Sidebar and Navigation-->console.log(event.target);
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
                    <a href="process/logout.php"> Logout </a>
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
                <p> You're an <?php echo $_SESSION["usertype"] ?> </p>
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
                        <button data-toggle="modal" data-target="#create-course" class="add"> Add User </button>
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
$sql = "SELECT * FROM Student
                                    UNION
                                    SELECT * FROM Examiner
                                    UNION
                                    SELECT username, firstName, LastName, imageUrl, '-' as gender, pw FROM Administrator
                                    ORDER BY firstName ASC";

$users = mysqli_query($conn, $sql);
while ($user = mysqli_fetch_array($users)) {
    echo "
    <tr>
    <td> <img class='user-image' src='assets{$user['imageUrl']}' alt='user image'>
    </td>
    <td>{$user['username']}</td>
    <td>{$user['firstName']} {$user['LastName']}</td>
    <td>{$user['gender']} </td>
    <td>{$user['usertype']}</td>
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
    ";
}
?>
                        </tbody>
                    </table>
                </section>

                <div id="create-user" class="modal" tabindex="-1" role="dialog" aria-labelledby="Add New User"
                    aria-describedby="Create a user with the form">
                    <section class="modal-dialog modal-dialog-centered" role="document">
                        <article class="modal-content">
                            <header class="modal-header">
                                <h5 class="modal-title">Add User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>

                            <main class="modal-body">
                                <p>Modal body text goes here.</p>
                            </main>

                            <footer class="modal-footer">
                                <button type="button" class="btn btn-save">Save changes</button>
                                <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                            </footer>
                        </article>
                    </section>
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
$sqlTwo = "SELECT * FROM Course
    ORDER BY courseTitle ASC";

$courses = mysqli_connect($conn, $sqlTwo);
echo "<h1>$courses </h1>";
while ($course = mysqli_fetch_array($courses)) {
    echo "<tr>
    <td>{$course['courseTitle']}</td>
    <td>{$course['courseCode']} </td>
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
</tr>";
}
?>

                            <tr>
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
                            </tr>

                        </tbody>
                    </table>
                </section>

                <!-- Create Course Modal -->
                <div id="create-course" class="modal" tabindex="-1" role="dialog" aria-labelledby="Add New Course"
                    aria-describedby="Create a course with the form">
                    <section class="modal-dialog modal-dialog-centered" role="document">
                        <article class="modal-content">
                            <header class="modal-header">
                                <h5 class="modal-title">Add Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>

                            <main class="modal-body">
                                <form method="post">
                                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label for="ctitle"> Course Title </label>
                                        <input type="text" id="ctitle" name="ctitle" class="form-control" required
                                            value="<?php echo $username; ?>">
                                        <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label for="ccode"> Course Code </label>
                                        <input type="text" id="ctitle" name="ctitle" class="form-control" required
                                            value="<?php echo $username; ?>">
                                        <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>

                                    <footer class="modal-footer">
                                        <button type="submit" class="btn btn-save">Save changes</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                    </footer>
                                </form>
                            </main>

                        </article>
                    </section>
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
    </script>

</body>

</html>