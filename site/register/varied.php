<?php 

    session_start();
    
    if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['opc']) 
        && $_GET['opc'] == 2)
    {
        require_once '../functions.php';
    
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $res = buscarDadosConta('variadas', 'id', ':id', $id, 'varied');

        require_once '../header.php';
        echo '<title>Atualizar variada</title>';
    }
    else
    {
        require_once '../header.php';
        echo '<title>Registar variada</title>';
    }

?>
    <script type="text/javascript" src="../_js/previousPage.js";></script>
</head>
<body>
    
    <div class="register">

        <form action="../_bd/edit_varied.php" method="POST">
            <label for="data_conta">Data da conta*:</label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01" value="<?php if(isset($res)) {echo $res['data_conta'];} ?>"><br>
            <input type="number" name="id" id="id" value="<?php if (isset($res)) {echo $id;} ?>" hidden>
            <label for="nome">Nome da conta*:</label>
            <input type="text" name="nome" id="nome" size="50" maxlength="50" placeholder="Nome do local ou da pessoa com quem foi feito a conta." value="<?php if(isset($res)) {echo $res['nome'];} ?>"><br>
            <label for="valor">Valor*:</label>
            <input type="number" name="valor" id="valor" min="1" max="20000" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['valor'];} ?>"><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P" <?php isset($res) && !empty($res) && $res['situacao'] == 'P' ? print 'checked' : ''?>>
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" <?php isset($res) && !empty($res) && $res['situacao'] != 'P' ? print 'checked' : (!isset($res) ? print 'checked' : '')?>> 
                <label for="np">Conta não paga</label>
            </fieldset>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;"><?php if(isset($res) && !empty($res)) {echo $res['observacao'];} ?></textarea><br>
            <input type="text" name="page" id="page" hidden>
            <input type="submit" onclick="setPage()" id="button" value="<?php if (isset($_GET['id']) &&  !empty($_GET['id']) && isset($_GET['opc']) && $_GET['opc'] == 2) {echo 'Atualizar';} else {echo 'Registrar';} ?>">
            <a href="<?php if(isset($res)) {echo '../search.php';} else {echo 'register.php';} ?>"><input type="button" id="button" value="Voltar"></a>

            <?php
                if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['opc']) && $_GET['opc'] == 2)
                {
                    $_SESSION['opc'] = 2;
                }
                else
                {
                    $_SESSION['opc'] = 1;
                }
            ?>
        </form>

        <?php
            require_once '../functions.php';
            checarAcao();
        ?>

    </div>

</body>
</html>