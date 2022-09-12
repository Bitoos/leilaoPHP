<?php require_once("conexao/conexao.php"); ?>
<?php
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }

    $tr = "SELECT * FROM cliente ";
    $consulta_tr = mysqli_query($conecta, $tr);
    if(!$consulta_tr) {
        die("erro no banco");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastros</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="janela_transportadoras">
                <?php
                    while($linha = mysqli_fetch_assoc($consulta_tr)) {
                ?>
                <ul>
                    <li><?php echo $linha["nomecliente"] ?></li>
                    <li><?php echo $linha["usuario"] ?></li>
                    <li><?php echo $linha["email"]?></li>
                    <li><?php echo $linha["statuscliente"] ?></li>
                    <li><?php echo $linha["idade"]?></li>
                    <li><a href="alteracao_cadastro.php?codigo=<?php echo $linha["idCliente"] ?>">Alterar</a> </li>
                </ul>
                <?php
                    }
                ?>
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>