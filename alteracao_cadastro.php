<?php require_once("conexao/conexao.php"); 
    $cliente = "SELECT * FROM cliente ";

    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }



    if (isset($_POST["email"])){
        $nome       = $_POST["nomecliente"];
        $email   = $_POST["email"];
        $usuario     = $_POST["usuario"];
        $senha     = $_POST["senha"];
        $cID        = $_POST["idCliente"];
        $statuscliente = $_POST["statuscliente"];
        $idade = $_POST["idade"];

        $alterar    = "UPDATE cliente SET nomecliente = '{$nome}', email = '{$email}', usuario = '$usuario', senha = '{$senha}', statuscliente = '{$statuscliente}', idade ='{$idade}' WHERE idCliente = '{$cID}'";

        $operacao_alteracao = mysqli_query($conecta,$alterar);
        if (! $operacao_alteracao){
            die("erro no banco");
        }else{
            header("location:listagem_cadastro.php");
        }
    }


    
    if(isset($_GET["codigo"])){
        $id= $_GET["codigo"];
        $cliente .=" WHERE idCliente = {$id}";
    }else{
        header("location:listagem_cadastro.php");
    }

    $con_cliente = mysqli_query($conecta,$cliente);
    if(!$con_cliente){
        die("erro no banco de dados");

    }else{
        $info_cliente = mysqli_fetch_assoc($con_cliente);
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alteração de cadastro</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?> 
        
        <main>  
            <div id="janela_formulario">
                <form action="alteracao_cadastro.php" method="post">
                    <h2>Alteração de cadastro</h2>

                    <label for="nomecliente">Nome do cliente</label>
                    <input type="text" value="<?php echo $info_cliente["nomecliente"]?>" name="nomecliente">

                    <label for="email">Email</label>
                    <input type="text" value="<?php echo $info_cliente["email"]?>" name="email">
                    
                    <label for="usuario">Usuario</label>
                    <input type="text" value="<?php echo $info_cliente["usuario"]?>" name="usuario">

                    <label for="senha">Senha</label>
                    <input type="text" value="<?php echo $info_cliente["senha"]?>" name="senha">

                    <label for="idade">Idade</label>
                    <input type="text" value="<?php echo $info_cliente["idade"]?>" name="idade">

                    <?php if(!$info_cliente["nivel"]=="admin"){?>
                        <label for="statuscliente">Status da conta do cliente</label>
                        <select name="statuscliente" id="statuscliente">
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    <?php }?>
                    

                    <input type="hidden" value="<?php echo $info_cliente["idCliente"]?>" name="idCliente">

                    <input type="submit" value="Confirmar Alteração">


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