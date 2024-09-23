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

                <div id="tutorlessonform" class="card bg-glass mb-4">
                    <div class="card-body px-2 px-md-5">

                        <div class=" d-flex" style="justify-content: space-between;">
                            <h2>Lesson Creation</h2>
                            <button type="button" onclick="toggletutorlesson()" class="btn btn-warning btn-md"> New Lesson +</button>
                        </div>

                        <!-- <hr style="color: #fff;"> -->

                        <div id="formContainer" class="d-none">

                            <form id="lessonVideoForm" class="classFormregister mt-3">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="video">Upload Video</label>
                                            <input id="video" type="file" class="form-control" name="video">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="">*</label>
                                        <button type="button" id="upload" class="btn btn-info w-100" style="height:40px;">Upload</button>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="">Uploading Progress</label>
                                        <div class="progress" style="height: 40px;">
                                            <div id="progressBar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Progress 0%</div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <hr style="color: #ffffff;">

                            <form id="lessonForm" class="classFormregister">
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="video-id" name="video_id" type="text" class="form-control" placeholder="Video id is Pending" style="text-align: center;" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lessonId">Lesson ID</label>
                                            <input id="lesson-id" name="id" type="text" class="form-control" placeholder="Auto-generated" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lessonName">Name</label>
                                            <input id="lesson-name" name="name" type="text" class="form-control" placeholder="ගිණුම්කරණය හා එහි අවශ්‍යතාවය" maxlength="150" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" class="form-control" name="description" rows="4" maxlength="250" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="class">Class</label>
                                                    <select id="class" name="class" class="form-select" aria-label="Default select example" required>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="document">Upload Document</label>
                                                    <input id="document" type="file" class="form-control" name="document" accept=".pdf">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mt-2">
                                                    <label for="payment">Payment</label>
                                                    <select id="payment" name="payment" class="form-select" aria-label="Default select example" required>
                                                        <option value="1" selected>Paid</option>
                                                        <option value="0">Free</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mt-2">
                                                    <label for="price">Price</label>
                                                    <input id="price" name="price" type="number" class="form-control" placeholder="1850" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-success w-100">Create Lesson</button>
                                    </div>
                                </div>
                                
                            </form>

                        </div>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing-create">
                            <img src="../uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>
                </div>

                <div id="tutorlessoneditform" class="card bg-glass mb-4 d-none">
                    <div class="card-body px-2 px-md-5">

                        <div class=" d-flex" style="justify-content: space-between;">
                            <h2>Lesson Edit</h2>
                            <button type="button" onclick="toggletutoreditlesson()" class="btn btn-danger btn-md">x</button>
                        </div>

                        <form id="lessonVideoeditForm" class="classFormregister mt-3">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="video-edit">Upload Video</label>
                                        <input id="video-edit" type="file" class="form-control" name="video">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="">*</label>
                                    <button type="button" id="upload-edit" class="btn btn-info w-100" style="height:40px;">Upload</button>
                                </div>
                                <div class="col-md-6">
                                    <label class="">Uploading Progress</label>
                                    <div class="progress" style="height: 40px;">
                                        <div id="progressBar-edit" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Progress 0%</div>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <hr style="color: #ffffff;">

                        <form id="lessoneditForm" class="classFormregister">
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="video-id-edit" name="video_id" type="text" class="form-control" placeholder="Video id is Pending" style="text-align: center;" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lessonId-edit">Lesson ID</label>
                                        <input id="lesson-id-edit" name="id" type="text" class="form-control" placeholder="Auto-generated" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lessonName-edit">Name</label>
                                        <input id="lesson-name-edit" name="name" type="text" class="form-control" placeholder="ගිණුම්කරණය හා එහි අවශ්‍යතාවය" maxlength="150" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description-edit">Description</label>
                                        <textarea id="description-edit" class="form-control" name="description" rows="4" maxlength="250" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="class-edit">Class</label>
                                                <select id="class-edit" name="class" class="form-select" aria-label="Default select example" required>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="document-edit">Upload Document</label>
                                                <input id="document-edit" type="file" class="form-control" name="document" accept=".pdf">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-2">
                                                <label for="payment-edit">Payment</label>
                                                <select id="payment-edit" name="payment" class="form-select" aria-label="Default select example" required>
                                                    <option value="1" selected>Paid</option>
                                                    <option value="0">Free</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-2">
                                                <label for="price-edit">Price</label>
                                                <input id="price-edit" name="price" type="number" class="form-control" placeholder="1850" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" id="submit-edit" name="submit" class="btn btn-success w-100">Update Lesson</button>
                                </div>
                            </div>
                            
                        </form>

                        <div class="d-flex mb-3 d-none" style="justify-content: center;" id="processing-edit">
                            <img src="../uploads/images/res/waiting.gif" alt="waiting.gif" class="loading_image mt-4">
                        </div>

                    </div>
                </div>

                <div class="position-relative tab-container">
                    <div style="justify-content: space-between; display: flex; gap: 0.5rem;">
                        <button class="tablink" onclick="openPage('Active', this, 'glass')" id="defaultOpen" style="width: 50%;">Active</button>
                        <button class="tablink" onclick="openPage('Suspend', this, 'glass')" style="width: 50%;">Suspend</button>
                    </div>

                    <div id="Active" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lessons"/>
                        </div>
                        <table id="lesson_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>                       
                            </thead>
                            <tbody id="lesson_table_body">
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

                    <div id="Suspend" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lessons"/>
                        </div>
                        <table id="lesson_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>                       
                            </thead>
                            <tbody id="lesson_table_body">
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

            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/tus-js-client@2.3.0/dist/tus.min.js"></script>
<script src="../style/js/my-script.js?v=<?=$version?>"></script>
<script src="../style/js/upload-video.js?v=<?=$version?>"></script>

<?php
    include_once '../config/links.php';
?>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        const submitButton = document.getElementById("submit-edit");
        const form = document.getElementById("lessoneditForm");
        const videoIdInput = document.getElementById("video-id-edit");
        const lessonNameInput = document.getElementById("lesson-name-edit");
        const descriptionInput = document.getElementById("description-edit");
        const classSelect = document.getElementById("class-edit");
        const paymentSelect = document.getElementById("payment-edit");
        const priceInput = document.getElementById("price-edit");
        const documentInput = document.getElementById("document-edit");

        // Disable submit button on load
        submitButton.disabled = true;

        // Function to check form validity
        function checkFormValidity() {
            if (videoIdInput.value.trim() !== "" &&
                lessonNameInput.value.trim() !== "" &&
                descriptionInput.value.trim() !== "" &&
                classSelect.value.trim() !== "" &&
                paymentSelect.value.trim() !== "" &&
                priceInput.value.trim() !== "") {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Event listeners for all input fields
        videoIdInput.addEventListener("input", checkFormValidity);
        lessonNameInput.addEventListener("input", checkFormValidity);
        descriptionInput.addEventListener("input", checkFormValidity);
        classSelect.addEventListener("change", checkFormValidity);
        paymentSelect.addEventListener("change", checkFormValidity);
        priceInput.addEventListener("input", checkFormValidity);

        // Event listener for document file size validation
        documentInput.addEventListener("change", function() {
            const file = documentInput.files[0];
            if (file && file.size > 10485760) { // 10MB in bytes
                $('#errorToast').toast("show");
                $('#errorMessage').html('Only files up to 10MB are accepted !');
                documentInput.value = ""; // Clear the input
            }
        });

        // Check form validity on load
        checkFormValidity();
    });

    function loadClassOptions() {
        $.ajax({
            method: 'POST',
            url: 'ajax/lesson_manage.php',
            data: {
                    'load_classes': true,
                    tutor_id : <?=$tutor_id ?>
                },
            dataType: 'json',
            success: function(data) {
                var classSelect = $('#class');
                classSelect.empty(); // Clear existing options
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                data.forEach(function(classItem) {
                    var option = $('<option></option>')
                        .attr('value', classItem.id)
                        .text(classItem.name);
                    classSelect.append(option);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching class options:', textStatus, errorThrown);
            }
        });
    }

    function loadClassOptionsedit() {
        $.ajax({
            method: 'POST',
            url: 'ajax/lesson_manage.php',
            data: {
                    'load_classes': true,
                    tutor_id : <?=$tutor_id ?>
                },
            dataType: 'json',
            success: function(data) {
                var classSelect = $('#class-edit');
                classSelect.empty(); // Clear existing options
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                data.forEach(function(classItem) {
                    var option = $('<option></option>')
                        .attr('value', classItem.id)
                        .text(classItem.name);
                    classSelect.append(option);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching class options:', textStatus, errorThrown);
            }
        });
    }

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
            url: 'ajax/lesson_manage.php',
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
    let tableBodies = document.querySelectorAll('tbody[id$="lesson_table_body"]');

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
        loadClassOptions();
        loadClassOptionsedit();
    });

    $(document).on('click', '.suspend', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to Suspend lesson ?')) {
            var lesson_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajax/lesson_manage.php',
                data: {
                    'state': 0,  // 0 for suspended
                    'id': lesson_id,
                    'update_lesson_state': true
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
                    } else if(res.status == 422) {                                                         
                        $('#errorToast').toast("show");
                        $('#errorToast').html(res.message);                      
                    };
                }
            });
        }
    });

    $(document).on('click', '.activate', function(e) {
        e.preventDefault();

        var lesson_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/lesson_manage.php',
            data: {
                'state': 1,  // 0 for suspended
                'id': lesson_id,
                'update_lesson_state': true
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
                    } else if(res.status == 422) {                                                         
                        $('#errorToast').toast("show");
                        $('#errorToast').html(res.message);                      
                    };
                }
        });
    });

    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#lessonVideoeditForm')[0].reset();
        $('#lessoneditForm')[0].reset();
        $('#tutorlessoneditform').removeClass("d-none");

        var lesson_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajax/lesson_manage.php',
            data: {
                'id': lesson_id,
                'edit_lesson': true
            },
            success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        $('#errorToast').toast("show");
                        $('#errorMessage').html(res.message);
                    } else if(res.status == 200) {                                                         
                        $('#video-id-edit').val(res.data.video_id);
                        $('#lesson-id-edit').val(res.data.id);
                        $('#lesson-name-edit').val(res.data.name);
                        $('#description-edit').val(res.data.discription);
                        $('#class-edit').val(res.data.class);
                        $('#payment-edit').val(res.data.payment);
                        $('#price-edit').val(res.data.price);
                    };
                }
        });
    });

    //subminations func -------------------------------------------------------------------

    $(document).on('submit', '#lessonForm', function (e) {
        e.preventDefault();
        $('#lessonForm').addClass('d-none');
        $('#lessonVideoForm').addClass('d-none');
        $('#processing-create').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("save_lesson", true);
        formData.append("tutor_id", <?=$tutor_id ?> );

        $.ajax({
            type: "POST",
            url: "ajax/lesson_manage.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing-create').addClass('d-none');
                    $('#lessonForm').removeClass('d-none');
                    $('#lessonVideoForm').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {         
                    $('#processing-create').addClass('d-none');                                                
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#lessonForm')[0].reset();
                    $('#lessonVideoForm')[0].reset();
                    //$('#classForm').addClass('d-none');
                    $('#defaultOpen').click();
                } else if(res.status == 422) {     
                    $('#processing-create').addClass('d-none');  
                    $('#lessonForm').removeClass('d-none');
                    $('#lessonVideoForm').removeClass('d-none');                                                  
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                } else if(res.status == 204) {                                                         
                    $('#processing-create').addClass('d-none');
                    $('#lessonForm').removeClass('d-none');
                    $('#lessonVideoForm').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

    $(document).on('submit', '#lessoneditForm', function (e) {
        e.preventDefault();
        $('#lessoneditForm').addClass('d-none');
        $('#lessonVideoeditForm').addClass('d-none');
        $('#processing-edit').removeClass('d-none');

        var formData = new FormData(this);
        formData.append("update_lesson", true);
        //console.log(formData);

        $.ajax({
            type: "POST",
            url: "ajax/lesson_manage.php",
            data: formData,
            dataType: "",
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 500) {
                    $('#processing-edit').addClass('d-none');
                    $('#lessonVideoeditForm').removeClass('d-none');
                    $('#lessoneditForm').removeClass('d-none');
                    $('#errorToast').toast("show");
                    $('#errorMessage').html(res.message);
                } else if(res.status == 200) {      
                    $('#processing-edit').addClass('d-none');    
                    $('#lessonVideoeditForm').removeClass('d-none');
                    $('#lessoneditForm').removeClass('d-none');                                           
                    $('#successToast').toast("show");
                    $('#successMessage').html(res.message);
                    $('#lessoneditForm')[0].reset();
                    $('#lessonVideoeditForm')[0].reset();
                    $('#defaultOpen').click();
                } else if(res.status == 422) {     
                    $('#processing-edit').addClass('d-none');
                    $('#lessonVideoeditForm').removeClass('d-none');
                    $('#lessoneditForm').removeClass('d-none');                                                    
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                } else if(res.status == 204) {         
                    $('#processing-edit').addClass('d-none');
                    $('#lessonVideoeditForm').removeClass('d-none');
                    $('#lessoneditForm').removeClass('d-none');                                                
                    $('#errorToast').toast("show");
                    $('#errorToast').html(res.message);                      
                };
            }
        });
    });

</script>

</body>
</html>