<!-- Section: navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand btn btn-primary" href="dashboard.php" style="width:50px; height:40px"><i class="fa-solid fa-house fa-fade"></i></a>
        <!-- <button id="go_back" class="navbar-brand btn btn-warning me-auto" style="width:50px; height:40px"><i class="fa-solid fa-angle-left"></i></button> -->
        <button class="navbar-toggler" style="border: none;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa-solid fa-bars-staggered" style="color: #ffffff;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 1rem;">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="classes.php">Buy Classes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="my-classes.php">My Classes</a>
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
                <a class="btn btn-danger" style="height:40px;" href="ajax/logout_process.php">LogOut</a>
            </div>

        </div>
    </div>
</nav>

<script>
    document.getElementById('go_back').addEventListener('click', function() {
        window.history.back();
    });
</script>