<?php
session_start();
include_once '../../config/config.php';

$version = get_versions($conn);

if (isset($_POST["login_tutor"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $stayLoggedIn = isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] === 'true';

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 422, 'message' => 'All fields are required']);
        return;
    }

    $query = "SELECT password, state, id FROM tutor WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password, $state, $tutor_id);
        mysqli_stmt_fetch($stmt);

        if ($hashed_password) {
            if (password_verify($password, $hashed_password)) {
                if ($state === null) {
                    echo json_encode(['status' => 105, 'message' => 'Account is Pending Verifying']);
                } elseif ($state == 1) {

                    $_SESSION['tutor_username'] = $username;
                    $_SESSION['tutor_id'] = $tutor_id;
                    $_SESSION['css_version'] = $version;

                    if ($stayLoggedIn) {
                        setcookie("tutor_username", $username, time() + (86400 * 30), "/"); // 86400 = 1 day
                        setcookie("tutor_id", $tutor_id, time() + (86400 * 30), "/");
                        setcookie("css_version", $version, time() + (86400 * 30), "/");
                    }

                    echo json_encode(['status' => 200, 'message' => 'Login Successful']);
                } elseif ($state == 0) {
                    echo json_encode(['status' => 106, 'message' => 'Your Account Suspended ! Contact your Tutor !']);
                }
            } else {
                echo json_encode(['status' => 500, 'message' => 'Invalid Username or Password']);
            }
        } else {
            echo json_encode(['status' => 204, 'message' => 'No user found! Please check the username again!']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 404, 'message' => 'Internal Server Error']);
    }

    mysqli_close($conn);
}

?>
