<?php 
    session_start();

    if (!isset($_SESSION["username"])) {
        header('location: index.php');
        exit();
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

                <div id="tutorticketform" class="card bg-glass mb-4">
                    <div class="card-body px-2 px-md-5">

                        <div class=" d-flex" style="justify-content: space-between;">
                            <h2>Tickets</h2>
                            <button type="button" onclick="toggletutorticket()" class="btn btn-warning btn-md">+ Raise</button>
                        </div>

                        <!-- <hr style="color: #fff;"> -->

                        <form id="ticketForm" class="classFormregister d-none">
                            <div class="">

                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reason">Reason</label>
                                            <select name="reason" id="reason" class="form-select" aria-label="Default select example">
                                                <option default selected>-- select --</option>
                                                <option value="0">Lesson Matter</option>
                                                <option value="1">Personal Matter</option>
                                                <option value="2">App Problem</option>
                                                <option value="3">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input name="title" type="text" maxlength="50" class="form-control" placeholder="Ticket Title">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-1" id="select-lesson" style="display: none;">
                                        <div class="form-group">
                                            <label for="lesson">Select Lesson</label>
                                            <select name="lesson" id="lesson" class="form-select" aria-label="Default select example">
                                                <!-- <option default selected>-- select --</option> -->
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="textAreaExample">Ticket Description</label>
                                        <textarea class="form-control" maxlength="250" placeholder="describe your ticket here ..." name="description" rows="4"></textarea>                                
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="teacher">Teacher</label>
                                            <select name="teacher" class="form-select" aria-label="Default select example">
                                                <option value="1" selected>Pahan Mihisanda</option>
                                                <option value="2">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-info w-100">Raise</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing-create">
                            <img src="uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>
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

                <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true" style="color: #ffffff;">
                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                        <div class="modal-content modal-content-back-glass">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ticketModalLabel">Review</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li id="ticket_title"></li>
                                    <!-- <li id="ticket_reason"></li> -->
                                    <li id="ticket_read_state"></li>
                                    <li id="ticket_message"></li>
                                    <hr>
                                    <li id="ticket_reply"></li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <div class="row mb-30" style="color: #fff; margin-left: 0px;">
                                    <!-- <span class="read d-none" id="read" style="padding: 10px; border-radius: 8px; background-color: white;  width: 40px; height: 40px; justify-content: center;"><i class="fa-solid fa-eye"></i></span>
                                    <span class="unread" id="unread" style="padding: 10px; border-radius: 8px; background-color: white; width: 40px; height: 40px; justify-content: center;"><i class="fa-solid fa-eye-slash"></i></span> -->
                                    <span>Harabara Accounting - Pahan Mihisanda</span>
                                </div>
                            </div>
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

    document.addEventListener('DOMContentLoaded', function () {
        const reasonSelect = document.getElementById('reason');
        const selectLessonDiv = document.getElementById('select-lesson');

        reasonSelect.addEventListener('change', function () {
            if (this.value === '0') {
                selectLessonDiv.style.display = 'block';
            } else {
                selectLessonDiv.style.display = 'none';
            }
        });
    });

    $(document).ready(function() {
        loadTickets();
        load_lessons();
    });

    function loadTickets() {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: 'ajax/my_data_process.php',
            type: 'POST',
            data: { load__available_Tickets: true },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 200) {
                    displayTickets(data.data);
                    $('#loading').addClass('d-none');
                } else if(data.status === 404) {
                    nodisplayTickets();
                    $('#loading').addClass('d-none');
                    $('#404').removeClass('d-none');
                } else {
                    $('#classes-container').html('<div class="col-12"><p>' + data.data + '</p></div>');
                    $('#loading').addClass('d-none');
                }
            },
            error: function() {
                $('#classes-container').html('<div class="col-12"><p>An error occurred while fetching Tickets.</p></div>');
            }
        });
    }

    function displayTickets(tickets) {
        let html = '';
        tickets.forEach(ticket => {
            html += `
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="row g-0">

                            <div class="col-md-12">
                                <div class="card-body">
                                    <h5 class="card-title">${ticket.title} - ${ticket.reason}</h5>
                                    <hr>
                                    <p class="card-text">${ticket.created_date}</p>
                                    <button value="${ticket.id}" class="viewTicket btn btn-success btn-md">View Ticket</button>
                                    <button class="delete btn btn-danger btn-md" value="${ticket.id}" style="background-color: #EE3A25;">Delete</button>
                                    <a href="dashboard.php" class="btn btn-warning btn-md">Back</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>`;
        });
        $('#classes-container').html(html);
    }

    function nodisplayTickets() {
        $('#classes-container').html(`
            <div class="position-relative" style="color:#fff;">
                <h5 class="card-title mb-3">Unfortunately, there are no Tickets available on your account.</h5>                       
                <a href="dashboard.php" class="btn btn-danger btn-md">Back To Dashboard</a>
            </div>`);
    }

    function load_lessons() {
        $.ajax({
            type: "POST",
            url: "ajax/my_data_process.php",
            data: {
                'load_lessons': true
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(response.data);
                } else if (response.status == 200) {        
                    var lesson_select = $('#lesson');
                    lesson_select.empty(); // Clear existing options
                    $.each(response.data, function(index, lesson) {
                        lesson_select.append('<option value="' + lesson.lesson_id + '">' + lesson.lesson_name + '</option>');
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

    //-----------------------------------------------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('viewTicket')) {
                var receiptModal = new bootstrap.Modal(document.getElementById('ticketModal'), {});
                receiptModal.show();
            }
        });
    });

    $(document).on('submit', '#ticketForm', function (e) {
        e.preventDefault();
        $('#ticketForm').addClass('d-none');
        $('#processing-create').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("raise_ticket", true);

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
                    $('#processing-create').addClass('d-none');
                    $('#ticketForm').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {        
                    $('#processing-create').addClass('d-none');                                                 
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#ticketForm')[0].reset();
                    $('#ticketForm').addClass('d-none');
                } else if(res.status == 422) {   
                    $('#processing-create').addClass('d-none');
                    $('#ticketForm').removeClass('d-none');                                                      
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                } else if(res.status == 204) {  
                    $('#processing-create').addClass('d-none');
                    $('#ticketForm').removeClass('d-none');                                                       
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

    $(document).on('click', '.viewTicket', function(e) {
        e.preventDefault();

        var ticket_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/my_data_process.php',
            data: {
                'id': ticket_id,
                'review_ticket': true
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {                                                         
                    
                    $state = res.data.admin_read;
                    $('#ticket_message').html('<b>Message : </b><i> ' + res.data.content + '</i>');
                    $('#ticket_reply').html('<b>Reply : </b><i> ' + res.data.reply + '</i>');
                    $('#ticket_title').html('<b>Title : </b><i> ' + res.data.title + '</i>');
                    //$('#ticket_reason').html('Reason' + res.data.reason);

                    if ($state == 0) {
                        $('#ticket_read_state').html('<b>State : </b><i> Pending </i>');
                    } else {
                        $('#ticket_read_state').html('<b>State : </b><i> Seen </i>');
                    }
                    

                };
            }
        });
    });

    $(document).on('click', '.delete', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to delete the ticket ?')) {
            var ticket_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajax/my_data_process.php',
                data: {
                    'id': ticket_id,
                    'delete_ticket': true
                },
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        $('#successToast').toast("show");
                        $('#successMessage').html(res.message);
                        loadTickets();
                    };
                }
            });
        }

    });
    
</script>

</body>
</html>