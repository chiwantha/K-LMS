<?php
    session_start();

    if (!isset($_SESSION["tutor_username"])) {
        header('Location: tutor-login.php');
        exit();
    }

    $version = $_SESSION['css_version'];
    $username = $_SESSION["tutor_username"];
    $tutor_id = $_SESSION['tutor_id'];
    include_once "../config/config.php";
    include_once "../func/load_dashboard_data.php";
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#2D436B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2D436B">

    <link href="../uploads/images/logo/head.png" rel="icon">
    <link href="../uploads/images/logo/head.png" rel="apple-touch-icon">

    <title>K-LMS</title>
    <link rel="stylesheet" href="../style/css/style.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/fontawesome.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/all.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/dashboard.css?v=<?=$version?>"/>
    <?php 
        include_once '../style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="tutor-dashboard.php"><img class="logo" src="../uploads/images/logo/logo.png" alt="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="tutor-dashboard.php">Menu</a>
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

                <div class="my-data-tile-wraper ">

                    <div class="data-tile">
                        <span class="tile-title">STUDENTS</span>
                        <div class="inner-tile" id="my_students">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">Pen-STU</span>
                        <div class="inner-tile" id="pending_students">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">Pen-Pay</span>
                        <div class="inner-tile" id="pending_payments">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">CLASS</span>
                        <div class="inner-tile" id="my_classes">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">LESSONS</span>
                        <div class="inner-tile" id="my_lessons">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">SALES</span>
                        <div class="inner-tile" id="my_sales">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">TICKETS</span>
                        <div class="inner-tile" id="my_tickets">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">MSG</span>
                        <div class="inner-tile" id="my_messages">0</div>
                    </div>

                    <div class="data-tile">
                        <span class="tile-title">INCOME</span>
                        <div class="inner-tile" id="my_income">0</div>
                    </div>
                    
                </div>

                <div class="tutor-data-wraper bg-glass" style="text-align: center; color: #ffffff;">
                    <div class="d-flex tutor-data-btn-row mb-2">
                        <a href="tutor-student-manage.php" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #56ab2f 0%, #a8e063  51%, #56ab2f  100%);"><i class="fa-solid fa-users"></i></a>
                        <a href="tutor-payment-manage.php" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #FF512F 0%, #DD2476  51%, #FF512F  100%);"><i class="fa-solid fa-rupee"></i></a>
                    </div>
                    <div class="d-flex tutor-data-btn-row mb-2">
                        <a href="tutor-class-manage.php" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #B24592 0%, #F15F79  51%, #B24592  100%);"><i class="fa-solid fa-book"></i></a>
                        <a href="tutor-lesson-manage.php" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #B993D6 0%, #8CA6DB  51%, #B993D6  100%);"><i class="fa-solid fa-book-open-reader"></i></a>
                        <a href="tutor-income-manage.php" class="btn tutor-data-btn"
                         style="background-image: linear-gradient(to right, #232526 0%, #414345  51%, #232526  100%);"><i class="fa-solid fa-scale-unbalanced-flip"></i></a>
                    </div>
                    <div class="d-flex tutor-data-btn-row">
                        <a href="tutor-ticket-manage.php" class="btn tutor-data-btn"
                        style="background-image: linear-gradient(to right, #232526 0%, #414345  51%, #232526  100%);"><i class="fa-solid fa-ticket"></i></a>
                        <a href="tutor-bank-manage.php" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #4b6cb7 0%, #182848  51%, #4b6cb7  100%)"><i class="fa-solid fa-piggy-bank"></i></a>
                    </div>
                </div>

                <div class="tutor-data-wraper bg-glass" style="text-align: center; color: #ffffff;">
                    <h3 class="p-2">Public Data</h3>
                    <div class="d-flex tutor-data-btn-row">                       
                        <!-- <a href="#" class="btn tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #4b6cb7 0%, #182848  51%, #4b6cb7  100%);"><i class="fa-solid fa-graduation-cap"></i></a> -->
                        <a href="tutor-batch-manage.php" class="btn  tutor-data-btn" 
                        style="background-image: linear-gradient(to right, #4b6cb7 0%, #182848  51%, #4b6cb7  100%)"><i class="fa-regular fa-calendar-days"></i></a>
                        <a href="tutor-message-manage.php" class="btn tutor-data-btn"
                         style="background-image: linear-gradient(to right, #232526 0%, #414345  51%, #232526  100%);"><i class="fa-solid fa-envelope"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<script src="../style/js/my-script.js?v=<?=$version?>"></script>
<script src="../style/js/dashboard.js?v=<?=$version?>"></script>
<script src="https://cdn.logwork.com/widget/countdown.js"></script>

<?php
    include_once '../config/links.php';
?>

<script>
    $(document).ready(function() {
        load_data();
    });

    function load_data() {

        $.ajax({
            type: 'POST',
            url: 'ajax/dashboard_manage.php',
            data: {
                'load_dash': true,
                tutor_id : <?=$tutor_id ?>
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {                                                         
                    $('#my_students').html(res.data.student_count);
                    $('#pending_students').html(res.data.pending_student);
                    $('#pending_payments').html(res.data.pending_payment_request);
                    $('#my_classes').html(res.data.class_count);
                    $('#my_lessons').html(res.data.lesson_count);
                    $('#my_sales').html(res.data.monthly_sales_count);
                    $('#my_tickets').html(res.data.unread_ticket);
                    $('#my_messages').html(res.data.message_count);
                    $('#my_income').html(res.data.monthly_income);
                    // $('#countdown').attr("data-date", res.data.exam_date);
                };
            }
        });
    }
</script>

</body>
</html>