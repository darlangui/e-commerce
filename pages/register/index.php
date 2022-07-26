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
    session_start(); // inicia a sessão do usuário.
    if(isset($_SESSION['msg'])){ // verifica se não há mensagem de erro no resgistro.
        if($_SESSION['msg'] == true){
          $cor = 'red';
          session_destroy();
          unset($_SESSION['msg']);
        }
    }
  ?>
  
  <main>
    <section class="left">
      <a href="../../index.html" class="logo">
        <img src="../../assets/logo.svg" alt="iShopping">
      </a>

      <div class="form">
        <form action="register.php" method="post">
          <h2>Descontos lhe esperam 🤑</h2>
  
          <div class="input-container">
            <label for="nome">Seu nome</label>
            <input type="text" name="nome" id="nome" placeholder="Alfredo da Silva" required>
          </div>
  
          <div class="input-container">
            <label for="email">E-mail</label>
            <input type="text" style="border-color: <?php echo $cor ?>;" name="email" id="email" placeholder="email@email.com" required>
          </div>
  
          <div class="input-container">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" minlength="11" maxlength="11" required>
          </div>
  
          <div class="input-container">
            <label for="password">Sua senha</label>
            <input type="password" name="password" id="password" placeholder="Sua senha"  minlength="8" required>
          </div>

          <button class="primary" type="submit">Criar conta</button>

          <div class="redirect">
            <span>
              Já possui uma conta? <a href="../login/index.php">Fazer login</a>
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