<?php

sleep(1);
include_once "../config/config.php";

if (isset($_POST['load_tutors'])) {
    $query = "SELECT id, name, subject, image FROM tutor WHERE state = 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $tutors = [];
        while ($tutor = mysqli_fetch_assoc($query_run)) {
            $tutors[] = $tutor;
        }
        $res = [
            'status' => 200,
            'data' => $tutors
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No tutors Found!"
        ];
        echo json_encode($res);
    }
}

?>
