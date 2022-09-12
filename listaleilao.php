<?php require_once("conexao/conexao.php"); ?>
<?php
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    }

    // tabela de lances
    
    
    
    $lance = "SELECT * FROM lance ";
    if ( isset($_GET["codigo"]) ) {
        $nomeproduto = $_GET["codigo"];
        $lance .= " WHERE nomeproduto LIKE '%{$nomeproduto}%' ORDER BY valorLance DESC";
    }else if ( isset($_GET["nomecliente"]) ) {
        $nomecliente = $_GET["nomecliente"];
        $lance .= " WHERE nomecliente LIKE '%{$nomecliente}%' ORDER BY valorLance DESC";
    }else{
        $lance .= " ORDER BY valorLance DESC";
    }
    $consulta_tr = mysqli_query($conecta, $lance);
    if(!$consulta_tr) {
        die("erro no banco");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Consulta de leilões</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css"            rel="stylesheet">
        <link href="_css/novo-alteracao.css"    rel="stylesheet">
        <link href="_css/produto_pesquisa.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        <?php include_once("_incluir/funcoes.php"); ?>  
        
        <main>  
            <div id="janela_pesquisa">
                <form action="listaleilao.php" method="get">
                    <input type="text" name="nomecliente" placeholder="Pesquisa por Cliente">
                    <input type="image"  src="_assets/botao_search.png">
                </form>
            </div>
            <div id="janela_transportadoras">
                <?php
                    while($linha = mysqli_fetch_assoc($consulta_tr)) {
                ?>
                <ul>
                    <li><?php echo $linha["valorLance"] ?></li>
                    <li><?php echo $linha["nomecliente"] ?></li>
                    <li><?php echo $linha["nomeproduto"]?></li>

                    
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