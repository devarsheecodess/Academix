<?php
    $Conserver = "sql12.freesqldatabase.com";
    $Conusername = "sql12742911";
    $Conpassword = "y9YIrqY2JQ";
    $Condb = "sql12742911";

    $flag = false;

    $conn = new mysqli($Conserver, $Conusername, $Conpassword, $Condb);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>