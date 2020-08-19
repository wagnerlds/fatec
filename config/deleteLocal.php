<?php
    require('bd.php');
    $id = $_GET['id'];

$sql = "DELETE FROM locais WHERE id = ".$id;
$sql = $pdo->query($sql);

$_SESSION['delete'] = "<div class='alert alert-warning' role='alert'><b>Local deletado com sucesso</b></div>";

header("Location: ../locais.php");