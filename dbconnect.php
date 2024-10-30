<?php
    $Conserver = "localhost";
    $Conusername = "academix2";
    $Conpassword = "AdminsPrakashDevRaogroups";
    $Condb = "academix2";

    $flag = false;

    $conn = new mysqli($Conserver, $Conusername, $Conpassword, $Condb);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>