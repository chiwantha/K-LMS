<?php

function get_student_al_date($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username); // Use mysqli_real_escape_string for escaping

    // Fetch batch from the student table
    $query = "SELECT batch FROM student WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $batch);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($batch) {
            // Fetch date from al_dates table based on the batch
            $query2 = "SELECT date FROM al_dates WHERE batch = ?";
            $stmt2 = mysqli_prepare($conn, $query2);

            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "s", $batch);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $date);
                mysqli_stmt_fetch($stmt2);
                mysqli_stmt_close($stmt2);

                if ($date) {
                    return $date;
                } else {
                    return date("Y-m-d");
                }
            } else {
                return date("Y-m-d");
            }
        } else {
            return date("Y-m-d");
        }
    } else {
        return date("Y-m-d");
    }
}

?>