<?php 
    session_start();

    if (!isset($_SESSION["tutor_username"])) {
        header('location: tutor-login.php');
        exit();
    }

    $version = $_SESSION['css_version'];
    $tutor_id = $_SESSION['tutor_id'];

    include_once '../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#2D436B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#2D436B">

    <link href="../uploads/images/logo/head.png" rel="icon">
    <link href="../uploads/images/logo/head.png" rel="apple-touch-icon">

    <title>K-LMS</title>
    <link rel="stylesheet" href="../style/css/style.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/fontawesome.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/all.min.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/tabs.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="../style/css/table.css?v=<?=$version?>"/>
    <?php 
        include_once '../style/css/onlinecss.php';
    ?>
</head>

<body class="background-radial-gradient">

<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="tutor-dashboard.php"><img class="logo" src="../uploads/images/logo/logo.png" alt="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="tutor-dashboard.php">Menu</a>
                </li>

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Student</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">My Class</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Payment History</a></li>
                    </ul>
                </li> -->

            </ul>

            <div class="d-flex" style="gap: 10px;">
                <a class="btn btn-danger" href="tutor-login.php">LogOut</a>
            </div>

        </div>
    </div>
</nav>

<!-- Section: Design Block -->
<section class="overflow-hidden">
    <div class="container py-1 text-center text-lg-start my-3">
        <div class="row gx-lg-5 align-items-center ">

            <div class="col-lg-12 mb-lg-0 position-relative">

                <div id="radius-shape-1" class=" rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class=" shadow-5-strong"></div>

                <div id="tutorpaymentviewform" class="card bg-glass mb-4 d-none">

                    <div class="card-body px-2 px-md-5">

                        <div class=" d-flex" style="justify-content: space-between;">
                            <h2>Review Payment</h2>
                            <button type="button" onclick="toggletutorpaymentreview()" class="btn btn-danger btn-md">x</button>
                        </div>

                        <div id="paymentForm" class="classFormregister">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_name">Student Name</label>
                                        <input id="student_name" name="student_name" type="text" class="form-control" placeholder="Student Name" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <input id="class_name" name="class_name" type="text" class="form-control" placeholder="Class Name" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lesson_name">Lesson</label>
                                        <input id="lesson_name" name="lesson_name" type="text" class="form-control" placeholder="Lesson Nmae" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="system_price">System Price</label>
                                        <input id="system_price" name="system_price" type="text" class="form-control" placeholder="1500" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-outline">
                                    <label class="form-label" for="message">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="3" readonly></textarea>                                
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="button" id="viewReceipt" class="view_recept btn btn-info w-100">View Receipt</button>
                                </div>
                            </div>

                            <hr style="color: #ffffff;">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button type="button" id="moreButton" onclick="togglerejectpayment()" class="btn btn-danger w-100" style="background-color: #ee3a25 ;">Reject</button>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <button type="button" id="approveButton" class="approve btn btn-success w-100" style="background-color: #3eb649 ;">Approve</button>
                                </div>
                            </div>
                        </div>

                        <form id="reject_payment_form" class="classFormregister d-none">

                            <input id="payment_id" name="payment_id" type="text" class="form-control" hidden readonly>
                            <input id="student_id" name="student_id" type="text" class="form-control" hidden readonly>

                            <div class="row mb-3">
                                <div class="form-outline">
                                    <label class="form-label" for="message">Reject Reason</label>
                                    <textarea class="form-control" placeholder="type reason for reject payment" maxlength="200" id="message" name="message" rows="3" required></textarea>                                
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" name="submit" id="submit" class="more btn btn-danger w-100" style="background-color: #ee3a25 ;">Proceed Rejection</button>
                            </div>

                        </form>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing-create">
                            <img src="../uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>

                </div>

                <div class="position-relative tab-container">
                    <div style="justify-content: space-between; display: flex; gap: 0.5rem;">
                        <button class="tablink" onclick="openPage('Active', this, 'glass')" id="defaultOpen">Aproved</button>
                        <button class="tablink" onclick="openPage('Pending', this, 'glass')" >Pending</button>
                        <button class="tablink" onclick="openPage('Suspend', this, 'glass')">Rejected</button>
                    </div>

                    <div id="Active" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lesson"/>
                        </div>
                        <table id="payment_table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Lesson</th>
                                    <th>Action</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>                       
                            </tfoot>
                        </table>
                    </div>

                    <!-- Pending Students Tab -->
                    <div id="Pending" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lesson"/>
                        </div>
                        <table id="payment_table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Lesson</th>
                                    <th>Action</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>                       
                            </tfoot>
                        </table>
                    </div>

                    <!-- Suspended Students Tab -->
                    <div id="Suspend" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lesson"/>
                        </div>
                        <table id="payment_table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Lesson</th>
                                    <th>Action</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>                       
                            </tfoot>
                        </table>
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

                <!-- Modal structure -->
                <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="receiptImage" src="../uploads/images/slip/" class="img-fluid" alt="Receipt">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<script src="../style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once '../config/links.php';
?>

<script>

    function openPage(pageName, element, color) {
        var searchValue = $('#search-input').val();

        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        element.style.backgroundColor = color;

        // Fetch data using AJAX
        let state;
        if (pageName === 'Active') {
            state = '1';
        } else if (pageName === 'Pending') {
            state = 'NULL';
        } else if (pageName === 'Suspend') {
            state = '0';
        }

        $.ajax({
            url: 'ajax/payment_manage.php',
            type: 'POST',
            data: {
                    'state': state,
                    'load': true,
                    tutor_id : <?=$tutor_id ?>
                },
            success: function(response) {
                $('#' + pageName + ' tbody').empty().html(response);
                initializeAllPagination();
            }
        });
    }

    //search func -------------------------------------------------------------------

    function addSearchFunctionality(searchInput, tableBody) {
        searchInput.addEventListener('keyup', function() {
            // Get the search input value
            let searchValue = this.value.toLowerCase();

            // Get the table body rows
            let rows = tableBody.getElementsByTagName('tr');

            // Loop through the table rows
            for (let i = 0; i < rows.length; i++) {
                // Get the cell that contains the student's name
                let nameCell = rows[i].getElementsByTagName('td')[0];

                if (nameCell) {
                    // Get the text content of the name cell
                    let nameText = nameCell.textContent || nameCell.innerText;

                    // Check if the name contains the search value
                    if (nameText.toLowerCase().indexOf(searchValue) > -1) {
                        rows[i].style.display = ''; // Show the row
                    } else {
                        rows[i].style.display = 'none'; // Hide the row
                    }
                }
            }

            // Reinitialize pagination after search results change
            initializeAllPagination();
        });
    }

    let searchInputs = document.querySelectorAll('input[type="search"]');
    let tableBodies = document.querySelectorAll('tbody[id$="payment_table_body"]');

    for (let i = 0; i < searchInputs.length; i++) {
        addSearchFunctionality(searchInputs[i], tableBodies[i]);
    }

    function initializeAllPagination() {
        $('table').each(function() {
            var $table = $(this);
            var $tableBody = $table.find('tbody');
            var $nav = $table.next('.nav');

            if (!$nav.length) {
                // If navigation container doesn't exist, create it
                $nav = $('<div class="nav"></div>');
                $table.after($nav);
            } else {
                // If navigation container exists, empty it
                $nav.empty();
            }

            var rowsShown = 7;
            var $studentRows = $tableBody.find('tr:visible');
            var rowsTotal = $studentRows.length;
            var numPages = Math.ceil(rowsTotal / rowsShown);
            var currentPage = 0;

            function displayPageNumbers() {
                $nav.empty();

                // Add previous page link
                var $prevLink = $('<a href="#" class="navi_prev"><</a>');
                $nav.append($prevLink);

                // Calculate which page numbers to display
                var startPage = Math.max(currentPage - 1, 0);
                var endPage = Math.min(startPage + 3, numPages);

                // Add page number links
                for (var i = startPage; i < endPage; i++) {
                    var pageNum = i + 1;
                    var $pageLink = $('<a href="#" class="navi_page" >'+ pageNum +'</a>');
                    if (i === currentPage) {
                        $pageLink.addClass('active');
                    }
                    $nav.append($pageLink);
                }

                // Add next page link
                var $nextLink = $('<a href="#" class="navi_next">></a>');
                $nav.append($nextLink);
            }

            function showRows(startItem, endItem) {
                $studentRows.hide().slice(startItem, endItem).css('display', 'table-row').fadeIn(300);
            }

            displayPageNumbers();
            showRows(0, rowsShown);

            // Pagination click event
            $nav.on('click', 'a', function(e){
                e.preventDefault();
                var $this = $(this);
                if ($this.hasClass('navi_prev')) {
                    if (currentPage > 0) {
                        currentPage--;
                    }
                } else if ($this.hasClass('navi_next')) {
                    if (currentPage < numPages - 1) {
                        currentPage++;
                    }
                } else {
                    currentPage = parseInt($this.text()) - 1;
                }
                var startItem = currentPage * rowsShown;
                var endItem = Math.min(startItem + rowsShown, rowsTotal);
                showRows(startItem, endItem);
                displayPageNumbers();
            });
        });
    }

    $(document).ready(function() {
        //$('#defaultOpen').click();
        $('.tablink').first().click();
    });

    $(document).on('click', '.gear-aproved', function(e) {
        e.preventDefault();
        $('#tutorpaymentviewform').removeClass("d-none");

        $('#moreButton').prop('disabled', false);
        $('#approveButton').prop('disabled', true);
        $('#reject_payment_form').addClass("d-none");

        var payment_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/payment_manage.php',
            data: {
                'id': payment_id,
                'review_payment': true
            },
            success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        
                        $('#payment_id').val(res.data.id);
                        $('#student_id').val(res.data.student_id);
                        $('#student_name').val(res.data.student_name);
                        $('#class_name').val(res.data.class_name);
                        $('#lesson_name').val(res.data.lesson_name);
                        $('#system_price').val(res.data.price);
                        $('#message').val(res.data.message);
                        $('#receiptImage').attr('src', "../uploads/images/slip/" + res.data.recept);
                        $('#approveButton').attr("value", res.data.id);

                    };
                }
        });
    });

    $(document).on('click', '.gear-reject', function(e) {
        e.preventDefault();
        $('#tutorpaymentviewform').removeClass("d-none");

        $('#moreButton').prop('disabled', true);
        $('#approveButton').prop('disabled', false);
        $('#reject_payment_form').addClass("d-none");

        var payment_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/payment_manage.php',
            data: {
                'id': payment_id,
                'review_payment': true
            },
            success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        
                        $('#payment_id').val(res.data.id);
                        $('#student_name').val(res.data.student_name);
                        $('#student_id').val(res.data.student_id);
                        $('#class_name').val(res.data.class_name);
                        $('#lesson_name').val(res.data.lesson_name);
                        $('#system_price').val(res.data.price);
                        $('#message').val(res.data.message);
                        $('#receiptImage').attr('src', "../uploads/images/slip/" + res.data.recept);
                        $('#approveButton').attr("value", res.data.id);

                    };
                }
        });
    });

    $(document).on('click', '.gear-pending', function(e) {
        e.preventDefault();
        $('#tutorpaymentviewform').removeClass("d-none");

        $('#moreButton').prop('disabled', false);
        $('#approveButton').prop('disabled', false);
        $('#reject_payment_form').addClass("d-none");

        var payment_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/payment_manage.php',
            data: {
                'id': payment_id,
                'review_payment': true
            },
            success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        
                        $('#payment_id').val(res.data.id);
                        $('#student_id').val(res.data.student_id);
                        $('#student_name').val(res.data.student_name);
                        $('#class_name').val(res.data.class_name);
                        $('#lesson_name').val(res.data.lesson_name);
                        $('#system_price').val(res.data.price);
                        $('#message').val(res.data.message);
                        $('#receiptImage').attr('src', "../uploads/images/slip/" + res.data.recept);
                        $('#approveButton').attr("value", res.data.id);

                    };
                }
        });
    });

    $(document).on('click', '.approve', function(e) {
        e.preventDefault();

        var payment_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/payment_manage.php',
            data: {
                'state': 1,  // 0 for suspended
                'id': payment_id,
                'aprove_payment': true
            },
            success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 500) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        $('#successToast').toast("show");
                        $('#successMessage').html(res.message);
                        $('#defaultOpen').click();
                        $('#tutorpaymentviewform').addClass('d-none');
                    } else if(res.status == 422) {                                                         
                        $('#errorToast').toast("show");
                        $('#errorToast').html(res.message);                      
                    };
                }
        });
    });

    $(document).on('submit', '#reject_payment_form', function (e) {
        e.preventDefault();

        $('#reject_payment_form').addClass('d-none');
        $('#processing-create').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("reject_payment", true);
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "ajax/payment_manage.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing-create').addClass('d-none');
                    $('#reject_payment_form').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {   
                    $('#processing-create').addClass('d-none');                                                  
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#reject_payment_form')[0].reset();
                    $('#tutorpaymentviewform').addClass('d-none');
                    $('#defaultOpen').click();
                } else if(res.status == 422) { 
                    $('#processing-create').addClass('d-none');     
                    $('#reject_payment_form').removeClass('d-none');                                                   
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                } else if(res.status == 204) { 
                    $('#processing-create').addClass('d-none');  
                    $('#reject_payment_form').removeClass('d-none');                                                      
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

    document.getElementById('viewReceipt').addEventListener('click', function() {
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'), {});
        receiptModal.show();
    });

</script>

</body>
</html>