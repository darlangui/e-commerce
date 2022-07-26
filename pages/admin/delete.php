<?php
    session_start(); // inicia a sessão.
    if(isset($_SESSION['user'])){ // verifica se existe a sessão do usuário.
        
        $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT); // FILTRO.

        $con = mysqli_connect("localhost", "root", "", "ecommerce");
        if(mysqli_connect_errno()){ echo "Erro :" .mysqli_connect_error(); }

        $query = "SELECT * FROM produtos WHERE id = '$id'"; // Seleciona o produto com base no id passado.
        $result = $con->query($query);
        $row = mysqli_fetch_object($result);

        unlink("../../photos/".$row->img.""); // apaga a imagem do caminho em que ela voi salvada.

        $query = "DELETE FROM produtos WHERE id = '$id'"; // deleta a linha do id definido.

        if($con->query($query) ==  TRUE){ // executa a query caso retorne false ocorreu algum erro.
            // echo "Deletado com sucesso";
            header('Location: index.php');
        }
        //else { echo "Error: " . $query . "<br>" . $con->error; }

        $con->close();// fecha a conexão com o bd.
    }else{
        header('Location: ../../'); // manda pra home.
    }
?>