<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php');
        exit();
    }

    $username = $_SESSION["username"];
    $version = $_SESSION['css_version'];

    include_once "config/config.php";
    include_once "func/load_dashboard_data.php";

    $date =  get_student_al_date($conn, $username);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#2D436B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2D436B">

    <link href="uploads/images/logo/head.png" rel="icon">
    <link href="uploads/images/logo/head.png" rel="apple-touch-icon">

    <title>K-LMS</title>
    <link rel="stylesheet" href="style/css/style.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/fontawesome.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/all.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/dashboard.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/menubar.css?v=<?=$version?>"/>
    <?php 
        include_once 'style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- student dashboard navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><img class="logo" src="uploads/images/logo/logo.png" alt="#"></a>
        <!-- <button id="go_back" class="btn btn-warning ms-auto"><i class="fa-solid fa-angle-left"></i></button> -->
        <button class="navbar-toggler" style="border: none;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <!-- <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li> -->

                <li class="nav-item">
                    <a class="nav-link" href="my-profile.php">My Profile</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="classes.php">Buy Classes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="my-classes.php">My Classes</a>
                </li>

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Student</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">My Class</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Payment History</a></li>
                    </ul>
                </li> -->

            </ul>

            <div class="d-flex" style="gap: 10px;">
                <a class="btn btn-danger" href="ajax/logout_process.php">LogOut</a>
            </div>

        </div>
    </div>
</nav>

<!-- Section: Design Block -->
<section class="overflow-hidden">
    <div class="container py-1 text-center text-lg-start my-3">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-12 mb-lg-0 position-relative">
                
                <div id="radius-shape-1" class=" rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class=" shadow-5-strong"></div>

                <div class="al-countdown-wraper" style="text-align: center; color: #ffffff;">
                    <h3 style="font-family: Playwrite IT Moderna, cursive; font-size: 25px; padding: 15px 0 0 0;" id="batch_title">Welcome !</h3>
                    <!-- <span class="al-countdown-sub-title">No Pain No Gain</span> -->
                    <a href="https://logwork.com/countdown-timer" class="countdown-timer" data-timezone="Asia/Colombo" style="pointer-events: none ; color: #ffffff; font-size: small;" id="countdown"
                    data-textcolor="#ffffff" data-date="<?=$date ?>" data-background="#f59aad" data-digitscolor="#ffffff" data-unitscolor="#ffffff">Exam Countdown</a>
                </div>

                <div class="tutor-data-wraper" style="text-align: center; color: #ffffff;">
                    <div class="d-flex tutor-data-btn-row">
                        <a href="tutors.php" class="btn btn-success tutor-data-btn" style="background: #3EB649;"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a href="messages.php" class="btn btn-success tutor-data-btn" style="background: #EE3A25;"><i class="fa-solid fa-envelope"></i></a>
                        <!-- <a href="my-ticket.php" class="btn btn-success tutor-data-btn" style="background: #F1592A;"><i class="fa-solid fa-comments"></i></a> -->
                    </div>
                </div>

                <!-- <div class="my-data-wraper" style="text-align: center; color: #ffffff;">
                    <h3>My Account Action</h3>
                    <div class="d-flex my-data-btn-row">
                        <a href="my-profile.php" class="btn btn-success my-data-btn"><i class="fa-solid fa-user-tie"></i></a>
                        <a href="my-tutors.php" class="btn btn-success my-data-btn"><i class="fa-solid fa-book-open"></i></a>
                        <a href="requests.php" class="btn btn-success my-data-btn"><i class="fa-solid fa-rupee-sign"></i></a>
                    </div>
                </div> -->

                <div class="my-data-tile-wraper">
                    <div class="data-tile">
                        <span class="tile-title">MY CLASS</span>
                        <div class="inner-tile" id="my_class">0</div>
                    </div>
                    <div class="data-tile">
                        <span class="tile-title">MY LESSON</span>
                        <div class="inner-tile" id="my_lesson">0</div>
                    </div>
                    <div class="data-tile">
                        <span class="tile-title">PENDING</span>
                        <div class="inner-tile" id="my_requests">0</div>
                    </div>
                    <div class="data-tile">
                        <span class="tile-title">TICKETS</span>
                        <div class="inner-tile" id="my_ticket">0</div>
                    </div>
                    <div class="data-tile">
                        <span class="tile-title">MSGS</span>
                        <div class="inner-tile" id="my_messages">0</div>
                    </div>
                    <div class="data-tile">
                        <span class="tile-title">SPENT .RS</span>
                        <div class="inner-tile" id="my_spent">0</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php 
    include_once 'config/footer-dashboard.php';
?>

<script src="style/js/my-script.js?v=<?=$version?>"></script>
<script src="style/js/dashboard.js?v=<?=$version?>"></script>
<script src="https://cdn.logwork.com/widget/countdown.js"></script>

<?php
    include_once 'config/links.php';
?>

<script>
    $(document).ready(function() {
        load_data();
    });

    function load_data() {
        //e.preventDefault();
        const student_id = '<?php echo $_SESSION['id']; ?>';

        $.ajax({
            type: 'POST',
            url: 'ajax/my_data_process.php',
            data: {
                'id': student_id,
                'load_dash': true
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {                                                         
                    $('#my_class').html(res.data.class_count);
                    $('#my_lesson').html(res.data.lesson_count);
                    $('#my_requests').html(res.data.pending_payment_count);
                    $('#my_ticket').html(res.data.unread_ticket_count);
                    $('#my_messages').html(res.data.unread_message_count);
                    $('#my_spent').html(res.data.spent);
                    $('#batch_title').html(res.data.student_batch + ' A/L');
                    // $('#countdown').attr("data-date", res.data.exam_date);
                };
            }
        });
    }
</script>

</body>
</html>