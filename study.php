<?php
    session_start();
    if (!isset($_POST["lesson_id"]) || !isset($_SESSION["username"])) {
        header('Location: dashboard.php?error=no_calss_id');
        exit();
    }

    $version = $_SESSION['css_version'];

    $lesson_id = $_POST["lesson_id"];
    $class_id = $_POST["class_id"];
    $tutor_id = $_POST['tutor_id'];
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
    <link rel="stylesheet" href="style/css/class-video.css?v=<?=$version?>"/>
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
        <div class="align-items-center mb-3">

            <div class="col-lg-12 mb-lg-0 position-relative">

                <div id="radius-shape-1" class=" rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class=" shadow-5-strong"></div>

                <div class="class-preview-title-wrapper" style="text-align: center; color: #ffffff;">
                    <h3 class="fw-bold al-countdown-title ">Lesson Preview</h3>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none mt-4">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none mt-4">
                </div>

                <section class="overflow-hidden login-section">
                    <div class="text-center text-lg-start">
                        <div class="row" id="pagedata">
                            <!-- load data dynamiclly -->
                        </div>

                    </div>
                </section>

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
        var lesson_id = '<?php echo isset($_POST["lesson_id"]) ? $_POST["lesson_id"] : "."; ?>';
        loadLessonPreview(lesson_id);
    });

    function loadLessonPreview(lesson_id) {
        //console.log(lesson_id);
        $('#loading').removeClass('d-none');

        $.ajax({
            type: "POST",
            url: "ajax/my_data_process.php",
            data: { load_study: true, lesson_id: lesson_id },
            success: function(response) {
                handleLessonPreviewResponse(response);
            },
            error: function(err) {
                handleError(err);
            }
        });
    }

    function handleLessonPreviewResponse(response) {
        const data = JSON.parse(response);
        if (data.status === 200) {
            console.log("Avtivating K-Chord Server Security Protocoles ( secured by kchordgroup - www.kchord.com )");
            $('#loading').addClass('d-none');
            displayLessons(data.data);
        } else {
            console.log("Avtivating K-Chord Server Security Protocoles ( secured by kchordgroup - www.kchord.com )");
            $('#loading').addClass('d-none');
            $('#404').removeClass('d-none');
            displayErrorMessage("No Lessons Found!");
        }
    }

    function displayLessons(lessons) {
        let html = '';
        lessons.forEach(lesson => {
            html += generateLessonHTML(lesson);
        });
        $('#pagedata').html(html);
    }

    function generateLessonHTML(lesson) {
        // Determine the button HTML based on the presence of the lesson document
        const documentButtonHTML = lesson.lesson_document 
            ? `<a href="uploads/documents/${lesson.lesson_document}" download="Document" class="btn btn-success btn-lg w-100">Download Document</a>`
            : `<button class="btn btn-danger btn-lg w-100" disabled>No Document Available</button>`;

        return `
            <div class="col-lg-6">
                <div class="study-video-wrapper mb-3">
                    <iframe src="https://iframe.mediadelivery.net/embed/265576/${lesson.lesson_video}?autoplay=false&loop=false&muted=false&preload=false&responsive=false"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" loading="lazy"
                        allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;" allowfullscreen="true">
                    </iframe>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="class-preview-details-wrapper position-relative bg-glass p-3 mb-3">
                    <h2>${lesson.lesson_name}</h2>
                    <hr>
                    <span>${lesson.lesson_description}</span>
                </div>

                <div class="class-preview-btn-wrapper position-relative bg-glass mb-3">
                    ${documentButtonHTML}
                </div>

                <div class="class-preview-price-wrapper position-relative mb-3 p-3">
                    <h4>Expire Date : ${lesson.expire_date}</h4>
                </div>

                <div class="class-preview-btn-wrapper position-relative bg-glass">
                    <form action="my-lessons.php" method="POST" class="w-100">
                        <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                        <input type="hidden" name="class_id" value="<?=$class_id ?>">
                        <button type="submit" class="btn btn-danger btn-lg w-100" style="background-color: #EE3A25 ;">Back</button>
                    </form>
                </div>
            </div>
        `;
    }

    function displayErrorMessage(message) {
        $('#pagedata').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, lessons Not Found !, Please Try Again Later !.</h5>                       
                <form action="my-lessons.php" method="POST" class="w-100">
                    <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                    <input type="hidden" name="class_id" value="<?=$class_id ?>">
                    <button type="submit" class="btn btn-danger btn-lg w-100" style="background-color: #EE3A25 ;">Back</button>
                </form>
            </div>`);
    }

    function handleError(err) {
        console.error("Error loading data", err);
        $('#pagedata').html('<p>An error occurred while loading data.</p>');
    }

</script>

</body>
</html>