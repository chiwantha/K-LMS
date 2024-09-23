<?php 
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=auth_problem');
        exit();
    }

    if (!isset($_GET["kchordtauth"])) {
        header('location: my-tutors.php?error=invalid_tutor_id');
        exit();
    }
    $tutor_id = $_GET['kchordtauth'];

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

                <div class="mb-4 position-relative al-countdown-wraper" style="text-align: center; color: #ffffff;background:#3EB649;">
                    <h2 class="display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">My Classes</h2>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none">
                </div>

                <div class="lesson-card mb-3">
                    <div class="row" id="classes-container">
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
        loadClasses();
    });

    function loadClasses() {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/my_data_process.php',
            type: 'POST',
            data: { load__available_classes: true, tutor_id : <?=$tutor_id ?> },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    displayClasses(data.data);
                    $('#loading').addClass('d-none');
                } else if(data.status === 404) {
                    nodisplayClasses();
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                } else {
                    $('#classes-container').html('<div class="col-12"><p>' + data.data + '</p></div>');
                    $('#loading').addClass('d-none');
                }
            },
            error: function() {
                $('#classes-container').html('<div class="col-12"><p>An error occurred while fetching classes.</p></div>');
            }
        });
    }

    function displayClasses(classes) {
        let html = '';
        classes.forEach(cls => {
            html += `
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="row g-0">

                            <div class="col-md-4">
                                <img src="uploads/images/classes/${cls.class_image}" class="img-fluid rounded-start" alt="...">
                            </div>

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${cls.class_name}</h5>
                                    <hr>
                                    <p class="card-text">${cls.class_description}</p>
                                    <div class="d-flex" style="gap:0.5rem;">
                                        <a href="my-lessons.php?kchordtauth=<?=$tutor_id ?>&kchordcauth=${cls.class_id}" class="btn btn-success btn-md w-100">View Lessons</a>
                                        <a href="my-tutors.php" class="btn btn-danger btn-md" style="background-color: #EE3A25 ;">back</a>
                                    </div> 
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>`;
        });
        $('#classes-container').html(html);
    }

    function nodisplayClasses() {
        $('#classes-container').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, there are no Classes available on your account.</h5>                       
                <a href="tutors.php" class="btn btn-danger btn-md">Class Store</a>
                <a href="my-tutors.php" class="btn btn-danger btn-md">Back To Dashboard</a>
            </div>`);
    }
</script>

</body>
</html>