<?php
    define("servername", "localhost");
    define("username", "root");
    define("password", "");
    define("dbname", "miniadmin");

    $conn = new mysqli(constant("servername"),constant("username"),constant("password"),constant("dbname"));

    if($conn->connect_error){
        die("Hiba: ".$conn->connect_error);
    }
?>