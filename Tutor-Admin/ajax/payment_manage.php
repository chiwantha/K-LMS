<?php

sleep(1);

session_start();
if (!isset($_SESSION["tutor_username"])) {
    $res = [
        'status' => 422,
        'message' => 'user Authentication Failed !'
    ];
    echo json_encode($res);
    return false;
}

include_once "../../config/config.php";

if (isset($_POST['load'])) { 
    $state = $_POST['state'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    
    $query = "SELECT id,student_id,student_name,lesson_name FROM vw_payments WHERE tutor_id = $tutor_id AND state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($payment = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $payment['student_name'] . '</td>
                    <td>' . $payment['lesson_name'] . '</td>
                    <td>';
            if ($state == 'NULL') {
                echo '<button type="button" value="' . $payment['id'] . '" class="gear-pending btn btn-danger"><i class="fa-solid fa-gear"></i></button>';
            } elseif ($state == '0') {
                echo '<button type="button" value="' . $payment['id'] . '" class="gear-reject btn btn-danger"><i class="fa-solid fa-gear"></i></button>';
            } elseif ($state == '1') {
                echo '<button type="button" value="' . $payment['id'] . '" class="gear-aproved btn btn-danger"><i class="fa-solid fa-gear"></i></button>';
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No Payments found.</td></tr>';
    }
}

if (isset($_POST["review_payment"])) {
    $payment_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM vw_payments WHERE id='$payment_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $payment = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'payment Fetch Succesfully',
            'data' => $payment
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'payment Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

if (isset($_POST['aprove_payment'])) {

    $id = $_POST['id'];

    $currentDate = new DateTime();
    $currentDate->modify('+1 month');
    $expiryDate = $currentDate->format('Y-m-d');

    if ($id === NULL || $expiryDate === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        return false;
    }

    $update_query = mysqli_query($conn, "UPDATE payment SET state=1,exp='$expiryDate' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Payment Request Aproved !'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Process Failed !'
        ];
        echo json_encode($res);
        return false;
    }
    mysqli_close($conn);
}

if (isset($_POST['reject_payment'])) {

    $id = mysqli_real_escape_string($conn, $_POST["payment_id"]);
    $student_id = $_POST["student_id"];
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
    $state = 0;

    $currentDate = new DateTime();
    $currentDate = $currentDate->format('Y-m-d');

    if (empty($id) || empty($currentDate) || empty($message) || empty($student_id)) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        return false;
    }

    $update_query = mysqli_query($conn, "UPDATE payment SET state='$state', exp=NULL WHERE id='$id'");

    if ($update_query) {
        if (send_reject_message($conn, $student_id, $message, $currentDate)) {
            $res = [
                'status' => 200,
                'message' => 'Payment Request Rejected!'
            ];
        } else {
            $res = [
                'status' => 500,
                'message' => 'Failed to send reject message!'
            ];
        }
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Process Failed!'
        ];
        echo json_encode($res);
        return false;
    }
    mysqli_close($conn);
}

function send_reject_message($conn, $student_id, $message, $date) {
    $stid = $student_id;
    $msg = mysqli_real_escape_string($conn, $message);

    if (empty($stid) || empty($msg)) {
        return false;
    }

    $insert_query = mysqli_query($conn, "INSERT INTO messages (student_id, title, message, date, state) VALUES ('$stid', 'Payment Rejection', '$msg', '$date', 1)");

    return $insert_query ? true : false;
}

if (isset($_POST["update_class"])) {
    $id = $_POST["id"];
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $discription = mysqli_escape_string($conn, $_POST["discription"]);
    $teacher = mysqli_escape_string($conn, $_POST["teacher"]);
    $batch = mysqli_escape_string($conn, $_POST["batch"]);

    if ($name == NULL || $discription == NULL || $teacher == NULL || $batch == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $unique_image_name = bin2hex(random_bytes(10)) . '.' . $image_ext;
        $image_folder = '../../uploads/images/classes/' . $unique_image_name;

        if ($image_size > 2000000) {
            $res = [
                'status' => 204,
                'message' => 'Image File Too Large!'
            ];
            echo json_encode($res);
            return false;
        }

        $query = "UPDATE class SET name='$name',discription='$discription', teacher='$teacher', batch='$batch', image='$unique_image_name' WHERE id='$id'";

    } else {
        $query = "UPDATE class SET name='$name',discription='$discription', teacher='$teacher', batch='$batch' WHERE id='$id'";
    }


    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
        $res = [
            'status' => 200,
            'message' => 'Class Updated Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Class Not Updated!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

?>