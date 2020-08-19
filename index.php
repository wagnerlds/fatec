<?php
 require("config/bd.php");
 //se usuario = ok caso contrario redirect login
 if(!empty($_SESSION['user'])){
    $id = $_SESSION['user'];
    
    $sql = "SELECT * FROM usuarios WHERE id = :id"; //monta a pesquisa
    $sql = $pdo->prepare($sql); //prepara a pesquisa
    $sql->bindValue(":id", $id); //troca os valores
    $sql->execute(); //executa

    if($sql->rowCount() > 0){ //verifica se o numero de linhas é maior que 0
        $dados = $sql->fetch(); //guarda os dados numa variavel
    }else{
        header("Location: login.php");
        exit;
    }

 }else{
    header("Location: login.php");
    exit;
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
<div class="top_index">
<?=$dados['Nome'];?>
<a href="relatorio.php" class="btn btn-sm btn-success ml-2">Relatório</a>
<a href="config/sair.php" class="btn btn-sm btn-danger ml-2">Sair</a>
</div>

<div class="input_pesquisa">
    <img src="assets/img/fatec.png" width="500">
    <input type="text" class="input_item_pesquisa" id="pesquisa" placeholder="Busque por produto ou patrimonio">
    <div class="resultado_pesquisa" id="item_das_pesquisas">
        
    </div>
    <div class="area_btn_add mt-3">
        <a href="locais.php" class="btn_add_iput mr-3">Adicionar locais</a>
        <a href="objetos.php" class="btn_add_iput">Adicionar objetos</a>
    </div>
    
</div>

<!--
<a href="locais.php" class="btn btn-primary">Adicionar locais</a><br/><br/>
<a href="objetos.php" class="btn btn-success">Adicionar objetoss</a><br/>
-->
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>