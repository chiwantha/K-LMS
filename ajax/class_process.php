<?php

sleep(1);
include_once "../config/config.php";

if (isset($_POST['load_classes'])) {
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $query = "SELECT id, name, discription, image FROM class WHERE tutor_id = $tutor_id AND state = 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $classes = [];
        while ($class = mysqli_fetch_assoc($query_run)) {
            $classes[] = $class;
        }
        $res = [
            'status' => 200,
            'data' => $classes
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No Classes Found!"
        ];
        echo json_encode($res);
    }
}

?>
