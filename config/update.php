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
                    <h3 class="fw-bold al-countdown-title ">Update New Version</h3>
                    <hr>
                    <p>     
                        APP යාවත්කාලීන කිරීමෙන් පසු, පද්ධතිය නව configurations ක්‍රියාවට නංවන අතර කාර්ය optimize කරන බැවින් ඔබට 
                        මන්දගාමී ආරම්භක භාවිතයක් අත්විඳිය හැකිය. සහතික වන්න, මෙය එක් වරක් 
                        සිදුවීමක් වන අතර, APP පසුකාලීන භාවිතයන්හිදී සාමාන්‍යයෙන් සහ කාර්යක්ෂමව ක්‍රියා කරයි.
                    </p>
                    <p>
                        After updating the app, you might experience a slower initial use as the system processes new configurations and optimizes performance. 
                        Rest assured, this is a one-time occurrence, and the app will function normally and efficiently in subsequent uses.
                    </p>
                    <hr>
                    <p style="font-size: large;">
                        For desktop users, visit <a style="color: yellow;" href="http://www.harabaraaccounting.kchord.com" target="_blank">www.harabaraaccounting.kchord.com</a> to access the 
                        platform. You can use it both as an app and a web application.
                    </p>
                    <hr>
                    <p>#KChordGroup #SoftwareDevelopment #Web&SoftwareSolutions <br> <a style="color: yellow;" href="http://www.kchord.com" target="_blank">www.kchord.com</a></p>
                    
                    <hr>

                    <div class="loaders d-none" id="loaders">
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                Clear Current Files ... 
                            </div>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                Copying New Files ... 
                            </div>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                Making Server Configurations ... 
                            </div>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                Finalizing & Done ! ... 
                            </div>
                        </div>
                    </div>

                    <div class="d-flex tutor-data-btn-row mb-2">
                        <button class="btn btn-info tutor-data-btn uppp w-100" id="update_btn" style="font-size: 1.5rem;">Update</button>
                    </div>
                </div>

                <div class="tutor-data-wraper" style="text-align: center; color: #ffffff;">
                    <div class="d-flex tutor-data-btn-row">
                        <a href="../index.php" class="btn btn-success tutor-data-btn" style="background: #EE3A25; font-size: 1rem;">Back To Login</a>
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

<script>

    $(document).ready(function() {
        $(".uppp").click(function() {
            if (confirm("Are you sure you want to start the process?")) {
                $('#update_btn').addClass('d-none');
                $('#loaders').removeClass('d-none');

                startLoading();
            }
        });
    });

    function loadProgressBar(selector, callback) {
        var progress = 0;
        var interval = setInterval(function() {
            progress += Math.floor(Math.random() * 10) + 1; // Random speed between 1 and 10
            if (progress > 100) progress = 100;
            $(selector).css('width', progress + '%').attr('aria-valuenow', progress);
            if (progress >= 100) {
                clearInterval(interval);
                if (callback) callback();
            }
        }, Math.random() * 300); // Random interval between 0 and 300 ms
    }

    function startLoading() {
        loadProgressBar('.bg-success', function() {
            loadProgressBar('.bg-info', function() {
                loadProgressBar('.bg-warning', function() {
                    loadProgressBar('.bg-danger', function() {
                        clearCache(); // Clear cache after all progress bars are loaded
                    });
                });
            });
        });
    }

    function clearCache() {
        clearOldAppCache();
    }

    function clearOldAppCache() {
        if ('applicationCache' in window) {
            var appCache = window.applicationCache;

            // Check if there is any cache to clear
            if (appCache.status === appCache.UPDATEREADY) {
                // Remove old cache
                appCache.swapCache();
                console.log('Old app cache cleared and new cache swapped.');
            } else {
                console.log('No update available for the application cache.');
            }
        } else {
            console.log('Application Cache is not supported.');
        }
    }

</script>

</body>
</html>