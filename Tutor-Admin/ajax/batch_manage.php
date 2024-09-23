<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    
    $query = "SELECT id,batch,date FROM al_dates WHERE state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($batch = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $batch['batch'] . '</td>
                    <td>' . $batch['date'] . '</td>
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $batch['id'] . '" class="suspend btn btn-danger" style="margin-right:5px;"><i class="fa-solid fa-trash"></i></button>';
                echo '<button type="button" value="' . $batch['id'] . '" class="edit btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>';
            } else {
                echo '<button type="button" value="' . $batch['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>';   
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No Batches found.</td></tr>';
    }
}

if (isset($_POST['update_batch_state'])) {
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

    $update_query = mysqli_query($conn, "UPDATE al_dates SET state='$state' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Batch Updated Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Batch Update Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["save_batch"])) {
    $batch = mysqli_escape_string($conn, $_POST["batch"]);
    $date = mysqli_escape_string($conn, $_POST["date"]);

    if ($batch == NULL || $date == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO al_dates (batch, date, state)
                VALUES ('$batch', '$date', 1)";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'batch Added Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'batch Not Added!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

if (isset($_POST["edit_batch"])) {
    $batch_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM al_dates WHERE id='$batch_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $batch = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'batch Fetch Succesfully',
            'data' => $batch
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'batch Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

if (isset($_POST["update_batch"])) {
    $id = $_POST["id"];
    $batch = mysqli_escape_string($conn, $_POST["batch"]);
    $date = mysqli_escape_string($conn, $_POST["date"]);


    if ($batch == NULL || $date == NULL ||  $id == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "UPDATE al_dates SET batch='$batch',date='$date' WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'batch Updated Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'batch Not Updated!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

?>
