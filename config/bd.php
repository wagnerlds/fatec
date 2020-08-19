<?php
session_start();

$nome_bd = "fatec";
$user = "root";
$pass = "";

try{
    $pdo = new PDO("mysql:dbname=".$nome_bd.";host=localhost", $user, $pass);
}catch(PDOException $e){
    echo "ERROR: ".$e->getMessage();
}