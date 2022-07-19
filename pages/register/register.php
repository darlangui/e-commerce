<?php
    //pronto
    $con = mysqli_connect("localhost", "root", "", "ecommerce");

    if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
    }

    $nome = filter_input(INPUT_POST, "nome", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
    $email = filter_input(INPUT_POST, "email", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
    $cpf = filter_input(INPUT_POST, "cpf", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
    $senha = filter_input(INPUT_POST, "password", FILTER_DEFAULT); // sempre usar filter --> mais indicado.

    $senha_cript = password_hash($senha, PASSWORD_DEFAULT);  // criptografia padrão utilizando a função hash

    // verifica se esse email ja esta cadastrado.
    $query = "SELECT email FROM user";
    $result = $con->query($query);
    $check = false;
    while($row = mysqli_fetch_assoc($result)){
        if($row["email"] == $email){
            $check = true;
        }
    }

    if($check == true){
        // echo "esse email ja existe!";
        session_start();
        $_SESSION['msg'] = $check;
        header('Location: index.php');
    }else{
        // cadastra o usuario.
        $query = "INSERT INTO user (nome, email, senha, cpf, tipo) VALUES ('$nome', '$email', '$senha_cript', '$cpf', 'user')";
        if($con->query($query) ==  TRUE){
            session_start();
            $_SESSION['email'] = $email; 
            header('Location: ../login/');
        }else {
            echo "Error: " . $query . "<br>" . $con->error;
        }
    }
    mysqli_close($con);
?>