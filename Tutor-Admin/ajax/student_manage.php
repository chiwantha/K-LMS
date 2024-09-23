<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    
    $query = "SELECT * FROM student WHERE state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($student = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $student['name'] . '</td>
                    <td><img src="../uploads/images/students/' . $student['image'] . '" alt="Student Image" style="width: 30px; height: 30px; border-radius: 5px;"></td>
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $student['id'] . '" class="suspend btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                      <button type="button" value="' . $student['id'] . '" class="reset btn btn-warning" data-bs-toggle="modal" data-bs-target="#reset_password_confirm"><i class="fa-solid fa-key"></i></button>';
            } elseif ($state == 'NULL') {
                echo '<button type="button" value="' . $student['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>
                      <button type="button" value="' . $student['id'] . '" class="suspend btn btn-danger"><i class="fa-solid fa-trash"></i></button>';
            } else {
                echo '<button type="button" value="' . $student['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>';
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No students found.</td></tr>';
    }
}

if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $state = $_POST['state'];

    if ($id === NULL || $state === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        //return false;
    }

    // Ensure the state is correctly formatted for a bit (0 or 1)
    //$state = ($state == 0) ? 0 : 1;

    $update_query = mysqli_query($conn, "UPDATE student SET state='$state' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Student Update Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST['reset'])) {
    $id = mysqli_escape_string($conn,  $_POST['id']);
    $temporary_password = password_hash('rst.kchord.com', PASSWORD_DEFAULT);
    $pwd = mysqli_real_escape_string($conn, $temporary_password);

    if ($id === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        return false;
    }

    $update_query = mysqli_query($conn, "UPDATE student SET password='$pwd' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Temp Password Set Successfully !'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Temp Password Set Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

?>
