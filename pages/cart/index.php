<?php 
  session_start();
  if(isset($_SESSION['user'])){
    $con = mysqli_connect("localhost", "root", "", "ecommerce");

    if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
    }
  }else{
    header('Location: ../login');
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iShopping</title>

  <link rel="stylesheet" href="../../global.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container header">
    <div class="content">
      <a href="../../index.php">
        <img src="../../assets/logo-white.svg" alt="iShopping">
      </a>

      <div class="profile">
        <span id="profile"> <?php if(isset($_SESSION['nome'])){ echo  substr($_SESSION['nome'], 0, 1);} ?> </span>
      </div>
    </div>
  </div>
  
  <div class="container main">
    <div class="content">
      <section class="left">
        <h2>Carrinho</h2>
        <div class="products">
        <?php
          $total = 0;
          $prom = 0;
          $query = "SELECT * FROM cart WHERE user_id = {$_SESSION['id']}";
          $result = $con->query($query);
          while($row = mysqli_fetch_assoc($result)){
            $query = "SELECT * FROM produtos WHERE id = {$row['produtos_id']}";
            $results = $con->query($query);
            while($rows = mysqli_fetch_assoc($results)){
              $total = $rows['valor'] + $total;
              $prom = $rows['promo'] + $prom;
              echo "
              <div class='product'>
              <img class='product' src='../../photos/{$rows['img']}' alt='product'>
              <div class='product-content'>
                <p>{$rows['nome']}</p>
                <span class='price'>
                  <strong>R$ {$rows['valor']}</strong>
                  <span class='discount'>R$ {$rows['promo']}</span>
                </span>
              </div>
              <a class='delete' href ='delete.php?id={$row['id']}'>  <img src='../../assets/remove-icon.svg' alt='remove'> </a>
            </div>
            ";
            }
          }
        ?>
        </div>
      </section>

      <section class="right">
        <div class="top">
          <div class="line">
            <span>Produtos</span>
  
            <strong>R$ <?php echo $total; ?></strong>
          </div>
  
          <div class="line">
            <span>Frete</span>
  
            <strong>Grátis</strong>
          </div>
  
          <div class="line">
            <span>Descontos</span>
  
            <strong><?php if($prom == 0){echo '- -';}else{echo $prom;}?></strong>
          </div>
        </div>

        <div class="bottom">
          <div class="total">
            <span>Total</span>
            <h3>R$ <?php echo $total - $prom; ?></h3>
          </div>

          <a href="../success/index.php">
            <button class="primary">Confirmar compra</button>
          </a>
        </div>
      </section>
    </div>
  </div>

  <script src="../../utils/handleProfileDropdown.js"></script>
</body>
</html>