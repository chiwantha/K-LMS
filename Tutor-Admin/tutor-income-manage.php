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
                <a class="btn btn-danger" href="tutor-login.php">LogOut</a>
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

                <div class="tutor-data-wraper bg-glass" style="text-align: center; color: #ffffff; margin-bottom: 15px;">
                    <div class="d-flex tutor-data-btn-row mb-1">
                        <div class="data-tile">
                            <span class="tile-title" id="current_month_income_title"><?=date('M ') ?> Income</span>
                            <div class="inner-tile" id="current_month_income">0</div>
                        </div>
                    </div>
                    <div class="d-flex tutor-data-btn-row">
                        <div class="data-tile">
                            <span class="tile-title" id="current_year_income_title"><?=date('Y ') ?> Income</span>
                            <div class="inner-tile" id="current_year_income">0</div>
                        </div>

                        <div class="data-tile">
                            <span class="tile-title" id="current_year_sales_title"><?=date('Y ') ?> Sales</span>
                            <div class="inner-tile" id="current_year_sales">0</div>
                        </div>
                    </div>
                </div>

                <div class="tutor-data-wraper bg-glass" style="text-align: center; color: #ffffff; margin-bottom: 15px;">
                    <h4>Filter Results</h4>
                    <div class="input-group mb-1">
                        <input type="month" id="filterMonthYear" class="form-control" required>
                    </div>
                    <div class="input-group" style="justify-content: space-between;">
                        <button class="btn btn-warning" style="width: 49.5%;" type="button" id="filterButton">Filter</button>
                        <button class="btn btn-danger" style="width: 49.5%;" type="button" id="resetButton">Reset</button>
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
        load_data(null, null);
    });

    function load_data(month, year) {
        if (month !==  null && year !== null) {
            $('#current_month_income_title').html(month + ' Income');
            $('#current_year_income_title').html(year + ' Income');
            $('#current_year_sales_title').html(year + ' Sales');
        }

        $.ajax({
            type: 'POST',
            url: 'ajax/income_manage.php',
            data: {
                'load_tiles': true,
                'filter_month': month,
                'filter_year': year,
                tutor_id : <?=$tutor_id ?>
            },
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if (res.status == 200) {                                                         
                    $('#current_month_income').html(res.data.current_month_income);
                    $('#current_year_income').html(res.data.current_year_income);
                    $('#current_year_sales').html(res.data.current_year_sales);
                }
            }
        });
    }

    $('#filterButton').click(function() {
        var monthYear = $('#filterMonthYear').val();
        if (monthYear) {
            var parts = monthYear.split('-');
            var year = parts[0];
            var monthNumber = parseInt(parts[1], 10);
            var monthName = getMonthName(monthNumber);
            load_data(monthName, year);
        } else {
            alert('Please select a month and year.');
        }
    });

    $('#resetButton').click(function() {
        $('#filterMonthYear').val('');
        load_data(null, null);
    });

    //------------------------------------------------------------

    function getMonthName(monthNumber) {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        return monthNames[monthNumber - 1];
    }

</script>

</body>
</html>