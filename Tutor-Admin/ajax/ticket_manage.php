<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    
    $query = "SELECT id,title FROM tickets WHERE state=1 AND tutor_id = $tutor_id AND admin_read" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($ticket = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $ticket['title'] . '</td>
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $ticket['id'] . '" class="viewTicket btn btn-danger" data-bs-toggle="modal" data-bs-target="#ticketModal"><i class="fa-solid fa-eye"></i></button>';
            } else {
                echo '<button type="button" value="' . $ticket['id'] . '" class="viewTicket btn btn-success" data-bs-toggle="modal" data-bs-target="#ticketModal"><i class="fa-solid fa-eye"></i></button>';
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No tickets found.</td></tr>';
    }
}

if (isset($_POST['reply_ticket'])) {
    $ticket_id = mysqli_escape_string($conn, $_POST['id']);
    $ticket_reply = mysqli_escape_string($conn, $_POST['reply']);

    if ($ticket_id === NULL || $ticket_reply === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        return false;
    }

    $update_query = mysqli_query($conn, "UPDATE tickets SET reply='$ticket_reply',admin_read='1' WHERE id='$ticket_id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Reply Submitted Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Submition Failed !'
        ];
        echo json_encode($res);
        return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["review_ticket"])) {
    $ticket_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT id, content, reply, reason, title, admin_read FROM tickets WHERE id='$ticket_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $ticket = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'ticket Fetch Succesfully',
            'data' => $ticket
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'ticket Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

?>
