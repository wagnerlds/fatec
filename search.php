<?php
require("config/bd.php");
$id = $_GET['id'];

$sql = "SELECT * FROM objetos WHERE id = ".$id;
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
    $obj = $sql->fetch();
}



    $sql = "SELECT * FROM locais WHERE ID = :id";
    $sql = $pdo->prepare($sql);
    $sql->bindValue(':id', $obj['ID_Local']);
    $sql->execute();
    if($sql->rowCount() > 0){
        $s = $sql->fetch();
    }


    $sql = "SELECT * FROM images WHERE slug = :slug";
    $sql = $pdo->prepare($sql);
    $sql->bindValue(":slug", $obj['slug']);
    $sql->execute();
    if($sql->rowCount() > 0){
        $img = $sql->fetchAll();
    }else{
        $img = array();
    }
    



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title> Estoque fatec </title>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-6">
            <div class="alert alert-primary" role="alert">Info do Objeto</div>
            <h3><?=$obj['Nome'];?></h3>
            <h4>Patrimonio: <?=$obj['Patrimonio'];?></h4>
            <?php if($obj['descricao'] != ""){ ?>
            <strong>Descrição:</strong>
            <div class="txt shadow"> <?=$obj['descricao'];?></div>
            <?php } ?>
            <?php if(count($img) >= 1){ ?>
                <strong>Imagens:</strong>
                <div class="area_imgs">
                    <?php foreach($img as $i){ ?> 
                        <div class="img" style="background-image: url('uploads/<?=$i['lugar'];?>');"></div>
                    <?php } ?>
                </div>
            <?php } ?>
            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
        <div class="col-3">
        <div class="alert alert-primary" role="alert">Localização</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">Prédio</th>
                <th scope="col">Sala</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$s['Predios'];?></td>
                    <td><?=$s['Sala'];?></td>
                </tr>
            </tbody>
        </table>
        
        </div>
    
</div>




<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>