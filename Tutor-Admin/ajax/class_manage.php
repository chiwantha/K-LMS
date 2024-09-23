<?php
include_once '../../config/config.php';

if (isset($_POST['load'])) {
    $state = $_POST['state'];
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    
    $query = "SELECT * FROM class WHERE tutor_id = $tutor_id AND state" . ($state !== 'NULL' ? "=$state" : " IS NULL");
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($class = mysqli_fetch_assoc($query_run)) {
            echo '<tr>
                    <td>' . $class['name'] . '</td>
                    <td><img src="../uploads/images/classes/' . $class['image'] . '" alt="class Image" style="width: 30px; height: 30px; border-radius: 5px;"></td>
                    <td>';
            if ($state == '1') {
                echo '<button type="button" value="' . $class['id'] . '" class="suspend btn btn-danger" style="margin-right:5px;"><i class="fa-solid fa-trash"></i></button>';
                echo '<button type="button" value="' . $class['id'] . '" class="edit btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>';
            } else {
                echo '<button type="button" value="' . $class['id'] . '" class="activate btn btn-success"><i class="fa-solid fa-check"></i></button>';   
            }
            echo '  </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No classes found.</td></tr>';
    }
}

if (isset($_POST['update_class_state'])) {
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

    $update_query = mysqli_query($conn, "UPDATE class SET state='$state' WHERE id='$id'");

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

if (isset($_POST["save_class"])) {
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $discription = mysqli_escape_string($conn, $_POST["discription"]);
    $batch = mysqli_escape_string($conn, $_POST["batch"]);
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);
    $created_date = date('Y-m-d');

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

    } else {
        $unique_image_name = 'Top.png';
    }

    if ($name == NULL || $discription == NULL || $batch == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO class (name, discription, tutor_id, batch, created_date, image, state)
                VALUES ('$name', '$discription', '$tutor_id', '$batch', '$created_date', '$unique_image_name', 1)";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            if (!empty($_FILES['image']['name'])) {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
            $res = [
                'status' => 200,
                'message' => 'Class Created Successfully'
            ];
            echo json_encode($res);
            return false;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Class Not Created!'
            ];
            echo json_encode($res);
            return false;
        }

    mysqli_close($conn);
}

if (isset($_POST["edit_class"])) {
    $class_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM class WHERE id='$class_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $class = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Student Fetch Succesfully',
            'data' => $class
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Student Id Not Found !'
        ];
        echo json_encode($res);
        return false;
    }
}

if (isset($_POST["update_class"])) {
    $id = $_POST["id"];
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $discription = mysqli_escape_string($conn, $_POST["discription"]);
    $batch = mysqli_escape_string($conn, $_POST["batch"]);

    if ($name == NULL || $discription == NULL || $batch == NULL ) {
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

        $query = "UPDATE class SET name='$name',discription='$discription', batch='$batch', image='$unique_image_name' WHERE id='$id'";

    } else {
        $query = "UPDATE class SET name='$name',discription='$discription', batch='$batch' WHERE id='$id'";
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

if (isset($_POST['load_batches'])) {
    $query = "SELECT batch FROM al_dates WHERE state = 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $batches = [];
        while ($batch = mysqli_fetch_assoc($query_run)) {
            $batches[] = $batch;
        }
        $res = [
            'status' => 200,
            'data' => $batches
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No batches Found!"
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

?>
