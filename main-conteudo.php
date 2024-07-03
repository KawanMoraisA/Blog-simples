<?php
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$blogSelect = "SELECT * FROM post ORDER BY id DESC";
$resultado = mysqli_query($conn, $blogSelect);

if($resultado){
    if(mysqli_num_rows($resultado) > 0){
        while ($row = mysqli_fetch_assoc($resultado)){
            echo"<div class='conteudo border border-secondary'>";
            echo"<p class='font-monospace'>".$row['titulo']."</p>";
            echo"<p class='text-start'>".$row['previa']."</p>";
            echo"<p class='text-xxl-center'>".$row['conteudo']."</p>";
            echo"</div>";
        }

    }else{echo"nenhum post encontrado :c";}
}else{
    echo"erro na consulta: ". mysqli_error($conn);
}

mysqli_close($conn);
?>