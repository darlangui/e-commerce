<?php
    session_start();
    if(isset($_SESSION['user'])){
        $con = mysqli_connect("localhost", "root", "", "ecommerce");
        if(mysqli_connect_errno()){ echo "Erro :" .mysqli_connect_error(); }

        $valor = null; $prom = null; // define como nulo os valores.
        
        $id = filter_input(INPUT_POST, "id", FILTER_DEFAULT);
        $nome =  filter_input(INPUT_POST, "title", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $valor = filter_input(INPUT_POST, "price", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $categoria = filter_input(INPUT_POST, "category", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $prom = filter_input(INPUT_POST, "discount", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $img = $_FILES["imageInput"]; // recebe com arquivo a imagem
        
        $error = array(); // array pra verificar possiveis erros.

        try {
            if($img["size"] == 0){

                $query = "UPDATE produtos SET nome='$nome', valor='$valor', categoria='$categoria', promo='$prom' WHERE id = '$id'";

                if($valor == null){
                    $query = "UPDATE produtos SET nome='$nome', categoria='$categoria', promo='$prom' WHERE id = '$id'";
                }
                if($prom == null){
                    $query = "UPDATE produtos  SET nome='$nome', valor='$valor', categoria='$categoria' WHERE id = '$id'";
                }
                if(($valor == null) && ($prom == null)){
                    $query = "UPDATE produtos SET nome='$nome', categoria='$categoria' WHERE id= '$id' ";
                }
                
                if($con->query($query) ==  TRUE){
                    echo "Alterado com sucesso";
                    header('Location: index.php');
                }
                //else { echo "Error: " . $query . "<br>" . $con->error; }
    
                $con->close(); // fecha a conexão com o bd.
            }else{
                if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $img["type"])){ //verifica se o arquivo passado é uma imagem.
                    $_SESSION['msg'] = true;
                    $error[1] = "Isso não é uma imagem.";
                } 
                
                $tam = 1000000;
                $alt = 390;
                $larg = 322;
                $dimen = getimagesize($img["tmp_name"]);
            
                
                if($dimen[0] > $larg) { // Verifica se a largura da imagem é maior que a largura permitida
                    $error[2] = "A largura da imagem não deve ultrapassar ".$larg." pixels";
                }
                if($dimen[1] > $alt) { // Verifica se a altura da imagem é maior que a altura permitida
                    $error[3] = "Altura da imagem não deve ultrapassar ".$alt." pixels";
                }
                if($img["size"] > $tam) { // Verifica se o tamanho da imagem é maior que o tamanho permitido
                        $error[4] = "A imagem deve ter no máximo ".$tam." bytes";
                }

                if (count($error) == 0) {
    
                    preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img["name"], $ext); // pega a extensão da imagem.
        
                    $nomeimg = md5(uniqid(time())) . "." . $ext[1]; // gera um nome unico para a imagem.
        
                    $caminho = "../../photos/" . $nomeimg; // define o caminho onde a imagem sera salva.
                    move_uploaded_file($img["tmp_name"], $caminho);

                    $query = "SELECT * FROM produtos WHERE id = '$id'";
                    $result = $con->query($query);
                    $row = mysqli_fetch_object($result);
                    unlink("../../photos/".$row->img."");
                    
                    $query = "UPDATE produtos SET nome='$nome', valor='$valor', categoria='$categoria', promo='$prom', img='$nomeimg' WHERE id = '$id'";
    
                    if($valor == null){
                        $query = "UPDATE produtos SET nome='$nome', categoria='$categoria', promo='$prom', img='$nomeimg' WHERE id = '$id'";
                    }
                    if($prom == null){
                        $query = "UPDATE produtos  SET nome='$nome', valor='$valor', categoria='$categoria', img='$nomeimg' WHERE id = '$id'";
                    }
                    if(($valor == null) && ($prom == null)){
                        $query = "UPDATE produtos SET nome='$nome', categoria='$categoria', img='$nomeimg' WHERE id= '$id' ";
                    }
                    
                    if($con->query($query) ==  TRUE){
                        echo "Alterado com sucesso";
                        header('Location: index.php');
                    }
                    //else { echo "Error: " . $query . "<br>" . $con->error; }
        
                    $con->close(); // fecha a conexão com o bd.
                }
            }
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }

        if(count($error) != 0){
            foreach ($error as $erro) {
                echo $erro . "<br />";
            }
            $_SESSION['msgalter'] = true;
            header('Location: index.php');
        }
    }else{
        header('Location: ../../'); // manda pra home.
    }
?>