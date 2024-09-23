<?php

    include_once 'config.php';

    $version = get_versions($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pahan Mihisanda</title>
    <link rel="stylesheet" href="../style/css/style.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/fontawesome.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/all.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/dashboard.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/about.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/class-video.css?v=<?=$version?>"/>
    <?php 
        include_once '../style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: Design Block -->
<section class="overflow-hidden">
    <div class="container py-1 text-center text-lg-start my-3">
        <div class="row gx-lg-5 align-items-center mb-3">

            <div class="col-lg-12 mb-lg-0 position-relative">
                
                <div id="radius-shape-1" class=" rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class=" shadow-5-strong"></div>

                <div class="my-data-wraper p-3" style="text-align: center; color: #ffffff;">
                    <h3 class="fw-bold al-countdown-title ">Hara Bara Accounting</h3>
                    <hr>
                    <p>
                        Hara Bara Accounting is a user-friendly Learning Management System (LMS) developed by K-Chord Group specifically for Sir Pahan Mihisanda. 
                        This innovative platform streamlines the teaching and learning of accounting principles, offering interactive modules, comprehensive resources, 
                        and intuitive tools to facilitate effective learning experiences.
                    </p>
                    <p>
                        K-Chord Group, renowned for its expertise in software development and marketing solutions, has ensured that Hara Bara Accounting stands out 
                        with its robust features and seamless user experience. Whether you are a student or an educator, this app is designed to make the learning of 
                        accounting both engaging and efficient.
                    </p>
                    <hr>
                    <p style="font-size: large;">
                        For desktop users, visit <a style="color: yellow;" href="http://www.harabaraaccounting.kchord.com" target="_blank">www.harabaraaccounting.kchord.com</a> to access the 
                        platform. You can use it both as an app and a web application.
                    </p>
                    <hr>
                    <p>#KChordGroup #SoftwareDevelopment #Web&SoftwareSolutions</p>
                    <span style="color: #fff;">Server:#<?=$version?>@unitedState</span>
                </div>

                <div class="study-video-wrapper mb-3 d-none" id="tutorial_player">
                    <iframe src="https://www.youtube.com/embed/wJCZj6EEdzM?si=8vhW5Qfk-eqthXWX"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" loading="lazy"
                        allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;" allowfullscreen="true">
                    </iframe>
                </div>

                <div class="tutor-data-wraper" style="text-align: center; color: #ffffff;">
                    <div class="d-flex tutor-data-btn-row mb-2">
                        <button class="btn btn-success tutor-data-btn" style="background: #3EB649; font-size: 1.6rem;" onclick="howtouse()">How To Use</button>
                        <a href="https://www.facebook.com/pahan.mihisanda?mibextid=ZbWKwL" target="new" class="btn btn-primary tutor-data-btn" style="font-size: 1.6rem;">About Tutor</a>
                    </div>
                    <div class="d-flex tutor-data-btn-row">
                        <a href="../index.php" class="btn btn-success tutor-data-btn" style="background: #EE3A25; font-size: 1.6rem;">Back To Login</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<script src="../style/js/my-script.js?v=<?=$version?>"></script>
<script src="../style/js/dashboard.js?v=<?=$version?>"></script>

<?php
    include_once '../config/links.php';
?>

</body>
</html>