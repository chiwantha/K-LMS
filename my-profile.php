<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header('Location: index.php?error=authentication_failed_kchord_servers');
        exit();
    }

    $version = $_SESSION['css_version'];
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
                    <h3 class="fw-bold al-countdown-title ">Student Profile</h3>
                </div>

                <div class="d-flex" style="justify-content: center;">
                    <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none mt-4">
                    <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none mt-4">
                </div>

                <section class="overflow-hidden login-section position-relative">
                    <div class="text-center text-lg-start">
                        <div class="row" id="pagedata">
                            
                            <div class="col-lg-6">
                                <img src="uploads/images/res/student.jpg" id="student_image" alt="student.png" srcset="" class="profile-image mb-3">
                            </div>

                            <div class="col-lg-6">
                                <div id="form" class="card bg-glass mb-3">
                                    <div class="card-body py-4">

                                        <div class="mb-2">
                                            <h2>Profile Data</h2>
                                        </div>

                                        <hr style="color: #fff;">

                                        <form id="studentForm" class="studentFormregister">
                                            <div class="" style="color: #fff;">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="student_id">Student ID</label>
                                                            <input id="student_id" name="id" type="text" class="form-control" placeholder="Auto-generated" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input id="name" name="name" type="text" maxlength="150" class="form-control" placeholder="Kasun Chiwantha" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="batch">Batch</label>
                                                            <select id="batch" name="batch" class="form-select">
                                                                <!-- load_dynamiclu -->
                                                                <!-- Add other options -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="contact">Contact</label>
                                                            <input id="contact" name="contact" type="text" class="form-control" placeholder="0788806670" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="whatsapp">WhatsApp</label>
                                                            <input id="whatsapp" name="whatsapp" type="text" class="form-control" placeholder="0761294262" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="dob">Date of Birth</label>
                                                            <input id="dob" name="dob" type="date" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="sex">Sex</label>
                                                            <select id="sex" name="sex" class="form-select" aria-label="Default select example">
                                                                <option value="1" selected>Male</option>
                                                                <option value="0">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="school">School</label>
                                                            <input id="school" name="school" type="text" class="form-control" maxlength="150" placeholder="Padmavathie National Collage">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="image">Student Image</label>
                                                            <input id="image" type="file" class="form-control" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="username">Username</label>
                                                            <input id="username" name="username" type="text" class="form-control" placeholder="Set 10 character username (kasun@user)" maxlength="10" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="password">Password</label>
                                                            <input id="password" name="password" type="password" class="form-control" placeholder="***************" maxlength="8" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <button type="submit" id="submit" name="submit" class="btn btn-warning w-100">Update Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing">
                                    <img src="uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                                </div>

                                <a href="dashboard.php" class="btn btn-danger btn-md"> Back To Dashboard</a>
                                
                            </div>

                        </div>
                    </div>
                </section>

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
        load_batches();
        load_data();
    });

    $(document).on('submit', '#studentForm', function (e) {
        e.preventDefault();
        $('#form').addClass('d-none')
        $('#processing').removeClass('d-none')

        var formData = new FormData(this);
        formData.append("update_profile", true);

        $.ajax({
            type: "POST",
            url: "ajax/my_data_process.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing').addClass('d-none')
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                    $('#form').removeClass('d-none')
                } else if(res.status == 200) {                                                         
                    $('#form').addClass('d-none')
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#studentForm')[0].reset();
                    $('#processing').addClass('d-none')
                    $('#form').removeClass('d-none')
                    load_data();
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

    function load_data() {
        //e.preventDefault();
        const student_id = '<?php echo $_SESSION['id']; ?>';

        $.ajax({
            type: 'POST',
            url: 'ajax/my_data_process.php',
            data: {
                'id': student_id,
                'load_profile': true
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {                                                         
                    
                    $('#student_id').val(res.data.id);
                    $('#name').val(res.data.name);
                    $('#batch').val(res.data.batch);
                    $('#contact').val(res.data.contact);
                    $('#whatsapp').val(res.data.whatsapp);
                    $('#dob').val(res.data.dob);
                    $('#sex').val(res.data.sex);
                    $('#school').val(res.data.school);
                    $('#student_image').attr("src", "uploads/images/students/" + res.data.image);
                    $('#username').val(res.data.username);
                    $('#password').val(res.data.password);
                    
                };
            }
        });
    }

    function load_batches() {
        $.ajax({
            type: "POST",
            url: "Tutor-Admin/ajax/class_manage.php",
            data: {
                'load_batches': true
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(response.data);
                } else if (response.status == 200) {        
                    var save_select = $('#batch');
                    save_select.empty(); // Clear existing options
                    $.each(response.data, function(index, batch) {
                        save_select.append('<option value="' + batch.batch + '">' + batch.batch + ' A/L</option>');
                    });

                    // var edit_select = $('#classeditForm #batch');
                    // edit_select.empty(); // Clear existing options
                    // $.each(response.data, function(index, batch) {
                    //     edit_select.append('<option value="' + batch.batch + '">' + batch.batch + ' A/L</option>');
                    // });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }

</script>

</body>
</html>