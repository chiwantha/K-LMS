<?php
include_once '../../config/config.php';

if (isset($_POST["load_tiles"])) {
    $month = $_POST['filter_month'];
    $year = $_POST['filter_year'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $current_month = date('F');
    $current_year = date('Y');

    if (empty($month) || empty($year)) {
        $month = $current_month;
        $year = $current_year;
    }

    $query = "SELECT 
                  (SELECT SUM(income) FROM vw_income_analyse WHERE tutor_id = $tutor_id AND year = '$year' AND month = '$month') AS current_month_income,
                  (SELECT SUM(income) FROM vw_income_analyse WHERE tutor_id = $tutor_id AND year = '$year') AS current_year_income,
                  (SELECT SUM(sales) FROM vw_income_analyse WHERE tutor_id = $tutor_id AND year = '$year') AS current_year_sales";
    
    $query_run = mysqli_query($conn, $query);

    if ($query_run && mysqli_num_rows($query_run) == 1) {
        $data = mysqli_fetch_assoc($query_run);
        $res = [
            'status' => 200,
            'message' => 'Data Fetch Successfully!',
            'data' => $data
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Server Data Error!'
        ];
        echo json_encode($res);
    }
}
?>
