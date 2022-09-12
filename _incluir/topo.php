<header>
    <div id="header_central">
        <?php
            if (isset($_SESSION["user_portal"])){
                $user = $_SESSION["user_portal"];
                $saudacao = "SELECT nomecliente, nivel, idCliente, idade FROM cliente WHERE idCliente = {$user}";
                $saudacao_login = mysqli_query($conecta,$saudacao);
                if (!$saudacao_login){
                    die("falha no banco de dados");
                }
                $saudacao_login = mysqli_fetch_assoc($saudacao_login);
                $nome_cliente= $saudacao_login["nomecliente"];
                $idCliente = $saudacao_login["idCliente"];
                $idade_cliente = $saudacao_login["idade"];
            if ($saudacao_login["nivel"]=="admin"){
                ?><a href="listagem_cadastro.php" id="cadastros"> Cadastros de clientes     </a><br>
                <a href="cadastro_leilao.php" >Cadastrar novo Leilão</a><?php
            }



        ?>
        <div id = "header_saudacao">
            <h5>Seja bem vindo, <?php echo $nome_cliente?>  <a href="logout.php">|sair|</a></h5>
            
        </div>
        <?php }?>

        <a href="listagem.php" id ="pudim"><h3>Leilão.net</h3></a><br>
        
    </div>
</header>