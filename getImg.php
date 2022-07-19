<?php
	$con = mysqli_connect("localhost", "root", "", "ecommerce");

    if(mysqli_connect_errno()){
        echo "Erro :" .mysqli_connect_error();
    }
    $aux = $_GET['img'];
    $query = "SELECT * FROM produtos WHERE img = '".$aux."'";
    $result = $con->query($query);
    $row = mysqli_fetch_object($result);
	Header( "Content-type: image/gif");
	echo $row['img'];
?>