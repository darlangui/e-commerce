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
  <script>
  </script>
  <?php
    session_start();
    if(isset($_SESSION['nome'])){
        $nome = $_SESSION['nome'];
        $cont = 0;
        $color = null;
        $con = mysqli_connect("localhost", "root", "", "ecommerce");

          if(mysqli_connect_errno()){
            echo "Erro :" .mysqli_connect_error();
          }
          $query = "SELECT * FROM produtos";
          $result = $con->query($query);
          while($row = mysqli_fetch_assoc($result)){  
            $cont++;
          }

        if(isset($_SESSION['msg'])){
          if($_SESSION['msg'] ==  true){
            $cor = 'red';
            unset($_SESSION['msg']);
          }
        }
        if(isset($_SESSION['msgalter'])){
          $color = 'red';
          unset($_SESSION['msgalter']);
        }
    }else{
      header('Location: ../login');
    }
  ?>
  <div class="container admin">
    <div class="content">
      <img src="../../assets/black-settings-icon.svg" alt="settings">
      
      <span>Sessão do administrador</span>
    </div>
  </div>

  <div class="container header">
    <div class="content">
      <a href="../../index.php">
        <img src="../../assets/logo-white.svg" alt="iShopping">
      </a>

      <div class="profile">
        <span id="profile"> <?php $letra =  substr($nome, 0, 1); echo $letra; ?> </span>
      </div>
    </div>
  </div>

  <div class="container main">
    <div class="content">
      <header>
        <h2>Lista de produtos</h2>

        <section class="right">
          <span>Total de <?php echo $cont; ?> items</span>

          <button id="openModal" class="primary" style="background-color: <?php echo $cor ?>;">
            <img src="../../assets/add-icon.svg" alt="add" >
          </button>
        </section>
      </header>

      <div class="filters">
        <form action="#">
          <div class="filter">
            <button type="submit">Informática</button>
          </div>

          <div class="filter active">
            <button type="submit">Celulares</button>
          </div>

          <div class="filter">
            <button type="submit">Móveis</button>
          </div>

          <div class="filter">
            <button type="submit">Notebooks</button>
          </div>

          <div class="filter">
            <button type="submit">Domésticos</button>
          </div>

          <div class="filter">
            <button type="submit">Promoções</button>
          </div>
        </form>
      </div>
      <div class="products">
        <?php 
        
        $query = "SELECT * FROM produtos";
        $result = $con->query($query);
        while($row = mysqli_fetch_assoc($result)){
          $informatica = null; $celulares = null; $moveis = null; $notebooks = null; $domesticos = null;
          switch($row['categoria']){
          case 'informatica':
            $informatica = 'selected';
          break;
          case 'celulares':
            $celulares = 'selected';
          break;
          case 'moveis':
            $moveis = 'selected';
          break;
          case 'notebooks':
            $notebooks = 'selected';
          break;
          case 'domesticos':
            $domesticos = 'selected';
          break;
          }
          echo "<div class='product'>
          <form action='alter.php' method='post' enctype='multipart/form-data' class='save'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <section class='image'>
              <div class='image-container'>
                <img src='../../photos/{$row['img']}' alt='product' style='border-color: $color;'>
              </div>

              <div class='input-container'>
                <input type='file' name='imageInput'>
              </div>
            </section>

          <section class='content'>
            <textarea class='title' name='title' placeholder='Nome do produto'>{$row['nome']}</textarea>

            <div class='price-container'>
              <input type='text' class='price' name='price' placeholder='R$ {$row['valor']}'>
              <input type='text' class='discount' name='discount' placeholder='R$ {$row['promo']}'>
            </div>

            <div class='options'>
              <select name='category'>
                <option value='informatica' $informatica>Informática</option>
                <option value='celulares' $celulares>Celulares</option>
                <option value='moveis' $moveis>Móveis</option>
                <option value='notebooks' $notebooks>Notebooks</option>
                <option value='domesticos' $domesticos>Domésticos</option>
              </select>

              <a class='delete option' href ='delete.php?id={$row['id']}'>
                <img src='../../assets/delete-icon.svg' alt='delete'>
              </a>
              
              <button class='save option'>
                <img src='../../assets/check-icon.svg' alt='save'> 
              </button>
            </div>
          </section>
        </form>
      </div>
      ";}
      ?> 
      </div>
    </div>
  </div>

  <!--  Tags modal: off -->

  <div id="modal" class="modal off">
    <div class="modal-content">
      <h3>Adicionar produto</h3>
      <form action="admin.php" method="post" enctype="multipart/form-data">
        <div class="content">
          <div class="input-container">
            <label for="name">Nome:</label>
            <input type="text" name="name" placeholder="Apple iPhone 13 Pro Max (256gb) - Prateado"  required>
          </div>
  
          <div class="input-container small">
            <label for="price">Valor:</label>
            <input type="text" name="price" placeholder="R$ 0,00" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          </div>
  
          <div class="input-container small">
            <label for="category">Categoria:</label>
            <select name="category" required>
              <option value="informatica">Informática</option>
              <option value="celulares">Celulares</option>
              <option value="moveis">Móveis</option>
              <option value="notebooks">Notebooks</option>
              <option value="domesticos">Domésticos</option>
            </select>
          </div>
  
          <div class="input-container small">
            <label for="discount">Promoção (opcional):</label>
            <input type="text" name="discount" placeholder="R$ 0,00" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
          </div>
  
          <div class="input-container small">
            <label for="image">Imagem</label>
            <input type="file" name="image" style="border-color: <?php echo $cor; ?>" required>
          </div>
        </div>

        <div class="buttons">
          <button id="closeModal" class="secondary">Cancelar</button>
          <button type="submit" class="primary"> Adicionar </button>
        </div>
      </form>
    </div>
  </div>

  <script src="../../utils/handleModalProduct.js"></script>
</body>
</html>