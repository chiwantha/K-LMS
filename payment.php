<?php
    session_start();

    if (!isset($_POST["lesson_id"]) && !isset($_SESSION["username"]) && !isset($_POST["class_id"]) && !isset($_POST["lesson_name"]) && !isset($_POST["price"])) {
        header('Location: lessonpreview.php?error=no_lesson_id');
        exit();
    }

    $version = $_SESSION['css_version'];

    $usernmae = $_SESSION["username"];
    $lesson_id = $_POST["lesson_id"];
    $class_id = $_POST["class_id"];
    $price = $_POST["price"];
    $lesson_name = $_POST["lesson_name"];
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
    <link rel="stylesheet" href="style/css/dashboard.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/class-payment.css?v=<?=$version?>"/>
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

                <div class="class-payment-title-wrapper mb-3" style="text-align: center; color: #ffffff;">
                    <h3 class="fw-bold al-countdown-title ">Payment</h3>
                </div>

                <div class="row" id="pagedata">
                    <div class="col-lg-6">

                        <div class="u-glass class-payment-upades-wrapper mb-3">
                            <h1>ගෙවීම් උපදෙස්</h1>
                            <hr>
                            <p>පලමුව(1) ඔබ පහත සදහන් එක් බැන්කු ගිණුමකට සඳහන් මුදල තැම්පත් කරන්න</p>
                            <p>දෙවනුව(2) එම ගෙවුම් පත මෙහි උඩුගත කරන්න</p>
                            <hr>
                            <p>මෙහිදී ඔබේ ගෙවීම තහවුරු වීමට පැය කිහිපයක් ගතවිය හැකිය. අදාල ගෙවීම තහවුරු වූ පසු ඔබගේ ගිණුමට ඔබ මිලදීගත් පාඩම ඇතුලත් වේ</p>
                        </div>

                        <div class="d-flex" style="justify-content: center;">
                            <img src="uploads/images/res/loading.gif" alt="loading.gif" id="loading" class="loading_image d-none mt-4">
                            <img src="uploads/images/res/404.gif" alt="loading.gif" id="404" class="loading_image d-none mt-4">
                        </div>

                        <div class="bank-payment-slot-wrapper mb-3">
                            <div class="row" id="bank_account_details">

                                <!-- <div class="col-sm-6">
                                    <div class="bank-details-wrapper">
                                        <h4 class="bank-name">Commercial Bank</h4>
                                        <span class="bank-branch">Delgoda</span>
                                        <hr>
                                        <span class="bank-account-name">Kasun Chiwantha</span>
                                        <br>
                                        <span class="bank-account-no">12345678910</span>  
                                    </div>
                                </div> -->

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="bg-glass class-payment-form-wrapper">

                            <div class="class-payment-form-title-wrapper mb-3" style="text-align: center; color: #ffffff;">
                                <h3 class="fw-bold al-countdown-title">Purches</h3>
                            </div>

                            <div id="paymentFormContainer">
                                <form id="paymentForm" class="classFormregister">
                                    <div class="">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username">username</label>
                                                    <input name="username" type="text" value="<?=$usernmae?>" class="form-control" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ammount">paying ammount</label>
                                                    <input name="ammount" type="text" class="form-control"  value="<?=$price?>" readonly required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lesson">lesson</label>
                                                    <input name="lesson" type="text" class="form-control" value="<?=$lesson_name?>" readonly required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slip">bank slip</label>
                                                    <input type="file" class="form-control" name="slip" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="message">note</label>
                                                <textarea class="form-control" name="message" rows="3" maxlength="60" placeholder="type any message here if you want !"></textarea>                                
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 d-flex" style="gap: 1rem;">
                                                <button type="submit" id="submit" name="submit" class="btn btn-success btn-lg w-75" style="background-color: #3EB649;">Submit</button>
                                                <a href="lessons.php?class_id=<?=$class_id?>" class="btn btn-danger btn-lg w-25" style="background-color: #EE3A25;">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing">
                                <img src="uploads/images/res/processing.gif" alt="processing.gif" class="loading_image mt-4">
                            </div>

                        </div>


                        <div id="paymentdonemessage" class="b-glass d-none mt-3">
                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <img src="uploads/images/res/success.gif" alt="success.gif" style="width: 200px; margin: 25px;">
                                <h3 style="color: #ffffff;">Successfull !</h3>
                                <p>Please Goto Pending Requests on dashboard to View Pending Payment Requests</p>
                                <a href="dashboard.php" class="btn btn-warning mb-4">See All Pending Requets</a>
                            </div>
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
    </div>
</section>

<script src="style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once 'config/links.php';
?>

<script>

    $(document).ready(function() {
        loadbankAccounts();
    });

    //--------------------------------------------------------------------------

    function loadbankAccounts() {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/payment_process.php',
            type: 'POST',
            data: { load_bank: true,
                tutor_id: <?= $tutor_id ?>
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    displaybanks(data.data);
                    $('#loading').addClass('d-none');
                } else if (data.status === 404) {
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                    displayNobanksMessage();
                } else {
                    $('#loading').addClass('d-none');
                    $('#bank_account_details').html('<div class="col-12"><p>' + data.data + '</p></div>');
                }
            },
            error: function() {
                $('bank_account_details').html('<div class="col-12"><p>An error occurred while fetching banks.</p></div>');
            }
        });
    }

    function displaybanks(banks) {
        let html = '';
        banks.forEach(bank => {
            html += `
                <div class="col-sm-6">
                    <div class="bank-details-wrapper">
                        <h4 class="bank-name">${bank.bank}</h4>
                        <span class="bank-branch">${bank.branch}</span>
                        <hr>
                        <span class="bank-account-name">${bank.account_name}</span>
                        <br>
                        <span class="bank-account-no">${bank.account_no}</span>  
                    </div>
                </div>
            `;
        });
        $('#bank_account_details').html(html);
    }

    function displayNobanksMessage() {
        $('#bank_account_details').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, there are no Bank Accounts Added at the moment.</h5>                       
                <a href="classes.php" class="btn btn-danger btn-md">Back to Classes</a>
            </div>`);
    }

    //--------------------------------------------------------------------------

    $(document).on('submit', '#paymentForm', function (e) {
        e.preventDefault();
        $('#paymentForm').addClass('d-none');
        $('#processing').removeClass('d-none');

        var lesson_id = '<?=$lesson_id ?>';
        var class_id = '<?=$class_id ?>';
        var tutor_id = '<?=$tutor_id ?>';

        var formData = new FormData(this);
        formData.append("save_payment", true);
        formData.append("lesson_id", lesson_id);
        formData.append("class_id", class_id);
        formData.append("tutor_id", tutor_id);

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
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                    $('#paymentForm').removeClass('d-none');
                    $('#processing').addClass('d-none');
                } else if(res.status == 200) {                                                         
                    $('#paymentForm')[0].reset();
                    $('#paymentForm').addClass('d-none');
                    $('#processing').addClass('d-none');
                    $('#paymentdonemessage').removeClass('d-none');
                } else if(res.status == 422) {                                                         
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);
                    $('#processing').addClass('d-none');
                    $('#paymentForm').removeClass('d-none');
                } else if(res.status == 204) {                                                         
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);
                    $('#processing').addClass('d-none');
                    $('#paymentForm').removeClass('d-none');
                };
            }
        });
    });

</script>

</body>
</html>