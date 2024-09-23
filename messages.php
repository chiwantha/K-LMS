<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=authentications-error');
        exit;
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

                <div class="mb-4" style="text-align: center; color: #ffffff;">
                    <h2 class="mb-3 display-5 fw-bold ls-tight  position-relative" style="color: hsl(218, 81%, 95%)">Messages</h2>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none">
                </div>

                <div class="lesson-card mb-3">
                    <div class="row d-flex align-items-stretch" id="message-container">
                        <!-- dynamic class load here -->
                    </div>
                </div>
            </div>
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

    </div>
</section>

<script src="style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once 'config/links.php';
?>

<script>

    $(document).ready(function() {
        loadMessages();
    });

    function loadMessages() {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/my_data_process.php',
            type: 'POST',
            data: { load_messages: true},
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    console.log("ok");
                    displayMessages(data.data);
                    $('#loading').addClass('d-none');
                } else if (data.status === 404) {
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                    displayNoMessagesMessage();
                } else {
                    $('#loading').addClass('d-none');
                    $('#message-container').html('<div class="col-12 p-3"><p>' + data.data + '</p></div>');
                }
            },
            error: function() {
                $('#message-container').html('<div class="col-12"><p>An error occurred while fetching message.</p></div>');
            }
        });
    }

    function displayMessages(messages) {
        let html = '';
        messages.forEach(message => {
            if (message.state == 1) {
                html += `
                <div class="col-lg-6 mb-3">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">${message.title}</h4>
                        <p>${message.message}</p>
                        <p>${message.date}</p>
                        <hr>
                        <button class="mark_read btn btn-danger" value="${message.id}">Delete This Message</button>
                    </div>
                </div>`;
            } else if (message.state == 2) {
                html += `
                <div class="col-lg-6 mb-3">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">${message.title}</h4>
                        <p>${message.message}</p>
                        <p>${message.date}</p>
                    </div>
                </div>`;
            }
        });
        $('#message-container').html(html);
    }

    function displayNoMessagesMessage() {
        $('#message-container').html(`
            <div class="position-relative" style="color:#fff;margin:10px;">
                <h5 class="card-title mb-3">Unfortunately, there are no New Messages available</h5>                       
                <a href="dashboard.php" class="btn btn-danger btn-md">Back to Dashboard</a>
            </div>`);
    }

    $(document).on('click', '.mark_read', function(e) {
        e.preventDefault();

        var message_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/my_data_process.php',
            data: {
                'id': message_id,
                'mark_as_read': true
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {                                                         
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    loadMessages();
                } else if(res.status == 422) {                                                         
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

</script>

</body>
</html>