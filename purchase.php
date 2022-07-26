<?php
    session_start(); // inicia a sessão.
    if(isset($_SESSION['user'])){ // verifica se a sessão se usuario existe.
        if($_SESSION['user'] == 'adm'){ 
            header('Location: index.php'); // verifica se o usuario é adm se for redireciona ele para a pag home
        }else{
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT); // pega o identificador 

            $con = mysqli_connect("localhost", "root", "", "ecommerce"); // conexão com o bd
            if(mysqli_connect_errno()){  echo "Erro :" .mysqli_connect_error(); }

            $query = "INSERT INTO cart (produtos_id, user_id) VALUES ('$id', '{$_SESSION['id']}')";

            if($con->query($query) ==  TRUE){ // executa query se retornar false aconteceu algum erro.
                $con->close();  // fecha a conexão com o bd.
                header('Location: pages/cart');
            }
            $con->close(); // fecha a conexão com o bd.
            //else { echo "Error: " . $query . "<br>" . $con->error; } exibe o erro da query no bd.
        }
    }else{ // caso não exista ele é redirecionado
        header('Location: pages/login/'); // redireciona para a pag de login
    }
?>