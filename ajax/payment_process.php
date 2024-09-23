<?php

session_start();
if (!isset($_SESSION["username"])) {
    $res = [
        'status' => 422,
        'message' => 'user Authentication Failed !'
    ];
    echo json_encode($res);
    return false;
}

$student_id = $_SESSION["id"];
include_once "../config/config.php";


if (isset($_POST['load_bank'])) {
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $query = "SELECT * FROM bank WHERE tutor_id = $tutor_id AND state = 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $banks = [];
        while ($bank = mysqli_fetch_assoc($query_run)) {
            $banks[] = $bank;
        }
        $res = [
            'status' => 200,
            'data' => $banks
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No banks Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST["save_payment"])) {
    $id = mysqli_escape_string($conn, $_SESSION["id"]);
    $class_id = mysqli_escape_string($conn, $_POST["class_id"]);
    $lesson_id = mysqli_escape_string($conn, $_POST["lesson_id"]);
    $message = mysqli_escape_string($conn, $_POST["message"]);
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    $today = date('Y-m-d');

    if ($message == NULL) {
        $message = "None";
    }

    if (!empty($_FILES['slip']['name'])) {
        $slip = $_FILES['slip']['name'];
        $slip_size = $_FILES['slip']['size'];
        $slip_tmp_name = $_FILES['slip']['tmp_name'];
        $slip_ext = pathinfo($slip, PATHINFO_EXTENSION);
        $unique_slip_name = bin2hex(random_bytes(10)) . '.' . $slip_ext;
        $slip_folder = '../uploads/images/slip/' . $unique_slip_name;

        if ($slip_size > 2000000) {
            $res = [
                'status' => 204,
                'message' => 'slip File Too Large!'
            ];
            echo json_encode($res);
            return false;
        }

    } else {
        $res = [
            'status' => 204,
            'message' => 'slip dosent found!'
        ];
        echo json_encode($res);
        return false;
    }

    if ($id == NULL || $class_id == NULL || $lesson_id == NULL || $slip == NULL || $tutor_id == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $check = "SELECT state, exp FROM payment WHERE student_id = '$id' AND class_id = '$class_id' AND lesson_id = '$lesson_id' ORDER BY created_date DESC LIMIT 1";
    $check_run = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_run) > 0) {
        $row = mysqli_fetch_assoc($check_run);

        if ($row['state'] == "") {
            $res = [
                'status' => 204,
                'message' => 'Your previously submitted payment slip on this lesson is still pending!'
            ];
            echo json_encode($res);
            return false;
        } elseif ($row['state'] == 1) {
            $exp_date = strtotime($row['exp']);
            $current_date = time();

            if ($exp_date > $current_date) {
                $res = [
                    'status' => 204,
                    'message' => 'You already have this lesson active on your account!'
                ];
                echo json_encode($res);
                return false;
            }
        }

    } else {
        $query = "INSERT INTO payment (student_id, tutor_id, class_id, lesson_id, payment, recept, message, created_date)
              VALUES ('$id', '$tutor_id', '$class_id', '$lesson_id', 1, '$unique_slip_name', '$message', '$today')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            if (!empty($_FILES['slip']['name'])) {
                move_uploaded_file($slip_tmp_name, $slip_folder);
            }
            $res = [
                'status' => 200,
                'message' => 'Payment Made Successfully'
            ];
            echo json_encode($res);
            return false;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Payment Request Failed !'
            ];
            echo json_encode($res);
            return false;
        }

        mysqli_close($conn);
    }

}

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    
    $query = "SELECT id,lesson_name FROM vw_payments WHERE student_id=$student_id AND state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($payment = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $payment['lesson_name'] . '</td>
                    <td>';
            if ($state == 'NULL') {
                echo '<button type="button" value="' . $payment['id'] . '" class="suspend btn btn-danger"><i class="fa-solid fa-trash"></i></button>';
            } elseif ($state == '0') {
                echo '<button type="button" value="' . $payment['id'] . '" class="suspend btn btn-danger"><i class="fa-solid fa-trash"></i></button>';
            } elseif ($state == '1') {
                echo '<i class="fa-solid fa-circle-check" style="color:#3EB649;"></i>';
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No Payments found.</td></tr>';
    }
}

if (isset($_POST['delete_payment'])) {
    $id = $_POST['id'];

    if ($id === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        //return false;
    }

    // Ensure the state is correctly formatted for a bit (0 or 1)
    //$state = ($state == 0) ? 0 : 1;

    $update_query = mysqli_query($conn, "DELETE FROM payment WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Request Deleted Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Request Delete Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["add_free"])) {
    $id = mysqli_escape_string($conn, $_SESSION["id"]);
    $class_id = mysqli_escape_string($conn, $_POST["class_id"]);
    $lesson_id = mysqli_escape_string($conn, $_POST["lesson_id"]);
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    $today = date('Y-m-d');

    $currentDate = new DateTime();
    $currentDate->modify('+1 month');
    $expiryDate = $currentDate->format('Y-m-d');

    if ($id == NULL || $class_id == NULL || $lesson_id == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $check = "SELECT state, exp FROM payment WHERE student_id = '$id' AND class_id = '$class_id' AND lesson_id = '$lesson_id' ORDER BY created_date DESC LIMIT 1";
    $check_run = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_run) > 0) {
        $row = mysqli_fetch_assoc($check_run);

        if ($row['state'] == "") {
            $res = [
                'status' => 204,
                'message' => 'Your previously submitted payment slip on this lesson is still pending!'
            ];
            echo json_encode($res);
            return false;
        } elseif ($row['state'] == 1) {
            $exp_date = strtotime($row['exp']);
            $current_date = time();

            if ($exp_date > $current_date) {
                $res = [
                    'status' => 204,
                    'message' => 'You already have this lesson active on your account!'
                ];
                echo json_encode($res);
                return false;
            }
        }

    } else {

        $query = "INSERT INTO payment (student_id,tutor_id, class_id, lesson_id, payment, recept, message, created_date, exp, state)
              VALUES ('$id', '$tutor_id', '$class_id', '$lesson_id', 0, 'none', 'this is free', '$today', '$expiryDate', 1)";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $res = [
                'status' => 200,
                'message' => 'Class Added Successfully'
            ];
            echo json_encode($res);
            return false;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Class Adding Failed !'
            ];
            echo json_encode($res);
            return false;
        }

        mysqli_close($conn);
    }

}

?>