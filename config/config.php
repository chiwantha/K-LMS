<?php

    $conn = mysqli_connect('153.92.15.910', 'u674260424_Kchordgroup', '','u674260424_e_learn') or die('connection failed');
    // $conn = mysqli_connect('localhost', 'root', 'root','e_learn') or die('connection failed');

    function get_versions($conn) {
        $query_check = "SELECT value FROM settings WHERE setting='css_v'";
        $query_run_check = mysqli_query($conn, $query_check);
    
        if (mysqli_num_rows($query_run_check) > 0) {
            $row = mysqli_fetch_assoc($query_run_check);
            return $row['value'];
        } else {
            return 'err';
        }
    }

?>