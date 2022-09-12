<?php require_once("conexao/conexao.php"); ?>
<?php
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }

    if ( isset($_GET["codigo"]) ) {
        $produto_id = $_GET["codigo"];
    } else {
        Header("Location: login.php");
    }

    // Consulta ao banco de dados
    $consulta = "SELECT * ";
    $consulta .= "FROM produto ";
    $consulta .= "WHERE idProduto = {$produto_id} ";
    $detalhe    = mysqli_query($conecta,$consulta);

    // Testar erro
    if ( !$detalhe ) {
        die("Falha no Banco de dados");
    } else {
        $dados_detalhe = mysqli_fetch_assoc($detalhe);
        $produtoID      = $dados_detalhe["idProduto"];
        $nomeproduto    = $dados_detalhe["nomeproduto"];
        $descricao      = $dados_detalhe["descproduto"];
        $imagem         = $dados_detalhe["imagem"];
        $valorproduto   = $dados_detalhe["valorproduto"];
        
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>produto</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/produto_detalhe.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?>
        
        <main>  
            <div id="detalhe_produto">
                 <img src="<?php echo $imagem ?>"><br><br>
                <ul>
                    <li><h2><?php echo $nomeproduto ?></h2></li><br>
                    <li><b>Descrição: </b><?php echo $descricao ?></li><br>
                    <li><b>Preço : </b><?php echo real_format($valorproduto) ?></li><br>
                    <?php
                        if (intval($idade_cliente) >= 18){?>
                        <a href="lance.php?codigo=<?php echo $produto_id?>"><b>Dar Lance</b></a><br>
                    <?php    }?>
                    <a href="listaleilao.php?codigo=<?php echo $nomeproduto?>"> Ver leilões no item</a>
                    <?php  if ($idCliente == "1"){?>
                        <li><a href="alteracao_produto.php?codigo=<?php echo $produtoID ?>">Alterar</a></li><?php }?>
                </ul>
               
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>