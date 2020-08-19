<?php
    require('config/bd.php');
    if(isset($_POST['predio']) && !empty($_POST['predio'])){
        $predio = addslashes($_POST['predio']);
        $sala = addslashes($_POST['sala']);

        $sql = "INSERT INTO locais (Sala, Predios) VALUES (:sala, :predio)";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":sala", $sala);
        $sql->bindValue(":predio", $predio);
        $sql->execute();

    }
    $sql = "SELECT * FROM locais";
    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0){
        $locais = $sql->fetchAll();
    }

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Adicionar locais </title>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
<?php
    if(!empty($_SESSION['delete'])){
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
?>
<div class="container">
<div class="row">
    <div class="col-6">
    <div class="alert alert-primary" role="alert">
        Formulario de cadastro
    </div>
        <form method="POST"> 
            <div class="form-group">
                <label for="exampleFormControlInput1">Prédio:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="numero do prédio" name="predio">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput">Sala:</label>
                <input type="text" class="form-control" id="exampleFormControlInput" placeholder="numero do Sala" name="sala">
            </div>
            <button type="submit" class="btn btn-primary">Adicionar local</button>
        </form><br/>
        <a href="index.php" class="btn btn-primary">Voltar para home</a>
    </div>
    <div class="col-6">
    <div class="alert alert-primary" role="alert">
        Lista de locais cadastrados
    </div>
        <table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">prédio</th>
            <th scope="col">sala</th>
            <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($locais as $l){ ?>
            <tr>
                <th scope="row"><?=$l['ID'];?></th>
                <td><?=$l['Predios'];?></td>
                <td><?=$l['Sala'];?></td>
                <td><a href="config/deleteLocal.php?id=<?=$l['ID'];?>">Deletar</a></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>

</div>
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>