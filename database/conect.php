<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $connection  = new PDO("mysql:host=$servername;dbname=product_tools", $username, $password);

    $connection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
