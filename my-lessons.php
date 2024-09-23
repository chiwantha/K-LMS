<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=auth_problem');
        exit;
    }

    if (!isset($_GET["kchordtauth"])) {
        header('Location: my-tutors.php?error=no_tutor_id');
        exit;
    }
    $tutor_id = $_GET['kchordtauth'];

    if (!isset($_GET["kchordcauth"])) {
        header('Location: my-classes.php?kchordtauth='.$tutor_id.'&error=no_class_id');
        exit;
    }
    $class_id = $_GET['kchordcauth'];

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
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div class="mb-4 al-countdown-wraper" style="text-align: center; color: #ffffff;background:#3EB649;">
                    <h2 class="display-5 fw-bold ls-tight  position-relative" style="color: hsl(218, 81%, 95%)">My Lessons</h2>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none">
                </div>

                <div class="lesson-card mb-3">
                    <div class="row d-flex align-items-stretch" id="lessons-container">
                        <!-- dynamic class load here -->
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
        const class_id = '<?=$class_id ?>';
        loadLessons(class_id);
    });

    function loadLessons(class_id) {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/my_data_process.php',
            type: 'POST',
            data: { load__available_lessons: true, class_id: class_id },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    displayLessons(data.data);
                    $('#loading').addClass('d-none');
                } else if (data.status === 404) {
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                    displayNoLessonsMessage();
                } else {
                    $('#loading').addClass('d-none');
                    $('#lessons-container').html('<div class="col-12"><p>' + data.data + '</p></div>');
                }
            },
            error: function() {
                $('#lessons-container').html('<div class="col-12"><p>An error occurred while fetching lessons.</p></div>');
            }
        });
    }

    function displayLessons(lessons) {
        let html = '';
        lessons.forEach(lesson => {
            html += `
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card lesson-card h-100">
                        <div class="row g-0">

                            <div class="col-4">
                                <img src="uploads/images/lessons/default.png" class="img-fluid rounded-start" alt="...">
                            </div>

                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size:15px;">${lesson.lesson_name}</h5>
                                    <hr>
                                    <div class="d-flex" style="gap:0.5rem;">
                                        <form action="study.php" method="POST" class="w-100">
                                            <input type="hidden" name="lesson_id" value="${lesson.lesson_id}">
                                            <input type="hidden" name="class_id" value="<?= $class_id ?>">
                                            <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                                            <button type="submit" class="btn btn-success btn-sm w-100">Attend</button>
                                        </form>
                                        <form action="my-classes.php" method="POST">
                                            <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Back</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>`;
        });
        $('#lessons-container').html(html);
    }

    function displayNoLessonsMessage() {
        $('#lessons-container').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, there are no lessons available at the moment.</h5>                       
                <form action="my-classes.php" method="POST">
                    <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                    <button type="submit" class="btn btn-danger btn-md">Back</button>
                </form>
            </div>`);
    }

</script>

</body>
</html>