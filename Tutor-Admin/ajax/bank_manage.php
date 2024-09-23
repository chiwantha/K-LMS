<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    
    $query = "SELECT id,bank,branch FROM bank WHERE tutor_id = $tutor_id AND state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($bank = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $bank['bank'] . '</td>
                    <td>' . $bank['branch'] . '</td>
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $bank['id'] . '" class="suspend btn btn-danger" style="margin-right:5px;"><i class="fa-solid fa-trash"></i></button>';
                echo '<button type="button" value="' . $bank['id'] . '" class="edit btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>';
            } else {
                echo '<button type="button" value="' . $bank['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>';   
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No Bank Account found.</td></tr>';
    }
}

if (isset($_POST['update_bank_state'])) {
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

    $update_query = mysqli_query($conn, "UPDATE bank SET state='$state' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Bank Updated Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Bank Update Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["save_bank"])) {
    $bank = mysqli_escape_string($conn, $_POST["bank"]);
    $branch = mysqli_escape_string($conn, $_POST["branch"]);
    $account_name = mysqli_escape_string($conn, $_POST["account_name"]);
    $account_no = mysqli_escape_string($conn, $_POST["account_no"]);
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    if ($bank == NULL || $branch == NULL || $account_name == NULL || $account_no == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO bank (tutor_id, bank, branch, account_name, account_no, state)
                VALUES ('$tutor_id','$bank', '$branch', '$account_name', '$account_no', 1)";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Bank Added Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Bank Not Added!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

if (isset($_POST["edit_bank"])) {
    $bank_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM bank WHERE id='$bank_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $bank = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Bank Fetch Succesfully',
            'data' => $bank
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Bank Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

if (isset($_POST["update_bank"])) {
    $id = $_POST["id"];
    $bank = mysqli_escape_string($conn, $_POST["bank"]);
    $branch = mysqli_escape_string($conn, $_POST["branch"]);
    $account_name = mysqli_escape_string($conn, $_POST["account_name"]);
    $account_no = mysqli_escape_string($conn, $_POST["account_no"]);

    if ($bank == NULL || $branch == NULL || $account_name == NULL || $account_no == NULL ||  $id == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "UPDATE bank SET bank='$bank',branch='$branch', account_name='$account_name', account_no='$account_no' WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Bank Account Updated Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Bank Account Not Updated!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

?>
