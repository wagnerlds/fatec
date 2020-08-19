<?php

require('../config/bd.php');
$sql = "SELECT * FROM locais";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0){
 $locais = $sql->fetchAll();
}
$id = $_GET['id'];

$sql = "SELECT * FROM objetos WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
if($sql->rowCount() > 0){
    $obj = $sql->fetch();
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

if(isset($_POST['nome'])){
    $nome = addslashes($_POST['nome']);
    $local = addslashes($_POST['local']);
    $patrimonio = addslashes($_POST['patrimonio']);
    $descricao = addslashes($_POST['descricao']);

    $sql = "UPDATE objetos SET ID_Local = :loca, Nome = :nome, Patrimonio = :patri, descricao = :descri WHERE ID = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue(":loca", $local);
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":patri", $patrimonio);
    $sql->bindValue(":descri", $descricao);
    $sql->bindValue(":id", $id);
    $sql->execute();

    $imagens = $_FILES['imagem'];
        
        if(count($imagens['tmp_name']) > 0){
            for($i=0;$i<count($imagens['tmp_name']);$i++){
                $type = explode("/", $imagens['type'][$i]);
                $type = $type[1];
                $nome_img = md5($imagens['name'][$i].rand(1, 999).time()).".".$type;
                
                move_uploaded_file($imagens['tmp_name'][$i], "../uploads/".$nome_img);

                $sql = "INSERT INTO images (slug, lugar) VALUES (:slug, :lugar)";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":slug", $obj['slug']);
                $sql->bindValue(":lugar", $nome_img);
                $sql->execute();

            }
        }

    $info = "Objeto <b>".$nome."</b> atualizado com sucesso";

    $_SESSION['existe'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
              ".$info."
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";

    header("Location: ../objetos.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Adicionar Objetos no estoque </title>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
</head>
<body>
<form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="idLocal2">Selecione os locais</label>
            <select class="form-control" id="idLocal2" name="local">
            <?php foreach($locais as $l){ ?>
                <option value="<?=$l['ID'];?>" <?php if($l['ID'] == $obj['ID_Local']){ echo "selected"; } ?> >Prédio <?=$l['Predios'];?> Sala: <?=$l['Sala'];?></option>
            <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput">Nome do objeto</label>
            <input type="text" class="form-control" id="exampleFormControlInput" placeholder="TV 32'" name="nome" value="<?=$obj['Nome'];?>">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInpu">Patrimonio</label>
            <input type="text" class="form-control" id="exampleFormControlInpu" placeholder="#152" name="patrimonio" value="<?=$obj['Patrimonio'];?>">
        </div>
        <div class="form-group">
            <label for="editadesc">Descrição</label>
            <textarea class="form-control" id="editadesc" rows="3" name="descricao"><?=$obj['descricao'];?></textarea>
        </div>
        <div class="form-group">
            <label for="img">Envie as imagens.</label>
            <input type="file" class="form-control-file" id="img" name="imagem[]" multiple>
        </div>
        <button type="submit" class="btn btn-outline-dark">Editar objeto</button>
</form>
<?php foreach($img as $i){ ?>
    <img src="../uploads/<?=$i['lugar'];?>" height="100">
    <a href="excluirImg.php?id=<?=$i['id'];?>&obj=<?=$obj['ID'];?>" onclick="return confirm('tem certeza que vai excluir?');" class="btn btn-danger btn-sm" style="margin-top:60px; margin-left:-50px;">excluir</a>
<?php } ?>
<br/>
<a href="../objetos.php" class="btn btn-success">Voltar</a>
<script type="text/javascript" src="../assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../assets/js/script.js"></script>
</body>
</html>