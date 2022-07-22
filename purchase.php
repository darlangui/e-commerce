<?php
    session_start();
    if(isset($_SESSION['user'])){
        if($_SESSION['user'] == 'adm'){
            header('Location: index.php');
        }else{
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $con = mysqli_connect("localhost", "root", "", "ecommerce");

            if(mysqli_connect_errno()){
                echo "Erro :" .mysqli_connect_error();
            }

            $query = "INSERT INTO cart (produtos_id, user_id) VALUES ('$id', '{$_SESSION['id']}')";

            if($con->query($query) ==  TRUE){
                session_start(); 
                header('Location: pages/cart');
            }else {
                echo "Error: " . $query . "<br>" . $con->error;
            }
        }
    }else{
        header('Location: pages/login/');
    }
?>