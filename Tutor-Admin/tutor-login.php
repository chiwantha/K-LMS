<?php 

    include_once '../config/config.php';

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

    <link href="../uploads/images/logo/head.png" rel="icon">
    <link href="../uploads/images/logo/head.png" rel="apple-touch-icon">

    <title>K-LMS</title>
    <link rel="stylesheet" href="../style/css/style.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/fontawesome.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/all.min.css?v=<?=$version?>"/>
    <?php 
        include_once '../style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"><img class="logo" src="../uploads/images/logo/logo.png" alt="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="../config/about.php">About</a>
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

            <div class="col-lg-12 mt-3 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div class="card bg-glass">
                    <div class="card-body px-4 py-5 px-md-5">

                        <div class="mb-4" style="text-align: center;">
                            <h2>Tutor Login</h2>
                        </div>

                        <form id="loginForm" class="hero-student-login">
                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" name="username" id="username" class="form-control" placeholder="tutor username" />
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="password" id="password" class="form-control" placeholder="tutor password" />
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="stayLoggedIn" name="stayLoggedIn">
                                <label class="form-check-label" for="stayLoggedIn" style="color: #fff;">Stay logged in</label>
                            </div>

                            <!-- Submit button -->
                            <div class="d-flex" style="justify-content: space-between;">
                                <button type="submit" id="submit" name="submit" class="btn btn-success btn-block mb-3 w-100">Login</button>
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

                        </form>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing">
                            <img src="../uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div class="box">
    <div class="container">

        <div style="justify-content: center; text-align: center;">
            <h1>
                Why Us !
            </h1>
        </div>

     	<div class="row">
			 
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-medal"></i>

                    <div class="title">
						<h4>User friendly Web</h4>
					</div>
                    
                    <div class="text">
                        <span>Interactive platform fosters student engagement and learning efficiency</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-book-open"></i>
                    
                    <div class="title">
						<h4>Covers Full Syllabus</h4>
					</div>
                        
                    <div class="text">
                        <span>Extensive curriculum ensures thorough understanding of course material</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-ranking-star"></i>

                    <div class="title">
						<h4>Quality service</h4>
					</div>

                    <div class="text">
                        <span>Exceptional support delivers superior academic assistance and guidance</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-user-graduate"></i>

                    <div class="title">
						<h4>Expert Instructors</h4>
					</div>

                    <div class="text">
                        <span>Knowledgeable educators offer expert instruction and personalized mentoring</span>
                    </div>
                    
                    </div>
            </div>	 
		
		</div>		
    </div>
</div> -->

<script src="../style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once '../config/links.php';
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
        formData.append('login_tutor', true);

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
                window.location.href = "tutor-dashboard.php";
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