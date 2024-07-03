<?php
require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['entrar'])){
    $erros = array();
    $login = mysqli_escape_string($conn, $_POST['user']);
    $senha = mysqli_escape_string($conn, $_POST['senha']);

    if(empty($login) or empty($senha)){
        $erros[] = "<b>Os campos usuário e senha devem ser preenchidos!</b>";
    } else {
        $slUsuario = "SELECT * FROM usuario WHERE usuario = '$login' AND senha = '$senha'";
        $slUser = $conn->query($slUsuario);

        if($slUser->num_rows === 1){
            $dadosU = $slUser->fetch_assoc();
            $_SESSION['usuario'] = true;
            $_SESSION['user_nome'] = $dadosU['usuario'];
            $_SESSION['user_perm'] = $dadosU['perm'];
            header("location: index.php");
            exit();
        } else {
            $erros[] = "Usuário não encontrado :c";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
if(!empty($erros)):
    foreach($erros as $erro):
        echo "<div class='alert alert-danger' role='alert'>$erro</div>";
    endforeach;
endif;
?>
<form action="form-login.php" method="POST" style="margin-top: 5%;">
    <div class="mb-3">
        <label for="user" class="form-label">Usuário</label>
        <input type="text" name="user" class="form-control" id="user">
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" name="senha" id="senha">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Não sou um robô</label>
    </div>
    <input type="submit" value="Entrar" name="entrar" class="btn btn-primary">
    <a value="criar conta" name="criar" class="btn btn-primary" href="criar.php">Criar uma conta</a>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
