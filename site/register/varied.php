<?php session_start(); require_once '../header.php' ?>
    <title>Registrar variadas</title>
</head>
<body>
    
    <div class="register">

        <form action="../_bd/edit_varied.php" method="POST">
            <label for="data_conta">Data da conta*:</label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01"><br>
            <label for="nome">Nome da conta*:</label>
            <input type="text" name="nome" id="nome" size="50" maxlength="50" placeholder="Nome do local ou da pessoa com quem foi feito a conta."><br>
            <label for="valor">Valor*:</label>
            <input type="number" name="valor" id="valor" min="1" max="20000" step="0.01" placeholder="R$ 00.00"><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P">
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" checked>
                <label for="np">Conta não paga</label>
            </fieldset>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;"></textarea><br>
            <input type="submit" value="Registrar" id="button">
            <a href="register.php"><input type="button" value="Voltar" id="button"></a>

            <?php
                $_SESSION['opc'] = 1;
                $_SESSION['pagina'] = '../register/varied.php';
            ?>
        </form>

        <?php
            require_once '../functions.php';
            checarCadastro();
        ?>

    </div>

</body>
</html>