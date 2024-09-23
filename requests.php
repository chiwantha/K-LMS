<?php 
    session_start();

    if (!isset($_SESSION["username"]) && !isset($_SESSION["id"])) {
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
    <link rel="stylesheet" href="style/css/tabs.css?v=<?=$version?>"/>
    <link rel="stylesheet" href="style/css/table.css?v=<?=$version?>"/>
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
        <div class="row gx-lg-5 align-items-center ">

            <div class="col-lg-12 mb-lg-0 position-relative">

                <div id="radius-shape-1" class=" rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class=" shadow-5-strong"></div>

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
                                    <th>Lesson</th>
                                    <th>Yay</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
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

                    <!-- Pending Students Tab -->
                    <div id="Pending" class="tabcontent">
                        <div class="input-group position-relative">
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lesson"/>
                        </div>
                        <table id="payment_table">
                            <thead>
                                <tr>
                                    <th>Lesson</th>
                                    <th>Options</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
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
                            <input id="search-input" type="search" class="form-control rounded-0" placeholder="Search Lesson"/>
                        </div>
                        <table id="payment_table">
                            <thead>
                                <tr>
                                    <th>Lesson</th>
                                    <th>Options</th>
                                </tr>                       
                            </thead>
                            <tbody id="payment_table_body">
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

<!-- <div class="box">
    <div class="container">

        <div style="justify-content: center; text-align: center;">
            <h1>
                Why Us !
            </h1>
        </div>

     	<div class="row">
			 
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-medal"></i>

                    <div class="title">
						<h4>User friendly Web</h4>
					</div>
                    
                    <div class="text">
                        <span>Interactive platform fosters student engagement and learning efficiency</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-book-open"></i>
                    
                    <div class="title">
						<h4>Covers Full Syllabus</h4>
					</div>
                        
                    <div class="text">
                        <span>Extensive curriculum ensures thorough understanding of course material</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-ranking-star"></i>

                    <div class="title">
						<h4>Quality service</h4>
					</div>

                    <div class="text">
                        <span>Exceptional support delivers superior academic assistance and guidance</span>
                    </div>

                    </div>
            </div>	 
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            
                <div class="box-part text-center">
                    
                    <i class="fa fa-solid fa-user-graduate"></i>

                    <div class="title">
						<h4>Expert Instructors</h4>
					</div>

                    <div class="text">
                        <span>Knowledgeable educators offer expert instruction and personalized mentoring</span>
                    </div>
                    
                    </div>
            </div>	 
		
		</div>		
    </div>
</div> -->

<script src="style/js/my-script.js?v=<?=$version?>"></script>

<?php
    include_once 'config/links.php';
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
            url: 'ajax/payment_process.php',
            type: 'POST',
            data: {
                    'state': state,
                    'load': true
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

    $(document).on('click', '.suspend', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to Delete the Request ?')) {
            var payment_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajax/payment_process.php',
                data: {
                    'id': payment_id,
                    'delete_payment': true
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

</script>

</body>
</html>