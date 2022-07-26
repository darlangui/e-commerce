<?php 
    session_start(); // inicia a sessão.
    if(isset($_SESSION['user'])){ // verifica se o usuário existe na sessão.
      $con = mysqli_connect("localhost", "root", "", "ecommerce");
      if(mysqli_connect_errno()){ echo "Erro :" .mysqli_connect_error(); }
      
      $query = "SELECT * FROM cart WHERE user_id = '{$_SESSION['id']}'";
      $result = $con->query($query);
      while($row = mysqli_fetch_assoc($result)){
        $query = "DELETE FROM cart WHERE id = '{$row['id']}'";

        if($con->query($query) == TRUE){
            echo "deletado";
        }
        //else{ echo "Error: " . $query . "<br>" . $con->error; }
      }
      header('Location: index.php'); // dps de deletar todas as compras do usuario volta para home.
    }else{
      header('Location: ../login'); // manda para o login.
    }
?>