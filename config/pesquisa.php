<?php
require("bd.php");
$texto = $_POST['text'];

$sql = "SELECT * FROM objetos WHERE Nome LIKE :nome OR Patrimonio LIKE :patri";
$sql = $pdo->prepare($sql);
$sql->bindValue(":nome", $texto."%");
$sql->bindValue(":patri", $texto."%");
$sql->execute();
if($sql->rowCount() > 0){
    $lista = $sql->fetchAll();

    foreach($lista as $l){
        ?>
            <a class="item_lista" href="search.php?id=<?=$l['ID'];?>"><?=$l['Nome'];?></a>
        <?php
    }
}else{
    echo "item não encontrado";
}


