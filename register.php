<?php

    include_once 'config/config.php';

    $version = get_versions($conn);

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
    <link rel="stylesheet" href="style/css/registration.css?v=<?=$version?>"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php 
        include_once 'style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="logo" src="uploads/images/logo/harabara.png" alt="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Student Login</a>
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
                <a class="btn btn-success" href="#">WhatsApp</a>
            </div>

        </div>
    </div>
</nav>

<!-- Section: Design Block -->
<section class="overflow-hidden login-section">
    <div class="container px-4  px-md-5 text-center text-lg-start my-2">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-12 mt-3 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div id="form" class="card bg-glass">
                    <div class="card-body px-2 py-4 px-md-5">

                        <div class="mb-4">
                            <h2>Student Admission</h2>
                        </div>

                        <hr style="color: #fff;">

                        <form id="studentForm" class="studentFormregister">
                            <div class="container">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_id">Student ID</label>
                                            <input id="student_id" name="id" type="text" class="form-control" placeholder="Auto-generated" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" name="name" type="text" maxlength="150" class="form-control" placeholder="Kasun Chiwantha" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="batch">Batch</label>
                                            <select id="batch" name="batch" class="form-select">
                                                <option value="2023" selected>2023 A/L</option>
                                                <option value="2024">2024 A/L</option>
                                                <option value="2025">2025 A/L</option>
                                                <option value="2026">2026 A/L</option>
                                                <option value="2027">2027 A/L</option>
                                                <option value="2028">2028 A/L</option>
                                                <option value="2029">2029 A/L</option>
                                                <option value="2030">2030 A/L</option>
                                                <!-- Add other options -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact">Contact</label>
                                            <input id="contact" name="contact" type="text" class="form-control" placeholder="0788806670" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="whatsapp">WhatsApp</label>
                                            <input id="whatsapp" name="whatsapp" type="text" class="form-control" placeholder="0761294262" maxlength="10" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input id="dob" name="dob" type="date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sex">Sex</label>
                                            <select id="sex" name="sex" class="form-select" aria-label="Default select example">
                                                <option value="1" selected>Male</option>
                                                <option value="0">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="school">School</label>
                                            <input id="school" name="school" type="text" class="form-control" maxlength="150" placeholder="Padmavathie National Collage">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Student Image</label>
                                            <input id="image" type="file" class="form-control" name="image" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input id="username" name="username" type="text" class="form-control" placeholder="Set 10 character username (kasun@user)" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="***************" maxlength="8" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-success w-100">Request Registration</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing">
                    <img src="uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                </div>

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

                <div id="upades" class="card bg-glass d-none">
                    <div class="card-body px-2 py-4 px-md-5">

                        <div class="mb-4">
                            <h2>අයදුම් කිරීම සාර්ථකයි !</h2>
                        </div>

                        <hr style="color: #fff;">

                        <p style="color: #fff;">
                            අයදුම් කල පසු ඔබේ ගිණුම සක්‍රීය වීමට පැය කීහිපයක් ගතවිය හැකිය. ගිණුම සක්‍රීය වීම ප්‍රමාදනම් ( 078 880 6670 ) මෙම දුරකතන අංකය අමතන්න. 
                        </p>
                        <p style="color: #fff;">
                            අයදුම්පත් එකකට වඩා යොමු කිරීම ඔබව මෙම මෘදුකාංගය තුලින් suspend වීමට හේතුවිය හැකිය !
                        </p>
                        <p style="color: #fff;">
                            Log in විමට ඔබ Registration හි භාවිතාකල username & password භාවිතා කරන්න !
                        </p>
                        <p style="color: #fff;">
                            Thank You !
                        </p>

                        <hr style="color: #fff;">

                        <a href="index.php" class="btn btn-success w-100">Back To Login</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="style/js/my-script.js?v=<?=$version?>"></script>

<?php
 include "config/links.php";
?>

<script>

    $(document).ready(function() {
        load_batches();
    })
    
    $(document).on('submit', '#studentForm', function (e) {
        e.preventDefault();
        $('#form').addClass('d-none')
        $('#processing').removeClass('d-none')

        var formData = new FormData(this);
        formData.append("save_student", true);

        $.ajax({
            type: "POST",
            url: "ajax/student_process.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500 || res.status == 222 || res.status == 422 || res.status == 204) {
                    $('#processing').addClass('d-none')
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                    $('#form').removeClass('d-none')
                } else if(res.status == 200) {                                                         
                    $('#form').addClass('d-none')
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#studentForm')[0].reset();
                    $('#processing').addClass('d-none')
                    $('#upades').removeClass('d-none');
                };
            }
        });
    });

    function load_batches() {
        $.ajax({
            type: "POST",
            url: "Tutor-Admin/ajax/class_manage.php",
            data: {
                'load_batches': true
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(response.data);
                } else if (response.status == 200) {        
                    var save_select = $('#batch');
                    save_select.empty(); // Clear existing options
                    $.each(response.data, function(index, batch) {
                        save_select.append('<option value="' + batch.batch + '">' + batch.batch + ' A/L</option>');
                    });

                    // var edit_select = $('#classeditForm #batch');
                    // edit_select.empty(); // Clear existing options
                    // $.each(response.data, function(index, batch) {
                    //     edit_select.append('<option value="' + batch.batch + '">' + batch.batch + ' A/L</option>');
                    // });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }

</script>

</body>
</html>