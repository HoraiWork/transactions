<?php
$servername = "localhost";
$username = "root";
$password = "";
define('DB_PREFIX_PARS', 'oc_');



try {
    $connection  = new PDO("mysql:host=$servername;dbname=owc_openshop", $username, $password);

    $connection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }



