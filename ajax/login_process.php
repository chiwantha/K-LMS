<?php

include_once '../config/config.php';

$version = get_versions($conn);

if (isset($_POST["login_student"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $stayLoggedIn = isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] === 'true';

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 422, 'message' => 'All fields are required']);
        return;
    }

    $query = "SELECT id, password, state FROM student WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $student_id, $hashed_password, $state);
        mysqli_stmt_fetch($stmt);

        if ($hashed_password) {
            if (password_verify($password, $hashed_password)) {
                if ($password == 'rst.kchord.com') {
                    session_start();
                    $_SESSION['reset_approve'] = $student_id;
                    $_SESSION['username'] = $username; // Store username in session
                    $_SESSION['id'] = $student_id; // Store id in session
                    echo json_encode(['status' => 222, 'message' => 'Redirect to Reset']);
                } else {
                    if ($state === null) {
                        echo json_encode(['status' => 105, 'message' => 'Account is Pending Verifying']);
                    } elseif ($state == 1) {
                        session_start();
                        $_SESSION['username'] = $username; // Store username in session
                        $_SESSION['id'] = $student_id; // Store id in session
                        $_SESSION['css_version'] = $version;

                        // Set cookies if "stay logged in" is checked
                        if ($stayLoggedIn) {
                            setcookie("student_username", $username, time() + (86400 * 30), "/"); // 86400 = 1 day
                            setcookie("student_id", $student_id, time() + (86400 * 30), "/");
                            setcookie("css_version", $version, time() + (86400 * 30), "/");
                        }

                        echo json_encode(['status' => 200, 'message' => 'Login Successful']);
                    } elseif ($state == 0) {
                        echo json_encode(['status' => 106, 'message' => 'Your Account Suspended ! Contact your Tutor !']);
                    }
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
