<?php require_once("conexao/conexao.php");

    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }
    //exclusão
    if(isset($_POST["idProduto"])){
        $pid = $_POST["idProduto"];
        $exclusao = "DELETE FROM produto where idProduto = {$pid}";
        $consulta_exclusao = mysqli_query($conecta,$exclusao);
        if (!$consulta_exclusao){
            die("erro no banco");
        }else{
            $exclusao_lance = "DELETE FROM lance where idProduto = {$pid}";
            $consulta_exclusao = mysqli_query($conecta,$exclusao_lance);
            header("location:listagem.php");
        }
    }
    //consulta
    if (isset($_GET["codigo"])){
        $id = $_GET["codigo"];
        $prod_del = "SELECT * FROM produto WHERE idProduto = {$id}";
        $consulta_prod = mysqli_query($conecta,$prod_del);
        if (!$consulta_prod){
            die("erro no banco");
        }
    }else{
        header("location:listagem.php");
    }
    $info_produto = mysqli_fetch_assoc($consulta_prod);
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>exclusao de item</title>
        
        
        <link href="_css/estilo.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?> 
        
        <main>  
            <h2>Você deseja excluir o produto: <?php echo $info_produto["nomeproduto"]?>?</h2>
            <form action="exclusao.php" method="post">
                <input type="hidden" name="idProduto" value="<?php echo $info_produto["idProduto"]?>">
                <input type="submit" value="confirmar exclusão">
            </form>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>