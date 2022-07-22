<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iShopping</title>

  <link rel="stylesheet" href="../../global.css">
  <link rel="stylesheet" href="styles.css">
  <?php 
    session_start();
    if(isset($_SESSION['user'])){

    }else{
      header('Location: ../login');
    }
  ?>
</head>
<body>
  <main>
    <div class="success-content">
      <img src="../../assets/success-illustra.svg" alt="success">
      
      <h2>Compra concluida com sucesso 🤑</h2>
      <p>Obrigado por comprar conosco. Agora enquanto nós trabalhamos para sua compra chegar até você o mais rápido possível, que tal dar uma olhada em nosso site?</p>
      
      <a href="../../index.php">
        <button class="primary">Voltar ao site</button>
      </a>
    </div>
  </main>
</body>
</html>