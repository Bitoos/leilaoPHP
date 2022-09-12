<?php require_once("conexao/conexao.php");

    session_start();

    if (isset($_POST["usuario"])){
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        $login = "SELECT * FROM cliente WHERE usuario = '{$usuario}' and senha = '{$senha}'";
        
        $acesso = mysqli_query($conecta,$login);

        if (!$acesso){
            die("Falha na consulta do banco");

        }
        $informacao = mysqli_fetch_assoc($acesso);

        if (empty($informacao)){
            $mensagem = "Login sem sucesso";
        }else{
            $_SESSION["user_portal"] = $informacao["idCliente"];
            header("location:listagem.php");
        }
    }
?>


<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login em Leilão</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/login.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?>
        
        <main>  
            <div id="janela_login">
                <form action="login.php" method="post">
                    <h2>Tela de Login</h2>
                    <input type="text" name="usuario" placeholder="usuario">
                    <input type="password" name="senha" placeholder="Senha">
                    <input type="submit" value="Login">
                    <a href="userCadastro.php" id="cadastro"> <img src="images/cadastro.png"></a>


                    <?php
                        if(isset($mensagem)){

                    ?>
                    <p><?php echo $mensagem ?></p>
                    <?php } ?>

                </form>
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php

    mysqli_close($conecta);
?>