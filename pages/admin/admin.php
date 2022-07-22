<?php 
    session_start();
    if(isset($_SESSION['user'])){
        $con = mysqli_connect("localhost", "root", "", "ecommerce");

        if(mysqli_connect_errno()){
            echo "Erro :" .mysqli_connect_error();
        }

        $nome =  filter_input(INPUT_POST, "name", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $valor = filter_input(INPUT_POST, "price", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $categoria = filter_input(INPUT_POST, "category", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $prom = filter_input(INPUT_POST, "discount", FILTER_DEFAULT); // sempre usar filter --> mais indicado.
        $img = $_FILES["image"]; // recebe com arquivo a imagem
        if($prom == null){
            $prom = 00;
        }
        $error = array(); // array pra verificar possiveis erros.
        try {
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
    
                $caminho = "../../photos/" . $nomeimg;
                move_uploaded_file($img["tmp_name"], $caminho);
    
                $query = "INSERT INTO produtos (nome, valor, categoria, promo, img) VALUES ('$nome', '$valor', '$categoria', '$prom', '$nomeimg')";
                if($con->query($query) ==  TRUE){
                    header('Location: index.php');
                }else {
                    echo "Error: " . $query . "<br>" . $con->error;
                }
    
                $con->close();
            }
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
        if(count($error) != 0){
            foreach ($error as $erro) {
                echo $erro . "<br />";
            }
            $_SESSION['msg'] = true;
            header('Location: index.php');
        }
    }else{
        header('Location: ../../');
    }
?>