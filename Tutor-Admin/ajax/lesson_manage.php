<?php
// sleep(1);
include_once '../../config/config.php';

//---------------------------------------------

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    
    $query = "SELECT * FROM lesson WHERE tutor_id=$tutor_id AND state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $lesson['name'] . '</td>
                    
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $lesson['id'] . '" class="suspend btn btn-danger" style="margin-right:5px;"><i class="fa-solid fa-trash"></i></button>';
                echo '<button type="button" value="' . $lesson['id'] . '" class="edit btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>';
            } else {
                echo '<button type="button" value="' . $lesson['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>';   
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No lessons found.</td></tr>';
    }
}

if (isset($_POST['update_lesson_state'])) {
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

    $update_query = mysqli_query($conn, "UPDATE lesson SET state='$state' WHERE id='$id'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'lesson Updated Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'lesson Update Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

if (isset($_POST["edit_lesson"])) {
    $lesson_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM lesson WHERE id='$lesson_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $lesson = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'lesson Fetch Succesfully',
            'data' => $lesson
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'lesson Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

if (isset($_POST["load_classes"])) {
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $sql = "SELECT id, name FROM class WHERE tutor_id=$tutor_id AND state = 1";
    $result = $conn->query($sql);

    $classes = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $classes[] = array("id" => $row["id"], "name" => $row["name"]);
        }
    }

    $conn->close();

    echo json_encode($classes);
}

if (isset($_POST["save_lesson"])) {
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $discription = mysqli_escape_string($conn, $_POST["description"]);
    $class = mysqli_escape_string($conn, $_POST["class"]);
    $payment = mysqli_escape_string($conn, $_POST["payment"]);
    $price = mysqli_escape_string($conn, $_POST["price"]);
    $video_id = mysqli_escape_string($conn, $_POST["video_id"]);
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    if (!empty($_FILES['document']['name'])) {
        $document = $_FILES['document']['name'];
        $document_tmp_name = $_FILES['document']['tmp_name'];
        $document_ext = pathinfo($document, PATHINFO_EXTENSION);
        $unique_document_name = bin2hex(random_bytes(10)) . '.' . $document_ext;
        $document_folder = '../../uploads/documents/' . $unique_document_name;
    } else {
        $unique_document_name = 'None';
    }

    if ($name == NULL || $discription == NULL || $class == NULL || $payment == NULL || $price == NULL || $video_id == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO lesson (name, discription, class,tutor_id, payment, price, video_id, document_id, state)
                VALUES ('$name', '$discription', '$class', '$tutor_id', '$payment', '$price', '$video_id', '$unique_document_name', 1)";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (!empty($_FILES['document']['name'])) {
            move_uploaded_file($document_tmp_name, $document_folder);
        }
        $res = [
            'status' => 200,
            'message' => 'Lesson Created Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Lesson Not Created!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

if (isset($_POST["update_lesson"])) {

    $id = mysqli_escape_string($conn, $_POST["id"]);
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $discription = mysqli_escape_string($conn, $_POST["description"]);
    $class = mysqli_escape_string($conn, $_POST["class"]);
    $payment = mysqli_escape_string($conn, $_POST["payment"]);
    $price = mysqli_escape_string($conn, $_POST["price"]);
    $video_id = mysqli_escape_string($conn, $_POST["video_id"]);

    if ($name == NULL || $discription == NULL || $class == NULL || $payment == NULL || $price == NULL || $video_id == NULL  || $id == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    if (!empty($_FILES['document']['name'])) {
        $document = $_FILES['document']['name'];
        $document_tmp_name = $_FILES['document']['tmp_name'];
        $document_ext = pathinfo($document, PATHINFO_EXTENSION);
        $unique_document_name = bin2hex(random_bytes(10)) . '.' . $document_ext;
        $document_folder = '../../uploads/documents/' . $unique_document_name;

        $query = "UPDATE lesson SET name='$name', discription='$discription', class='$class', payment='$payment', price='$price', video_id='$video_id', document_id='$unique_document_name' WHERE id='$id'";

    } else {
        $query = "UPDATE lesson SET name='$name', discription='$discription', class='$class', payment='$payment', price='$price', video_id='$video_id' WHERE id='$id'";
    }

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (!empty($_FILES['document']['name'])) {
            move_uploaded_file($document_tmp_name, $document_folder);
        }
        $res = [
            'status' => 200,
            'message' => 'Lesson Updated Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Lesson Not Updated!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

?>
