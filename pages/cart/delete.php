<?php
session_start(); // inicia a sessão.
if(isset($_SESSION['nome'])){ // verifica se o usuário tem uma sessão.

    $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT); // FILTRO.

    $con = mysqli_connect("localhost", "root", "", "ecommerce");
    if(mysqli_connect_errno()){ echo "Erro :" .mysqli_connect_error(); }

    $query = "DELETE FROM cart WHERE id = '$id'"; // deleta as compras do usuário.
    if($con->query($query) ==  TRUE){
        //echo "Deletado com sucesso";
        header('Location: index.php');
    }
    //else { echo "Error: " . $query . "<br>" . $con->error; }

    $con->close(); // encerra a conexão com o bd.
}else{
    header('Location: ../../'); // manda para o home.
}
?>