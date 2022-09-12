<?php require_once("conexao/conexao.php"); ?>

<?php
    
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
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
    

    if (isset($_POST["valorlance"])){

        if (($_POST["valorlance"]) <= ($_POST["valorproduto"])){
            header("location:listagem.php?error=1");
            die("erro");
        }

        $valor          = $_POST["valorlance"];
        $idproduto      = $_POST["idProduto"];
        $clienteid      = $_POST["idCliente"];
        $nomecliente    = $_POST["nomecliente"];
        $nomeDoProduto  = $_POST["nomeproduto"];

        $inserir = "INSERT INTO lance (valorLance, idProduto, idCliente, nomecliente, nomeproduto) VALUES ('$valor','$idproduto','$clienteid','$nomecliente','$nomeDoProduto')";

        $operacao_inserir = mysqli_query($conecta,$inserir);

        if (!$operacao_inserir){
            die("falha na inserção");
        }else{ 
            $inserir = "UPDATE produto set valorproduto = '$valor' where idProduto = '$idproduto' ";
            $operacao_inserir = mysqli_query($conecta,$inserir);
            unset($_POST);
            header("location:listagem.php");
        }
    }
    //selecao
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de leilao</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/crud.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?> 
        
        <main>
            
            <div id="janela_formulario">
                <h1>Lance designado para: <?php  echo $info_produto["nomeproduto"] ?></h1>
                <br><h3>Valor: <?php echo real_format($info_produto["valorproduto"]) ?></h3>
                <form action="lance.php" method="post">
                    <input type="number" name="valorlance" placeholder="valorlance">
                    <input type="hidden" value="<?php echo $info_produto["idProduto"]?>" name = "idProduto">
                    <input type="hidden" value="<?php echo $idCliente?>" name = "idCliente">
                    <input type="hidden" value="<?php echo $nome_cliente?>" name = "nomecliente">
                    <input type="hidden" value="<?php echo $info_produto["valorproduto"]?>" name = "valorproduto">
                    <input type="hidden" value="<?php echo $info_produto["nomeproduto"]?>" name = "nomeproduto">
                    <input type="submit" value="inserir">
                </form>
                
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>