<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = 2;
    
    $query = "SELECT id ,title, date FROM messages WHERE state = 2";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($messages = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $messages['title'] . '</td>
                    <td>' . $messages['date'] . '</td>
                    <td><button type="button" value="' . $messages['id'] . '" class="suspend btn btn-danger" style="margin-right:5px;"><i class="fa-solid fa-trash"></i></button></td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No messages found.</td></tr>';
    }
}

if (isset($_POST['delete_message'])) {
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

    $update_query = mysqli_query($conn, "DELETE FROM messages WHERE id='$id' AND state=2");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'class Updated Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'class Update Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["save_message"])) {
    $name = mysqli_escape_string($conn, $_POST["title"]);
    $message = mysqli_escape_string($conn, $_POST["message"]);
    $created_date = date('Y-m-d');

    if ($name == NULL || $message == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO messages (title, message, date, state) VALUES ('$name', '$message', '$created_date', 2)";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $res = [
                'status' => 200,
                'message' => 'Message Sent Successfully'
            ];
            echo json_encode($res);
            return false;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Message Not Sent!'
            ];
            echo json_encode($res);
            return false;
        }

    mysqli_close($conn);
}

?>
