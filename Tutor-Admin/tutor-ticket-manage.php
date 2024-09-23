<?php
    session_start();

    if (!isset($_SESSION["tutor_username"])) {
        header('Location: tutor-login.php');
        exit();
    }

    $version = $_SESSION['css_version'];
    $tutor_id = $_SESSION['tutor_id'];

    include_once "../config/config.php";

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
    <link rel="stylesheet" href="../style/css/dashboard.css?v=<?=$version?>"/>
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

                <div class="position-relative tab-container">
                    <div style="justify-content: space-between; display: flex; gap: 0.5rem;">
                        <button class="tablink" onclick="openPage('Active', this, 'glass')" id="defaultOpen" style="width: 50%;">Unread</button>
                        <button class="tablink" onclick="openPage('Suspend', this, 'glass')" style="width: 50%;">Seen</button>
                    </div>

                    <div id="Active" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Student"/>
                        </div>
                        <table id="ticket_table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>View</th>
                                </tr>                       
                            </thead>
                            <tbody id="ticket_table_body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>                       
                            </tfoot>
                        </table>
                    </div>

                    <!-- Suspended Students Tab -->
                    <div id="Suspend" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Ticket"/>
                        </div>
                        <table id="ticket_table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>View</th>
                                </tr>                       
                            </thead>
                            <tbody id="ticket_table_body">
                                <!-- Data will be loaded here by AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
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

                <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true" style="color: #ffffff;">
                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                        <div class="modal-content modal-content-back-glass">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ticketModalLabel">View</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <ul style="list-style: none;">
                                        <li id="ticket_id"></li>
                                        <li id="ticket_title"></li>
                                        <hr>
                                        <li id="ticket_message"></li>
                                        <hr>
                                        <li id="ticket_reply"></li>
                                        <hr>
                                    </ul>
                                    <div>
                                        <label for="ticket_reply_input" class="mb-2" style="font-weight: 600;">New Reply Push</label>
                                        <textarea id="ticket_reply_input" class="form-control" maxlength="500" rows="6" placeholder="Please Enter Your Reply Here" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success submit-reply" id="submit_reply">Save Reply</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php
    include_once '../config/links.php';
?>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.getElementById("ticket_reply_input");
        const submitButton = document.getElementById("submit_reply");

        textarea.addEventListener("keydown", function(event) {
            if (event.key === "Enter" && !event.shiftKey) { // Only trigger on Enter without Shift
                event.preventDefault(); // Prevent default Enter behavior (new line)
                submitButton.click(); // Trigger the submit button click
            }
        });
    });

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
            state = '0';
        } else if (pageName === 'Pending') {
            state = 'NULL';
        } else if (pageName === 'Suspend') {
            state = '1';
        }

        $.ajax({
            url: 'ajax/ticket_manage.php',
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
    let tableBodies = document.querySelectorAll('tbody[id$="ticket_table_body"]');

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

    $(document).on('click', '.viewTicket', function(e) {
        e.preventDefault();

        var ticket_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/ticket_manage.php',
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
                    // $('#successToast').toast("show");
                    // $('#successMessage').html(res.message);
                    $('#submit_reply').val(res.data.id);
                    $state = res.data.admin_read;
                    $('#ticket_message').html('<b>Message : </b><i> ' + res.data.content + '</i>');
                    $('#ticket_id').html('<b>Ticket Id : </b><i> ' + res.data.id + '</i>');
                    $('#ticket_reply').html('<b>Reply : </b><i> ' + res.data.reply + '</i>');
                    $('#ticket_title').html('<b>Title : </b><i> ' + res.data.title + '</i>');
                };
            }
        });
    });

    $(document).on('click', '.submit-reply', function(e) {
        e.preventDefault();

        var reply = $('#ticket_reply_input').val();
        var ticket_id = $('#submit_reply').val();

            $.ajax({
                type: 'POST',
                url: 'ajax/ticket_manage.php',
                data: {
                    'id': ticket_id,
                    'reply': reply,
                    'reply_ticket': true
                },
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 500) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        $('#successToast').toast("show");
                        $('#successMessage').html(res.message);
                        $('#ticket_reply_input').empty();
                        $('#ticketModal').modal('hide');
                        $('#defaultOpen').click();
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