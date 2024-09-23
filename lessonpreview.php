<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=auth_problem');
        exit;
    }

    if (!isset($_GET["kchordtauth"])) {
        header('Location: tutors.php?error=no_tutor_id');
        exit;
    }
    $tutor_id = $_GET['kchordtauth'];

    if (!isset($_GET["kchordcauth"])) {
        header('Location: classes.php?kchordtauth='.$tutor_id.'&error=no_class_id');
        exit;
    }
    $class_id = $_GET['kchordcauth'];

    if (!isset($_GET["kchordlauth"])) {
        header('Location: lessons.php?kchordtauth='.$tutor_id.'&kchordcauth='.$class_id.'&error=no_lesson_id');
        exit;
    }
    $lesson_id = $_GET['kchordlauth'];

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

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing-edit">
                            <img src="uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>
                </section>

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
        var lesson_id = '<?php echo isset($lesson_id) ? $lesson_id : "."; ?>';
        loadLessonPreview(lesson_id);
    });

    function loadLessonPreview(lesson_id) {
        console.log(lesson_id);
        $('#loading').removeClass('d-none');

        $.ajax({
            type: "POST",
            url: "ajax/lesson_process.php",
            data: { load_lesson_preview: true, lesson_id: lesson_id },
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
            console.log("ok");
            $('#loading').addClass('d-none');
            displayLessons(data.data);
        } else {
            console.log("not");
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
        let priceHTML = '';
        let actionForm = '';

        if (lesson.payment == 1) {
            priceHTML = `<h1>LKR ${lesson.price}.00</h1>`;
            actionForm = `
                <form id="purches_paid_lesson" action="payment.php" method="POST" class="w-50">
                    <input type="hidden" name="lesson_id" value="${lesson.id}">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">
                    <input type="hidden" name="price" value="${lesson.price}">
                    <input type="hidden" name="lesson_name" value="${lesson.name}">
                    <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                    <button type="submit" class="btn btn-success btn-lg w-100" style="background-color: #3EB649 ;">BUY</button>
                </form>
            `;
        } else if (lesson.payment == 0) {
            priceHTML = `<h1>FREE</h1>`;
            actionForm = `
                <form id="purches_free_lesson" class="w-50">
                    <input type="hidden" name="lesson_id" value="${lesson.id}">
                    <input type="hidden" name="class_id" value="<?= $class_id; ?>">
                    <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                    <button type='submit' name='submit' class="btn btn-success btn-lg w-100" style="background-color: #3EB649 ;">ADD</button>
                </form>
            `;
        }

        return `
            <div class="col-lg-6">
                <div class="class-preview-video-wrapper mb-3">
                    <img src="uploads/images/thumbnails/default.png" alt="lesson_cover.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="class-preview-details-wrapper position-relative bg-glass p-3 mb-3">
                    <h2>${lesson.name}</h2>
                    <hr>
                    <span>${lesson.discription}</span>
                </div>

                <div class="class-preview-price-wrapper position-relative mb-3 p-3">
                    ${priceHTML}
                </div>

                <div class="class-preview-btn-wrapper position-relative bg-glass">

                    <form action="lessons.php" method="POST" class="w-50">
                        <input type="hidden" name="tutor_id" value="<?=$tutor_id ?>">
                        <input type="hidden" name="class_id" value="<?=$class_id ?>">
                        <button type="submit" class="btn btn-danger btn-lg w-100" style="background-color: #EE3A25 ;">Back</button>
                    </form>
                    ${actionForm}
                </div>
            </div>
        `;
    }

    function displayErrorMessage(message) {
        $('#pagedata').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, lessons Not Found !, Please Try Again Later !.</h5>                       
                <a href="lessons.php?kchordtauth=<?=$tutor_id?>&kchordcauth=<?=$class_id?>&error=no_lesson_id" class="btn btn-danger">Back Tp Lessons</a>
            </div>`);
    }

    function handleError(err) {
        console.error("Error loading data", err);
        $('#pagedata').html('<p>An error occurred while loading data.</p>');
    }

    $(document).on('submit', '#purches_free_lesson', function (e) {
        e.preventDefault();
        $('#purches_free_lesson').addClass('d-none');
        $('#processing-create').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("add_free", true);
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "ajax/payment_process.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing-create').addClass('d-none');
                    $('#purches_free_lesson').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {        
                    $('#processing-create').addClass('d-none');                                                 
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#purches_free_lesson').removeClass('d-none');
                } else if(res.status == 422) {   
                    $('#processing-create').addClass('d-none');
                    $('#purches_free_lesson').removeClass('d-none');                                                      
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                } else if(res.status == 204) {  
                    $('#processing-create').addClass('d-none');
                    $('#purches_free_lesson').removeClass('d-none');                                                       
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

</script>


</body>
</html>