<?php
    require('config/bd.php');

    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email = addslashes($_POST['email']);
        $senha = md5(addslashes($_POST['senha']));

        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha"; //criamos uma pesquisa
        $sql = $pdo->prepare($sql); //preparamos a pesquisa
        $sql->bindValue(":email", $email); //trocamos o valor por outro
        $sql->bindValue(":senha", $senha);
        $sql->execute(); //executemos

        if($sql->rowCount() > 0){ //se numero de linha for maior que 0 
            $dados = $sql->fetch(); //pegar todos os dados
           
            $id = $dados['ID']; //pegar apenas o id
            $_SESSION['user'] = $id; //criamos uma sessão com o id

            header("Location: index.php"); //direcionamos para o index
        }else{ 
            echo "email e/ou senha errados"; 
        }
        
    }
?>
<!DOCTYPE html>
<html>
<head>
<title> Login Fatec </title>
<link rel="stylesheet" type="text/css" href="assets/css/login.css"> 
</head>
<body>
<section class="full_login">
    <div class="formulario_login">
        <img src="assets/img/fatec.jpg">
        <form method="POST"> 
        <input class="input_login" type="email" placeholder="E-mail" name="email">
        <input class="input_login" type="password"  placeholder="Senha" name="senha">
        <button type="submit" class="btn_login">Entrar</button>
        </form>
    </div>
</section>
</body>
</html>