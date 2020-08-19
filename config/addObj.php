<?php
require("bd.php");
if(isset($_POST['idLocal']) && !empty($_POST['idLocal'])){
    
        $id_local = $_POST['idLocal'];
        $nome = addslashes($_POST['nome']);
        $patri = addslashes($_POST['patrimonio']);
        $desc = addslashes($_POST['desc']);

        $r = count($id_local) - 1;
        $idLocal = "";
        $n = 0;
        foreach($id_local as $i){
            if($n == $r){
                $idLocal .= $i;
            }else{
                $idLocal .= $i.",";
            }
            $n++;
            
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
              $sql = "INSERT INTO objetos (ID_Local, Nome, Patrimonio, descricao) VALUES (:idLocal, :nome, :patri, :descricao)";
              $sql = $pdo->prepare($sql);
              $sql->bindValue(":idLocal", $idLocal);
              $sql->bindValue(":nome", $nome);
              $sql->bindValue(":patri", $patri);
              $sql->bindValue(":descricao", $desc);
              $sql->execute();
        }

      
    }