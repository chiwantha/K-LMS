<?php

function getNextStudentID($conn) {

    $sql = "SELECT MAX(id) AS max_id FROM student";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $highest_id = $row["max_id"];

    // Step 3: Increment the retrieved ID by 1 to get the next ID
    $next_id = (int)$highest_id + 1;

    // Step 4: Format the next ID to ensure it has 6 digits
    $formatted_next_id = sprintf('%06d', $next_id);

    // Step 5: Return the formatted next ID
    return $formatted_next_id;
}

?>
