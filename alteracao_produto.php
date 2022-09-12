<?php require_once("conexao/conexao.php"); 
    $cliente = "SELECT * FROM cliente ";

    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }



    if (isset($_POST["nomeproduto"])){
        $nome       = $_POST["nomeproduto"];
        $estoque   = $_POST["estoque"];
        $statusproduto     = $_POST["statusproduto"];
        $descproduto     = $_POST["descproduto"];
        $valorproduto        = $_POST["valorproduto"];
        $id_produto = $_POST["idProduto"];

        $alterar    = "UPDATE produto SET nomeproduto = '{$nome}', estoque = '{$estoque}', statusproduto = '$statusproduto', valorproduto ='{$valorproduto}', descproduto = '{$descproduto}' WHERE idProduto = '{$id_produto}'";

        $operacao_alteracao = mysqli_query($conecta,$alterar);
        if (! $operacao_alteracao){
            die("erro no banco");
        }else{
            header("location:listagem.php");
        }
    }

    $produto = "SELECT * FROM produto ";
    if(isset($_GET["codigo"])){
        $id= $_GET["codigo"];
        $produto .=" WHERE idProduto = {$id}";
    }else{
        header("location:listagem.php");
    }

    $con_produto = mysqli_query($conecta,$produto);
    if(!$con_produto){
        die("erro no banco de dados");

    }else{
        $info_produto = mysqli_fetch_assoc($con_produto);
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alteração de produto</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="janela_formulario">
                <form action="alteracao_produto.php" method="post">
                    <h2>Alteração de cadastro</h2>

                    <label for="nomeproduto">Nome do produto</label>
                    <input type="text" value="<?php echo $info_produto["nomeproduto"]?>" name="nomeproduto">

                    
                    <label for="valorproduto">Valor do produto </label>
                    <input type="number" value="<?php echo $info_produto["valorproduto"]?>" name="valorproduto">


                    <label for="descproduto">Descrição do produto</label>
                    <input type="text" value="<?php echo $info_produto["descproduto"]?>" name="descproduto">

                    <input type="hidden" value="<?php echo $info_produto["idProduto"]?>" name="idProduto">



                    <input type="submit" value="Confirmar Alteração">


                </form>
                <h3><a href="exclusao.php?codigo=<?php echo $info_produto["idProduto"]?>">Excluir Produto</a></h3>
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>