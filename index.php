<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iShopping</title>

  <link rel="stylesheet" href="./global.css">
  <link rel="stylesheet" href="./styles.css">
</head>
<body>
  <?php 
    $type = 'nav container';
    $cart = 'cart blank';

    function queryConnect($table){
      $con = mysqli_connect("localhost", "root", "", "ecommerce");
      if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
      }

      $query = "SELECT * FROM produtos WHERE categoria = '$table'";
      $result = $con->query($query);
      while($row = mysqli_fetch_assoc($result)){

        if($row['promo'] == 0){
          echo "
            <form method='post' action='purchase.php'>
              <div class='product'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <img src='photos/{$row['img']}' alt='Product'>
                <section class='content'>

                  <p> {$row['nome']} </p>
                    
                  <span class='price'>
                      <strong> R$ {$row['valor']} </strong>
                  </span>

                  <button class='tertiary'>
                    Comprar
                  </button>
                </section>
              </div>
            </form>
          ";
        }else{
          $valor_new = 0;
          $valor_new = $row['valor'] - $row['promo'];
          echo "
            <form method='post' action='purchase.php'>
              <div class='product onSale'>
                <img src='photos/{$row['img']}' alt='Product'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <section class='content'>

                    <p>{$row['nome']}</p>
                      
                  <span class='price'>
                    <strong>R$ {$valor_new}</strong>
                  
                    <span class='discount'>
                      R$ {$row['valor']}
                    </span>
                  </span>

                  <button class='tertiary'>
                    Comprar
                  </button>
                </section>
              </div>
            </form>
          ";
        }
      }
      $con->close();
    }

    session_start();
    if(isset($_SESSION['user'])){
      if($_SESSION['user'] == 'adm'){
        $type = 'nav container isLogged isAdmin';
      }else{
        $con = mysqli_connect("localhost", "root", "", "ecommerce");

        if(mysqli_connect_errno()){
          echo "Erro :" .mysqli_connect_error();
        }
        $query = "SELECT * FROM cart WHERE user_id = '{$_SESSION['id']}'";
        $result = $con->query($query);
        $cont_cart = 0;
        while($row = mysqli_fetch_assoc($result)){
          $cont_cart++;
        }
        if($cont_cart != 0){
          $cart = 'cart hasProducts';
        }
        $con->close();
        $type = 'nav container isLogged';
      }
    }
  ?>
  <header>
    <div class="banner container">
      <div class="content">
        <img src="./assets/percent-icon.svg" alt="icon-percent">

        <span>Os melhores descontos do mercado !</span>
      </div>
    </div>

    <!--  Tags nav container: isLogged isAdmin -->

    <div class="<?php echo $type; ?>">
      <div class="content">
        <section class="left">
          <img src="./assets/logo-white.svg" alt="iShopping">  
          <ul>
            <li onclick="window.scrollTo(0, 400)">Informática</li>
            <li onclick="window.scrollTo(0, 950)">Celulares</li>
            <li onclick="window.scrollTo(0, 1500)">Móveis</li>
            <li onclick="window.scrollTo(0, 2050)">Notebooks</li>
            <li onclick="window.scrollTo(0, 2600)">Doméstico</li>
          </ul>
        </section>

        <section class="right">

          <!--  Tags cart: hasProducts blank -->

          <div class="<?php echo $cart; ?>">
            <a href="./pages/cart/index.php">
              <img class="hasProducts" src="./assets/shopping-cart-filled-icon.svg" alt="shooping-cart">
              <img class="blank" src="./assets/shopping-cart-icon.svg" alt="shooping-cart">
            </a>
          </div>

          <div class="settings">
            <a href="./pages/admin/index.php">
              <img src="./assets/settings-icon.svg" alt="settings">
            </a>
          </div>
          
          <button class="login">
            <a href="./pages/login/index.php">Entrar</a>
          </button>
        

          <div class="profile">
            <span id="profile"> <?php  if(isset($_SESSION['nome'])){ echo strtoupper(substr($_SESSION['nome'], 0, 1));} ?>  </span>

            <div id="dropdown" class="logout-dropdown">
              <div class="logout-content">
                <div class="section">
                  <img src="./assets/logout-icon.svg" alt="logou">
                    <form method="post">
                      <button id="logout" type="submit" class="sair" name='sair'>Sair</button>
                    </form>
                  <?php 
                    if(isset($_POST['sair'])){
                      if(isset($_SESSION['user'])){
                        unset($_SESSION['user']);
                        unset($_SESSION['email']);
                        unset($_SESSION['senha']);
                        unset($_SESSION['nome']);
                        unset($_SESSION['id']);
                        header('Location: index.php');
                      } 
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>
    </div>
  </header>

  <main>
    <div class="hero-banner container">
      <div class="content">
        <h1>Tudo o que você precisa 🤘🏼</h1>
        <p>De sofás aos últimos lançamentos tecnológicos. Confira abaixo nossos produtos e promoções!</p>
        <span>
          <strong>Veja as novidades</strong>

          <img src="./assets/arrow-down-icon.svg" alt="arrow-down">
        </span>

        <img class="elements" src="./assets/elements-hero-banner.svg">
        <img class="iphone" src="./assets/iphone-mockup.png">
      </div>
    </div>
  </main>

  <article class="products">
    <div class="container">
      <div class="content">
        <section class="category">
          <h3>Informática</h3>
    
          <div class="category-products">
          <?php 
            queryConnect('informatica');
          ?>
          </div>
        </section>

        <section class="category">
          <h3>Celulares</h3>
              
          <div class="category-products">
            <?php 
              queryConnect('celulares');
            ?>
          </div>
        </section>

        <section class="category">
          <h3>Móveis</h3>
          <div class="category-products">
          <?php 
              queryConnect('moveis');
          ?>
          </div>
        </section>

        <section class="category">
          <h3>Notebooks</h3>
              
          <div class="category-products">
          <?php 
              queryConnect('notebooks');
          ?>
          </div>
        </section>

        <section class="category">
          <h3>Doméstico</h3>
    
          <div class="category-products">
          <?php 
            queryConnect('domesticos');
          ?>
          </div>
        </section>
      </div>
    </div>
  </article>

  <footer>
    <div class="footer container">
      <div class="content">
        <img src="./assets/logo-white.svg" alt="iShopping">

        <p>iShopping 2022. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <script src="./utils/handleProfileDropdown.js"></script>
</body>
</html>