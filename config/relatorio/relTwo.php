<?php 
    require("../bd.php");

    $sql = "SELECT * FROM locais WHERE Predios = 2";
    $sql = $pdo->query($sql);
    $id = [];

    if($sql->rowCount() > 0){
        $dados = $sql->fetchAll();
    }
    foreach($dados as $d){
        $id[] = $d['ID'];
    }

    $sql = "SELECT * FROM objetos";
    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0){
        $obj = $sql->fetchAll();
    }
    $objs = [];
    foreach($obj as $o){
        $idLocalObj = explode(",", $o['ID_Local']);
        if(count($idLocalObj) > 1){
            foreach($idLocalObj as $p){
                $objs[] = array('id' => $o['ID'], 'id_local' => $p);
            }
        }else{
            $objs[] = array('id' => $o['ID'], 'id_local' => $idLocalObj[0]);
        }
    }
    $objetos = [];
    foreach($objs as $ob){
        if(in_array($ob['id_local'], $id)){
            $objetos[] = $ob['id'];
        }
    }
    $objetos = array_unique($objetos);
    
    $tt = [];
    foreach($objetos as $img){
        $sql = "SELECT * FROM objetos WHERE id = ".$img;
        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0){
            $ta = $sql->fetch();
            $tt[$ta['ID']] = $ta; 
        }
    }
    $lo = [];
    foreach($dados as $d){
        $lo[$d['ID']] = $d['Sala'];
    }
    
    
    
?>
<h1>Relatório prédio 2</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">Patrimonio</th>
      <th scope="col">descrição</th>
      <th scope="col">Sala</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($tt as $y){ ?>
    <tr>
      <td><?=$y['Nome'];?></td>
      <td><?=$y['Patrimonio'];?></td>
      <td><?=$y['descricao'];?></td>
      <td><?php
            echo $lo[$y['ID_Local']];
        ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>