<?php
require("bd.php");

$id = $_GET['id'];
$obj = $_GET['obj'];

$sql = "SELECT * FROM images WHERE id = ".$id;
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
    $tt = $sql->fetch();
}

unlink("../uploads/".$tt['lugar']);

$sql = "DELETE FROM images WHERE id = ".$id;
$sql = $pdo->query($sql);

header("Location: EditarObj.php?id=".$obj);