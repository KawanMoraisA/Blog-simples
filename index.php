<?php
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['buscar'])){
    $errosS = array();
    $search = mysqli_escape_string($conn, $_POST['search']);

    if(empty($search)){
        $errosS[] = "<b>Oque você deseja pesquisar?</b>";
    } else {
        $pesquisar = "SELECT * FROM post WHERE titulo LIKE '%$search%' or previa LIKE '%$search%' or conteudo LIKE '%$search%'";
        $pesquisa = mysqli_query($conn, $pesquisar);
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
        .conteudo{
            margin-top: 2%;
            word-wrap: break-word;
            overflow-wrap: break-word;
            min-width: 90%;
            max-width: 90%;
            box-sizing: border-box;
        }
        .left-coluna, .right-coluna {
            width: 20%;
            height: 100vh;
        }
        .main-conteudo {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 60%;
        }
    </style>
</head>
<body>
<?php
require 'navbar.html';
?>

<div class="d-flex justify-content-between">
    <div class="left-coluna border border-secondary">
        <?php
        if(isset($_SESSION['usuario'])){
            echo "<div class='alert alert-primary' role='alert' style='margin-top:5%;'>Olá ".$_SESSION['user_nome'].";</div>";
            echo "<div class='alert alert-primary' role='alert'>Clique <a href='logout.php' class='alert-link'>aqui</a> para deslogar.</div>";
            if(isset($_SESSION['user_perm']) && $_SESSION['user_perm'] == 1){
                echo "<div class='alert alert-primary' role='alert'>Clique <a href='add-posts.php' class='alert-link'>aqui</a> para adcionar um post</div>";
            }
            } else {
            require_once 'form-login.php';
        }
        ?>
    </div>
    <div class="main-conteudo border border-secondary">
        <?php
        if(isset($_POST['buscar'])){
            if($pesquisa){
                if(mysqli_num_rows($pesquisa) > 0){
                    while ($linhas = mysqli_fetch_assoc($pesquisa)){
                        echo"<div class='conteudo border border-secondary'>";
                        echo"<p class='font-monospace'>".$linhas['titulo']."</p>";
                        echo"<p class='text-start'>".$linhas['previa']."</p>";
                        echo"<p class='text-xxl-center'>".$linhas['conteudo']."</p>";
                        echo"</div>";
                    }
            
                }else{
                    echo"nenhum post encontrado :c";
                    echo "<div class='alert alert-primary' role='alert'>Clique <a href='index.php' class='alert-link'>aqui</a> para voltar.</div>";
                }
            }else{
                echo"erro na consulta: ". mysqli_error($conn);
            }
            
            mysqli_close($conn);
        }else{
            require_once "main-conteudo.php";
        }
        ?>
    </div>
    <div class="right-coluna border border-secondary">
        <form action="index.php" method="POST" class="d-flex" role="search" style="margin-top: 5%;">
            <input class="form-control me-2" type="search" name="search" placeholder="Pesquisar" aria-label="Search">
            <input class="btn btn-outline-success" type="submit" name="buscar" id="buscar" value="Buscar">
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
