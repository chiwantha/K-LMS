<?php
include_once '../../config/config.php';

if (isset($_POST["load_dash"])) {
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $query = "SELECT * FROM vw_tutor_dashboard WHERE tutor_id =$tutor_id ";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $data = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Data Fetch Succesfully !',
            'data' => $data
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Server Data Error !'
        ];
        echo json_encode($res);
        return false;
    }
}

?>