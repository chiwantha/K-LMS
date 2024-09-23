<?php

session_start();
$student_id = $_SESSION["id"];
include_once "../config/config.php";

// tutors & classes & lessons ------------------------------------------

if (isset($_POST['load__available_tutors'])) {

    $query = "SELECT DISTINCT tutor_id,tutor_name,tutor_image FROM vw_available_lesson 
        WHERE student_id = $student_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $tutors = [];
        while ($tutor = mysqli_fetch_assoc($query_run)) {
            $tutors[] = $tutor;
        }
        $res = [
            'status' => 200,
            'data' => $tutors
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No tutors Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['load__available_classes'])) {
    $tutor_id = mysqli_escape_string($conn, $_POST['tutor_id']);

    $query = "SELECT DISTINCT class_id,class_name,class_image,class_description FROM vw_available_lesson 
        WHERE student_id = $student_id AND tutor_id = $tutor_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $classes = [];
        while ($class = mysqli_fetch_assoc($query_run)) {
            $classes[] = $class;
        }
        $res = [
            'status' => 200,
            'data' => $classes
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No classes Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['load__available_lessons'])) {
    $class_id = $_POST["class_id"];
    $current_date = DATE('Y-M-D');

    $query = "SELECT lesson_id, lesson_name FROM vw_available_lesson 
        WHERE class_id= $class_id AND student_id = $student_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $lessons = [];
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            $lessons[] = $lesson;
        }
        $res = [
            'status' => 200,
            'data' => $lessons
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No lessons Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['load_study'])) {
    $lesson_id = mysqli_escape_string($conn, $_POST["lesson_id"]);
    $query = "SELECT lesson_id, lesson_name, lesson_description, lesson_video, lesson_document, expire_date FROM vw_available_lesson 
    WHERE lesson_Id= $lesson_id AND student_id = $student_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $lessons = [];
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            $lessons[] = $lesson;
        }
        $res = [
            'status' => 200,
            'data' => $lessons
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No Lessons Found!"
        ];
        echo json_encode($res);
    }
}

// messages ------------------------------------------

if (isset($_POST['load_messages'])) {

    $query = "SELECT * FROM messages WHERE (student_id = $student_id AND state = 1) OR (student_id IS NULL AND state = 2);";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $messages = [];
        while ($message = mysqli_fetch_assoc($query_run)) {
            $messages[] = $message;
        }
        $res = [
            'status' => 200,
            'data' => $messages
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No messages Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['mark_as_read'])) {
    $message_id = mysqli_escape_string($conn, $_POST["id"]);

    if ($message_id == NULL) {
        $res = [
            'status' => 404,
            'message' => "Message Id Missing !"
        ];
        echo json_encode($res);
        return false;
    }

    $query = "UPDATE messages SET state=0 WHERE id = $message_id";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => "Message Deleted !"
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => "Unknown Error with Delete Messages !"
        ];
        echo json_encode($res);
        return false;
    }
}

// student-profile ------------------------------------------

if (isset($_POST["load_profile"])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM student WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $student = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Student Fetch Succesfully',
            'data' => $student
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

if (isset($_POST["update_profile"])) {
    $student_id = mysqli_escape_string($conn, $_POST["id"]);
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $batch = mysqli_escape_string($conn, $_POST["batch"]);
    $contact = mysqli_escape_string($conn, $_POST["contact"]);
    $whatsapp = mysqli_escape_string($conn, $_POST["whatsapp"]);
    $dob = mysqli_escape_string($conn, $_POST["dob"]);
    $sex = mysqli_escape_string($conn, $_POST["sex"]);
    $school = mysqli_escape_string($conn, $_POST["school"]);

    // Image upload handling
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $unique_image_name = bin2hex(random_bytes(10)) . '.' . $image_ext;
    $image_folder = '../uploads/images/students/' . $unique_image_name;

    if ($name == NULL || $batch == NULL || $contact == NULL || $whatsapp == NULL || $dob == NULL || $sex == NULL || $school == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    if ($image_size > 2000000) {
        $res = [
            'status' => 204,
            'message' => 'Image File Too Large!'
        ];
        echo json_encode($res);
        return false;
    }

    // Building dynamic update query
    $query = "UPDATE student SET 
                name = '$name', 
                contact = '$contact', 
                whatsapp = '$whatsapp', 
                batch = '$batch', 
                dob = '$dob', 
                sex = '$sex', 
                school = '$school'";

    // If an image is uploaded, include it in the query
    if (!empty($image)) {
        $query .= ", image = '$unique_image_name'";
    }

    $query .= " WHERE id = '$student_id'";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        // Move uploaded file if the image was provided
        if (!empty($image)) {
            move_uploaded_file($image_tmp_name, $image_folder);
        }
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Student Not Updated!'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

// tickets -----------------------------------------------------

if (isset($_POST['load__available_Tickets'])) {

    $query = "SELECT id,title,reason,student_name,created_date FROM vw_tickets 
        WHERE student_id = $student_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $tickets = [];
        while ($ticket = mysqli_fetch_assoc($query_run)) {
            $tickets[] = $ticket;
        }
        $res = [
            'status' => 200,
            'data' => $tickets
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No tickets Found!"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['load_lessons'])) {
    $query = "SELECT lesson_id, lesson_name FROM vw_available_lesson WHERE student_id = $student_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $lessons = [];
        while ($lesson = mysqli_fetch_assoc($query_run)) {
            $lessons[] = $lesson;
        }
        $res = [
            'status' => 200,
            'data' => $lessons
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'data' => "No lessons Found!"
        ];
        header('Content-Type: application/json');
        echo json_encode($res);
    }
}

if (isset($_POST["raise_ticket"])) {
    $student_id = mysqli_escape_string($conn, $student_id);
    $reason = mysqli_escape_string($conn, $_POST["reason"]);
    $title = mysqli_escape_string($conn, $_POST["title"]);
    $content = mysqli_escape_string($conn, $_POST["description"]);
    $teacher_id = mysqli_escape_string($conn, $_POST["teacher"]);

    if ($student_id == NULL || $reason == NULL || $title == NULL || $content == NULL || $teacher_id == NULL ) {
        $res = [
            'status' => 422,
            'message' => 'All fields are required'
        ];
        echo json_encode($res);
        return false;
    }

    // $res = [
    //     'status' => 204,
    //     'message' => 'Student_id :'. $student_id . ' ,reason :' . $reason .' ,lesson_id :'. $lesson_id . ' ,title :' . $title .' ,content :'. $content . ' ,teacher :' . $teacher_id .' ,doc :'. $unique_document_name  
    // ];
    // echo json_encode($res);
    // return false;

    if ($reason == '0') {
        $lesson_id = mysqli_real_escape_string($conn, $_POST["lesson"]);
        $query = "INSERT INTO tickets (student_id, reason, lesson_id, title, content, teacher_id, state)
                  VALUES ('$student_id', '$reason', '$lesson_id', '$title', '$content', '$teacher_id', 1);";
    } else {
        $query = "INSERT INTO tickets (student_id, reason, title, content, teacher_id, state)
                  VALUES ('$student_id', '$reason', '$title', '$content', '$teacher_id', 1);";
    }

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Ticket Raised Successfully'
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Ticket Not Raised !'
        ];
        echo json_encode($res);
        return false;
    }

    mysqli_close($conn);
}

if (isset($_POST["review_ticket"])) {
    $ticket_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT content, reply, reason, title, admin_read FROM tickets WHERE id='$ticket_id'";
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

if (isset($_POST['delete_ticket'])) {
    $ticket_id = mysqli_real_escape_string($conn, $_POST['id']);

    if ($ticket_id === NULL) {
        $res = [
            'status' => 422,
            'message' => 'Data Missing!'
        ];
        echo json_encode($res);
        //return false;
    }

    $delete_query = mysqli_query($conn, "UPDATE tickets SET state=0 WHERE id='$ticket_id'");

    if ($delete_query) {
        $res = [
            'status' => 200,
            'message' => 'Ticket Removed Successfully'
        ];
        echo json_encode($res);
        //return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Ticket Remove Failed !'
        ];
        echo json_encode($res);
        //return false;
    }
    mysqli_close($conn);
}

// dashboard --------------------------------------------------------

if (isset($_POST["load_dash"])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM vw_student_dashboard WHERE student_id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $data = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Data Fetch Succesfully',
            'data' => $data
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

?>
