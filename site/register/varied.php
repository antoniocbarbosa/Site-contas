<?php 

    session_start();
    require_once '../functions.php';

    $opc = isset($_GET['opc']) ? $_GET['opc'] : null;

    if (isset($_GET['id']) && !empty($_GET['id']) && isset($opc) && ($opc == 2 || $opc == 3))
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $res = buscarDadosConta('variadas', 'id', ':id', $id, 'varied');
    }

    require_once '../header.php';

    isset($opc) && $opc == 2 ? print '<title>Atualizar variada</title>' :(isset($opc) && $opc == 3 ? print '<title>Visualizar variada</title>' : print '<title>Registar variada</title>');

    isset($opc) && $opc == 2 ? $_SESSION['opc'] = 2 : $_SESSION['opc'] = 1;

?>
</head>
<body>
    
    <div class="register">

        <form action="../_bd/edit_varied.php" method="POST">
            <label for="data_conta">Data da conta:</label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01" value="<?php if(isset($res)) {echo $res['data_conta'];} ?>" <?php isset($opc) && $opc == 3 ? print 'readonly' : ''; ?> required><br>
            <input type="number" name="id" id="id" value="<?php if (isset($res)) {echo $id;} ?>" hidden>
            <label for="nome">Nome da conta:</label>
            <input type="text" name="nome" id="nome" size="50" maxlength="50" placeholder="Nome do local ou da pessoa com quem foi feito a conta." value="<?php if(isset($res)) {echo $res['nome'];} ?>" <?php isset($opc) && $opc == 3 ? print 'readonly' : ''; ?> required><br>
            <label for="valor">Valor:</label>
            <input type="number" name="valor" id="valor" min="1" max="20000" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['valor'];} ?>"
            <?php isset($opc) && $opc == 3 ? print 'readonly' : ''; ?> required><br><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P" <?php isset($res) && !empty($res) && $res['situacao'] == 'P' ? print 'checked' : ''?>>
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" <?php isset($res) && !empty($res) && $res['situacao'] != 'P' ? print 'checked' : (!isset($res) ? print 'checked' : '')?>> 
                <label for="np">Conta não paga</label>
            </fieldset><br>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;" <?php isset($opc) && $opc == 3 ? print 'readonly' : ''; ?>><?php if(isset($res) && !empty($res)) {echo $res['observacao'];} ?></textarea><br>
            <input type="text" name="page" id="page" hidden>
            <input type="submit" onclick="setPage()" id="button" value="<?php if (isset($_GET['id']) &&  !empty($_GET['id']) && isset($opc) && $opc == 2) {echo 'Atualizar';} else {echo 'Registrar';} ?>" <?php isset($opc) && $opc == 3 ? print 'hidden' : ''; ?>>
            <a href="<?php if(isset($res)) {echo '../search.php';} else {echo 'register.php';} ?>"><input type="button" id="button" value="Voltar"></a>

        </form>

        <?php
            checarAcao();
        ?>

    </div>

</body>
</html>