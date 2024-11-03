<?php
    $Conserver = "localhost";
    $Conusername = "Marks_data";
    $Conpassword = "AdminsPrakashDevRaogroups";
    $Condb = "marks_data";

    $flag = false;

    $conn = new mysqli($Conserver, $Conusername, $Conpassword, $Condb);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
