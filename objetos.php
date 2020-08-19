<?php
require('config/bd.php');
 $sql = "SELECT * FROM locais";
 $sql = $pdo->query($sql);

 if($sql->rowCount() > 0){
     $locais = $sql->fetchAll();
 }


    $sql = "SELECT * FROM objetos";
    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0){
        $obj = $sql->fetchAll();
    }else{
        $obj = [];
    }

    if(isset($_POST['local']) && !empty($_POST['local'])){
    
        $id_local = $_POST['local'];
        $nome = addslashes($_POST['nome']);
        $patri = addslashes($_POST['patrimonio']);
        $desc = $_POST['descricao'];
        $imagens = $_FILES['imagem'];
        $slug = md5($nome.rand(1,999));
        
        if(count($imagens['tmp_name']) > 0){
            for($i=0;$i<count($imagens['tmp_name']);$i++){
                $type = explode("/", $imagens['type'][$i]);
                $type = $type[1];
                $nome_img = md5($imagens['name'][$i].rand(1, 999).time()).".".$type;
                
                move_uploaded_file($imagens['tmp_name'][$i], "uploads/".$nome_img);

                $sql = "INSERT INTO images (slug, lugar) VALUES (:slug, :lugar)";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":slug", $slug);
                $sql->bindValue(":lugar", $nome_img);
                $sql->execute();

            }
        }

        
         $sql = "SELECT * FROM objetos WHERE Patrimonio = :patri";
         $sql = $pdo->prepare($sql);
         $sql->bindValue(':patri', $patri);
         $sql->execute();

         
         if($sql->rowCount() > 0){
              $_SESSION['existe'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>Patrimonio ja registrado</strong>
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>";
          }else{
              $sql = "INSERT INTO objetos (ID_Local, Nome, Patrimonio, descricao, slug) VALUES (:idLocal, :nome, :patri, :descricao, :slug)";
              $sql = $pdo->prepare($sql);
              $sql->bindValue(":idLocal", $id_local);
              $sql->bindValue(":nome", $nome);
              $sql->bindValue(":patri", $patri);
              $sql->bindValue(":descricao", $desc);
              $sql->bindValue(":slug", $slug);
              $sql->execute();

              header("Location: objetos.php");
              
        } 

      
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Adicionar Objetos no estoque </title>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
<?php
    if(!empty($_SESSION['delete'])){
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    if(!empty($_SESSION['existe'])){
        echo $_SESSION['existe'];
        unset($_SESSION['existe']);
    }
?>
<div class="container-fluid">
<div class="row">
    <div class="col-4">
    <div class="alert alert-primary" role="alert">
       Formulario de cadastro
    </div>
        <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="idLocal">Selecione os locais</label>
            <select class="form-control" id="idLocal" name="local">
            <?php foreach($locais as $l){ ?>
                <option value="<?=$l['ID'];?>">Prédio <?=$l['Predios'];?> Sala: <?=$l['Sala'];?></option>
            <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput">Nome do objeto</label>
            <input type="text" class="form-control" id="exampleFormControlInput" placeholder="TV 32'" name="nome">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInpu">Patrimonio</label>
            <input type="text" class="form-control" id="exampleFormControlInpu" placeholder="#152" name="patrimonio">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Descrição</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" col="3" name="descricao"></textarea>
        </div>
        <div class="form-group">
            <label for="img">Example file input</label>
            <input type="file" class="form-control-file" id="img" name="imagem[]" multiple>
        </div>
        <button type="submit" class="btn btn-outline-dark">Adicionar objeto</button>
        </form>
    </div>
    <div class="col-4">
    <div class="alert alert-primary" role="alert">
       Lista de objetos cadastrados
    </div>
    <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">#</th>
                <!--<th scope="col">id do local</th>-->
                <th scope="col">nome</th>
                <th scope="col">patrimonio</th>
                <th scope="col">ação</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($obj as $o){ ?>
                <tr>
                <th scope="row"><?=$o['ID'];?></th>
                <!--<td><?php //$o['ID_Local']; ?></td>-->
                <td><?=$o['Nome'];?></td>
                <td><?php echo $o['Patrimonio'];?></td>
                <td><a href="config/editarObj.php?id=<?=$o['ID'];?>">editar</a>|<a href="config/deletarObj.php?id=<?=$o['ID'];?>" onclick="return confirm('tem certeza que vai excluir?');">Deletar</a></td>
                </tr>
            <?php } ?>
            </tbody>
            </table>
        
        </div>
        <div class="col-4">
        
    </div>
</div>
<a href="index.php" class="btn btn-outline-dark">Voltar para home</a>
</div>

<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>