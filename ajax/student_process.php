<?php
//sleep(1);

include_once "../config/config.php";

if (isset($_POST["save_student"])) {
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $batch = mysqli_escape_string($conn, $_POST["batch"]);
    $contact = mysqli_escape_string($conn, $_POST["contact"]);
    $whatsapp = mysqli_escape_string($conn, $_POST["whatsapp"]);
    $dob = mysqli_escape_string($conn, $_POST["dob"]);
    $sex = mysqli_escape_string($conn, $_POST["sex"]);
    $school = mysqli_escape_string($conn, $_POST["school"]);
    $username = mysqli_escape_string($conn, $_POST["username"]);
    $pwd = mysqli_escape_string($conn, $_POST["password"]);
    $password = password_hash($pwd, PASSWORD_DEFAULT);

    // Image upload handling
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $unique_image_name = bin2hex(random_bytes(10)) . '.' . $image_ext;
    $image_folder = '../uploads/images/students/' . $unique_image_name;

    if ($name == NULL || $batch == NULL || $contact == NULL || $whatsapp == NULL || $dob == NULL || $sex == NULL || $school == NULL || $username == NULL || $password == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    //------------------------------------------------------------------------------------

    $query_check = "SELECT id FROM student WHERE username = '$username'";
    $query_run_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($query_run_check) > 0) {
        $res = [
            'status' => 222,
            'message' => 'The Username is Already Taken !'
        ];
        echo json_encode($res);
        return false;
    }

    //------------------------------------------------------------------------------------

    if ($image_size > 2000000) {
        $res = [
            'status' => 204,
            'message' => 'Image File Too Large!'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO student (name, contact, whatsapp, batch, dob, sex, school, image, username, password)
                VALUES ('$name', '$contact', '$whatsapp', '$batch', '$dob', '$sex', '$school', '$unique_image_name', '$username', '$password')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        move_uploaded_file($image_tmp_name, $image_folder);
        $res = [
            'status' => 200,
            'message' => 'Student Created Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Student Not Created!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

if (isset($_POST['reset_password'])) {
    $id = mysqli_escape_string($conn,  $_POST['id']);
    $username = mysqli_escape_string($conn,  $_POST['username']);
    $pwd = mysqli_escape_string($conn, $_POST['password']);
    $password = password_hash($pwd, PASSWORD_DEFAULT);

    if ($id === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        return false;
    }

    $update_query = mysqli_query($conn, "UPDATE student SET password='$password' WHERE id='$id' AND username='$username'");

    if ($update_query) {
        $res = [
            'status' => 200,
            'message' => 'Password Set Successfully !'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Password Set Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

?>
