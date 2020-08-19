<?php
require("bd.php");
$id = $_GET['id'];

$sql = "DELETE FROM objetos WHERE id = ".$id;
$sql = $pdo->query($sql);

$_SESSION['delete'] = "<div class='alert alert-warning' role='alert'><b>Objeto deletado com sucesso</b></div>";

header("Location:../objetos.php");