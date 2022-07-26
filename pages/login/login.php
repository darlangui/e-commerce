<?php
    //pronto
    $con = mysqli_connect("localhost", "root", "", "ecommerce");
    if(mysqli_connect_errno()){ echo "Erro :" .mysqli_connect_error(); }
    
    if(isset($_SESSION['login']) and (isset($_SESSION['senha']))){
        header('Location: ../../');
    }

    $email = filter_input(INPUT_POST, "email", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
    $senha = filter_input(INPUT_POST, "password", FILTER_DEFAULT); // sempre usar filter --> mais indicado.    
    
    $query = "SELECT id, email, senha, tipo, nome FROM user";
    $result = $con->query($query);

    $verify = false; // variavel boleana que identica se a senha e email estão corretos.

    while($row = mysqli_fetch_assoc($result)){
        if(strlen($row['senha']) < 16){
            if(($row['senha'] == $senha) && ($row['email'] == $email)){
                // usuario e senha corretos.
                $verify = true;
                session_start(); // inicia a sessão do usuário.
                $_SESSION['user'] = $row['tipo'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['senha'] = $row['senha'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['id'] = $row['id'];
                header('Location: ../../');
                break;
            }
        }else{
            if((password_verify($senha, $row['senha'])) && ($row['email'] == $email)){
                // usuario e senha corretos.
                $verify = true;
                session_start(); // inicia a sessão do usuário.
                $_SESSION['user'] = $row['tipo'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['senha'] = $row['senha'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['id'] = $row['id'];
                header('Location: ../../');
                break;
            }
        }
    }
    if($verify == false){
        // usuario e senha incorretos.
        session_start();
        setcookie('status_login', 'true'); //cookie com status true de invalido
        header('Location: index.php');
    } 
    mysqli_close($con);
?>
