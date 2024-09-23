<?php

sleep(1);
include_once "../config/config.php";

if (isset($_POST['load_lessons'])) {
    $class_id = mysqli_escape_string($conn, $_POST["class_id"]);
    $query = "SELECT id, name, payment FROM lesson WHERE state = 1 AND class = " . $class_id;
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $lessons = [];
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            $lessons[] = $lesson;
        }
        $res = [
            'status' => 200,
            'data' => $lessons
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No Lessons Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['load_lesson_preview'])) {
    $lesson_id = mysqli_escape_string($conn, $_POST["lesson_id"]);
    $query = "SELECT id, name, discription, payment, price, video_id, payment FROM lesson WHERE state = 1 AND id = " . $lesson_id;
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $lessons = [];
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            $lessons[] = $lesson;
        }
        $res = [
            'status' => 200,
            'data' => $lessons
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No Lessons Found!"
        ];
        echo json_encode($res);
    }
}

?>
