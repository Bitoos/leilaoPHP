<?php 
    require_once("conexao/conexao.php");
    include_once("_incluir/funcoes.php"); 

    
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }
    

    if (isset($_POST["enviar"])){
       
        $resposta = uploadArquivo($_FILES["upload_file"],"images/product_images");
        $nome_imagem = "images/product_images/".$resposta[1];
        
        if (isset($_POST["nomeproduto"])){
            $nome     = $_POST["nomeproduto"];
            $valor    = $_POST["valorproduto"];
            $desc  = $_POST["descproduto"];
           
        

            $inserir = "INSERT INTO produto (nomeproduto, valorproduto, descproduto,imagem ) VALUES ('$nome','$valor','$desc', '$nome_imagem' )";

            $operacao_inserir = mysqli_query($conecta,$inserir);

            if (!$operacao_inserir){
                die("falha na inserção");
            }else{
                header("location:listagem.php");
            }

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
                <form action="cadastro_leilao.php" method="post" enctype="multipart/form-data" >
                    <input type="text" name="nomeproduto" placeholder="Nome do produto" required>
                    <input type="number" name="valorproduto" placeholder="valor" required>
                    <input type="text" name="descproduto" placeholder="descrição do produto" required>
                    
                    <input type="hidden" name="MAX_FILE_SIZE" value="4500000">
                    <input type="file" name="upload_file" accept="image/png, image/jpeg, image/gif" required><br>

                    <input type="submit" name="enviar">

                </form>
                <?php
                    if (isset($resposta)){
                        echo $resposta[0];
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