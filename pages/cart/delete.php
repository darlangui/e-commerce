<?php
session_start();
if(isset($_SESSION['nome'])){
    $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT); // FILTRO.
    $con = mysqli_connect("localhost", "root", "", "ecommerce");

    if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
    }

    $query = "DELETE FROM cart WHERE id = '$id'";

    if($con->query($query) ==  TRUE){
        echo "Deletado com sucesso";
        header('Location: index.php');
    }else {
        echo "Error: " . $query . "<br>" . $con->error;
    }

    $con->close();
}else{
    header('Location: ../../');
}
?>