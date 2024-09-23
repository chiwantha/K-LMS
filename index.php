<?php

    session_start();
    include_once 'config/config.php';

    $version = get_versions($conn);

    if (isset($_COOKIE['student_username']) && isset($_COOKIE['student_id']) && isset($_COOKIE['css_version'])) {

        if ($version !== 'err') {
            if ($version !== $_COOKIE['css_versions']) {
                setcookie("css_version", "", time() - 3600, "/");
                setcookie("css_version", $version, time() + (86400 * 30), "/");
            }
        } else {
            return;
        }

        $_SESSION['username'] = $_COOKIE['student_username'];
        $_SESSION['id'] = $_COOKIE['student_id'];
        $_SESSION['css_version'] = $_COOKIE['css_version'];
        header("Location: dashboard.php");
        exit();

    } elseif (isset($_COOKIE['tutor_username']) && isset($_COOKIE['tutor_id']) && isset($_COOKIE['css_version'])) {
        
        if (get_versions($conn) !== $_COOKIE['css_versions']) {
            setcookie("css_version", "", time() - 3600, "/");
            setcookie("css_version", get_versions($conn), time() + (86400 * 30), "/");
        } else {
            return;
        }

        $_SESSION['tutor_username'] = $_COOKIE['tutor_username'];
        $_SESSION['tutor_id'] = $_COOKIE['tutor_id'];
        $_SESSION['css_version'] = $_COOKIE['css_version'];
        header("Location: Tutor-Admin/tutor-dashboard.php");
        exit();

    }

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
    <?php 
        include_once 'style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="logo" src="uploads/images/logo/logo.png" alt="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="config/about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="config/update.php">Updates</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="Tutor-Admin/tutor-login.php">An Admin ?</a>
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
                <a class="btn btn-success" href="https://api.whatsapp.com/send/?phone=94788806670&text&type=phone_number&app_absent=0">WhatsApp</a>
            </div>

        </div>
    </div>
</nav>

<!-- Section: Design Block -->
<section class="overflow-hidden login-section">
    <div class="container px-4 py-3 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-6 mb-lg-0" style="z-index: 10">
                <h1 class="mb-3 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                The best <br />
                <span style="color: hsl(218, 81%, 75%)">Accounting</span>
                </h1>
                <hr style="color: #fff;">
                <p class="mb-2 opacity-70" style="color: hsl(218, 81%, 85%)">
                Pahan Mihisanda: Premier account tutor in Gampaha, guiding students to excel with personalized strategies
                </p>
            </div>

            <div class="col-lg-6 mt-3 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div class="card bg-glass">
                    <div class="card-body px-4 py-5 px-md-5">

                        <div class="mb-4">
                            <h2>Student Login</h2>
                        </div>

                        <form id="loginForm" class="hero-student-login">

                            <!-- username input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control" placeholder="username" required maxlength="10"/>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" placeholder="password" required/>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="stayLoggedIn" name="stayLoggedIn">
                                <label class="form-check-label" for="stayLoggedIn" style="color: #fff;">Stay logged in</label>
                            </div>

                            <!-- action buttons -->
                            <button type="submit" id="submit" name="submit" class="btn btn-success btn-block mb-3">Login</button>
                            <a href="register.php" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-block mb-3">Register</a>

                            <div class="toast-container position-fixed bottom-0 end-0 p-3">

                                <!-----------------------------toast success---------------------------->
                                <div class="toast align-items-center text-bg-success border-0 p-1" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <strong>Success!</strong>
                                            <span id="successMessage"></span>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>

                                <!-----------------------------toast error---------------------------->
                                <div class="toast align-items-center text-bg-danger border-0 p-1" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <strong>Error !</strong>
                                            <span id="errorMessage"></span>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>

                            </div>

                        </form>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing">
                            <img src="uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once 'config/links.php';
?>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        var navbarHeight = document.getElementById('navbar').offsetHeight;
        document.documentElement.style.setProperty('--navbar-height', navbarHeight + 'px');
    });

    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault();

        $('#loginForm').addClass('d-none');
        $('#processing').removeClass('d-none')

        var formData = new FormData(this);
        formData.append('login_student', true);
        
        // Check if the stay logged in checkbox is checked
        if ($('#stayLoggedIn').is(':checked')) {
            formData.append('stayLoggedIn', true);
        } else {
            formData.append('stayLoggedIn', false);
        }

        $.ajax({
            type: "POST",
            url: "ajax/login_process.php",
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(response) {
            var res = JSON.parse(response);
            if (res.status === 500) {
                $('#loginForm').removeClass('d-none');
                $('#processing').addClass('d-none')
                $('#errorToast').toast("show");
                $('#errorMessage').html(res.message);
            } else if (res.status === 200) {
                window.location.href = "dashboard.php";
            } else if (res.status === 222) {
                window.location.href = "pwd_reset.php";
            } else if (res.status === 422 || res.status === 204 || res.status === 404 || res.status === 105 || res.status === 106) {
                $('#loginForm').removeClass('d-none');
                $('#processing').addClass('d-none')
                $('#errorToast').toast("show");
                $('#errorToast').html(res.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Request failed: " + textStatus, errorThrown);
            $('#errorToast').toast("show");
            $('#errorMessage').html("An unexpected error occurred.");
        });
    });

</script>

</body>
</html>