<?php

    $dsn = "mysql:host=localhost;dbname=elnada";
    $user = "root";
    $pass = "";

    try {
        $conn = new PDO($dsn,$user,$pass);
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }


?>