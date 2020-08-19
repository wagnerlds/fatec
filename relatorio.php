<?php
    require('config/bd.php');
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
<div class="center_title_btn">
    <h1>Relatório</h1>
    <div class="btn-group" role="group" aria-label="Exemplo básico">
        <button type="button" class="btn btn-outline-dark" id="predioOne">prédio 1</button>
        <button type="button" class="btn btn-outline-dark" id="predioTwo">prédio 2</button>
        <button type="button" class="btn btn-outline-dark" id="predioTree">prédio 3</button>
    </div>
    <a href="index.php" class="btn btn-primary mt-2">Voltar</a>
</div>
<div class="area_relatorio" id="area_rel">
</div>
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>