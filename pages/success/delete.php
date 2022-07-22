<?php 
    session_start();
    if(isset($_SESSION['user'])){
      $con = mysqli_connect("localhost", "root", "", "ecommerce");

      if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
      }
      $query = "SELECT * FROM cart WHERE user_id = '{$_SESSION['id']}'";
      $result = $con->query($query);

      while($row = mysqli_fetch_assoc($result)){
        $query = "DELETE FROM cart WHERE id = '{$row['id']}'";
        if($con->query($query) == TRUE){
            echo "deletado";
        }else{
          echo "Error: " . $query . "<br>" . $con->error;
        }
      }
      header('Location: index.php');
    }else{
      header('Location: ../login');
    }
?>