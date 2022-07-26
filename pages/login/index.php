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
  <?php
    session_start(); // inciia a sessão. 
    if(isset($_COOKIE['status_login'])){ // verifica se o status_login tem algum erro.
        if($_COOKIE['status_login'] == 'true'){
          $cor = 'red';
          setcookie('status_login', 'false');
        }
    }
  ?>
  <main>
    <section class="left">
      <a href="../../index.php" class="logo">
        <img src="../../assets/logo.svg" alt="iShopping">
      </a>

      <div class="form">
        <form action="login.php" method="post">
          <h2>Bem vindo novamente 😎</h2>
  
          <div class="input-container">
            <label for="email">E-mail</label>
            <input type="text" name="email" style="border-color: <?php echo $cor ?>;" id="email" placeholder="email@email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email']; session_destroy(); unset($_SESSION['email']);} ?>" required>
          </div>
  
          <div class="input-container"> 
            <label for="password">Sua senha</label>
            <input type="password" name="password" style="border-color: <?php echo $cor ?>;" id="password" placeholder="Sua senha" required>
            <label for="email" style="color : red"> <br><br> <?php if(isset($cor)){echo 'E-mail ou senha incorretos!';} ?></label>
          </div>

          <button class="primary" type="submit">Entrar</button>

          <div class="redirect">
            <span>
              Não possui uma conta? <a href="../register/">Cadastre-se</a>
            </span>
          </div>
        </form>
      </div>
    </section>

    <section class="right">
      <div class="circle"></div>

      <div class="blur"></div>
    </section>
  </main>
</body>
</html>