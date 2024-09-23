<?php

    session_start();
    if (!isset($_SESSION['reset_approve'])) {
        session_abort();
        header('Location: index.php');
        exit;
    }

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

<!-- Section: Design Block -->
<section class="overflow-hidden login-section">
    <div class="container  px-md-5 text-center text-lg-start my-2">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-12 mt-3 mb-lg-0 position-relative">

                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div id="form" class="card bg-glass">
                    <div class="card-body py-4">

                        <div class="mb-4">
                            <h2>Reset Password</h2>
                        </div>

                        <hr style="color: #fff;">

                        <form id="resetForm" class="studentFormregister">
                            <div class="">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_id">Student Id</label>
                                            <input id="student_id" name="id" type="text" class="form-control" value="<?= $_SESSION['id'] ?>" placeholder="Auto-generated" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Username</label>
                                            <input id="username" name="username" type="text" maxlength="150" class="form-control" value="<?= $_SESSION['username'] ?>" placeholder="Kasun Chiwantha" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="***************" maxlength="8" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Re-Enter Password</label>
                                            <input id="re-password" name="re-password" type="password" class="form-control" placeholder="***************" maxlength="8" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-success w-100">Proceed Reset</button>
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

                <div id="upades" class="card bg-glass d-none" style="color: #fff;">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="uploads/images/res/reset.gif" alt="reset.gif" style="width: 250px;">
                    </div>
                </div>

                <div class="card bg-glass p-3 mt-3">
                    <a href="index.php" class="btn btn-danger position-relative w-100">Back To Login</a>
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
    
    $(document).on('submit', '#resetForm', function (e) {
        e.preventDefault();
        $('#form').addClass('d-none')
        $('#processing').removeClass('d-none')

        var password = $('#password').val();
        var rePassword = $('#re-password').val();

        if (password !== rePassword) {
            event.preventDefault(); // Prevent form submission
            $('#processing').addClass('d-none');
            $('#form').removeClass('d-none');
            $('#errorToast').toast("show");
            $('#errorMessage').html("Passwords do not match.");
            return;
        }

        var formData = new FormData(this);
        formData.append("reset_password", true);

        $.ajax({
            type: "POST",
            url: "ajax/student_process.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing').addClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                    $('#form').removeClass('d-none');
                } else if(res.status == 200) {                                                         
                    $('#form').addClass('d-none')
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    // $('#studentForm')[0].reset();
                    $('#processing').addClass('d-none')
                    $('#upades').removeClass('d-none');
                    <?php session_abort(); ?>
                } else if(res.status == 422) {                                                         
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);
                    $('#form').removeClass('d-none')              
                    $('#processing').addClass('d-none')    
                } else if(res.status == 204) {                                                         
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);
                    $('#form').removeClass('d-none')                
                    $('#processing').addClass('d-none')     
                };
            }
        });
    });

</script>

</body>
</html>