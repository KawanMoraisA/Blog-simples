<?php
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['user_perm']) && $_SESSION['user_perm'] == 1){
    echo"<div class='alert alert-success' role='alert' style='margin-top:2%;'>Bem vindo ao adcionar post, ".$_SESSION['user_nome']."</div>";
    echo "<div class='alert alert-primary' role='alert'>Clique <a href='index.php' class='alert-link'>aqui</a> para voltar.</div>";
}else{
    header('index.php');
}

if(isset($_POST['enviar'])){
    $erros = array();
    $titulo = mysqli_escape_string($conn, $_POST['titulo']);
    $previa = mysqli_escape_string($conn, $_POST['previa']);
    $texto = mysqli_escape_string($conn, $_POST['texto']);

    if(empty($titulo) or empty($previa) or empty($texto)){
        $erros[] = "<b>todos os campos devem ser preenchidos!</b>";
    } else {
        $slUsuario = "INSERT INTO post (id, titulo, previa, conteudo) VALUES (NULL, '$titulo', '$previa', '$texto');";
        $slUser = $conn->query($slUsuario);

        header('index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .formulario{
            margin: 1%;
            padding: 1%;
            width: 90vh;
        }
    </style>
</head>
<body>
    <div class="formulario border border-secondary">
    <form action="add-posts.php" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="titulohelp">
            <div id="titulohelp" class="form-text">Titulo para o post.</div>
        </div>
        <div class="mb-3">
            <label for="previa" class="form-label" >Previa</label>
            <textarea class="form-control" id="previa" rows="3" name="previa"></textarea>
        </div>
        <div class="mb-3">
            <label for="texto" class="form-label">Texto</label>
            <textarea class="form-control" id="texto" rows="10" name="texto"></textarea>
        </div>
        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>