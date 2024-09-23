<?php 
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=auth_problem');
        exit();
    }

    $version = $_SESSION['css_version'];
    include_once 'config/config.php';
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
    <?php 
        include_once 'style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- import student navifation -->
<?php 
    include_once 'config/student_navbar.php';
?>

<!-- Section: Design Block -->
<section class="overflow-hidden">
    <div class="container py-1 text-center text-lg-start my-3">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-12 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div class="mb-3 position-relative al-countdown-wraper" style="text-align: center; color: #ffffff;">
                    <h2 class="display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">Choose Tutor</h2>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none">
                </div>

                <div class="lesson-card mb-3">
                    <div class="row" id="tutor-container">
                        <!-- Classes will be dynamically loaded here -->
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
    $(document).ready(function() {
        loadtutors();
    });

    function loadtutors() {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/tutor_process.php',
            type: 'POST',
            data: { load_tutors: true },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    displaytutors(data.data);
                    $('#loading').addClass('d-none');
                } else if(data.status === 404) {
                    nodisplaytutors();
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                } else {
                    $('#tutor-container').html('<div class="col-12"><p>' + data.data + '</p></div>');
                    $('#loading').addClass('d-none');
                }
            },
            error: function() {
                $('#tutor-container').html('<div class="col-12"><p>An error occurred while fetching tutors.</p></div>');
            }
        });
    }

    function displaytutors(tutors) {
        let html = '';
        tutors.forEach(tutor => {
            html += `
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="row g-0">

                            <div class="col-4">
                                <img src="uploads/images/tutor/${tutor.image}" class="img-fluid rounded-start" alt="...">
                            </div>

                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 18px;">${tutor.name}</h5>
                                    <hr>
                                    <div class="d-flex" style="gap:0.5rem;">
                                        <a href="classes.php?kchordtauth=${tutor.id}" class="btn btn-success btn-md w-100">View Classes</a>
                                        <a href="dashboard.php" class="btn btn-danger btn-md" style="background-color: #EE3A25 ;">back</a>
                                    </div>                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>`;
        });
        $('#tutor-container').html(html);
    }

    function nodisplaytutors() {
        $('#tutor-container').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, there are no tutors available at the moment.</h5>                       
                <a href="dashboard.php" class="btn btn-danger btn-md">Back to Dashboard</a>
            </div>`);
    }
</script>

</body>
</html>