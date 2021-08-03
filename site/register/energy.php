<?php 

    session_start();
    
    
    if (isset($_GET['data_conta']) && !empty($_GET['data_conta']) && isset($_GET['opc']) 
        && $_GET['opc'] == 2)
    {
        require_once '../functions.php';
    
        $data_conta = isset($_GET['data_conta']) ? $_GET['data_conta'] : null;
        $data_conta_old = $data_conta;
        $tabela = 'energia';
        $res = buscarDadosConta($tabela, 'data_conta', ':data_conta', $data_conta, 'energy');

        require_once '../header.php';
        echo '<title>Atualizar energia</title>';
    }
    else
    {
        require_once '../header.php';
        echo '<title>Registar energia</title>';
    }

?>
    <script type="text/javascript" src="../_js/previousPage.js";></script>
</head>
<body>

    <div class="register">

        <form action="../_bd/edit_energy.php" method="POST">
            <label for="data_conta">Data conta: </label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01" value="<?php if (isset($res)) {echo $res['data_conta'];} ?>" required><br>
            <input type="date" name="data_conta_old" id="data_conta_old" min="2000-01-01" value="<?php if (isset($res)) {echo $data_conta_old;} ?>" hidden>
            <label for="tarifa_band_amar">Tarifa bandeira amarela: </label>
            <input type="number" name="tarifa_band_amar" id="tarifa_band_amar" min="0.00000" max="0.99999" step="0.00001" placeholder="0.00000" value="<?php if (isset($res)) {echo $res['tarifa_band_amar'];} ?>"><br>
            <label for="valor_band_amar">Valor bandeira amarela: </label>
            <input type="number" name="valor_band_amar" id="valor_band_amar" min="0" max="999.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['valor_band_amar'];} ?>"><br>
            <label for="tarifa_band_verm">Tarifa bandeira vermelha: </label>
            <input type="number" name="tarifa_band_verm" id="tarifa_band_verm" min="0.00000" max="0.99999" step="0.00001" placeholder="0.00000" value="<?php if (isset($res)) {echo $res['tarifa_band_verm'];} ?>"><br>
            <label for="valor_band_verm">Valor bandeira vermelha: </label>
            <input type="number" name="valor_band_verm" id="valor_band_verm" min="0" max="999.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['valor_band_verm'];} ?>"><br>
            <label for="ilum_public">Iluminação pública: </label>
            <input type="number" name="ilum_public" id="ilum_public" min="0.01" max="99.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['ilum_public'];} ?>" required><br>
            <label for="tarifa_kWh">Tarifa kWh: </label>
            <input type="number" name="tarifa_kWh" id="tarifa_kWh" min="0.00001" max="0.99999" step="0.00001" placeholder="0.00000" value="<?php if (isset($res)) {echo $res['tarifa_kWh'];} ?>" required><br>
            <label for="valor_consumo">Valor consumo: </label>
            <input type="number" name="valor_consumo" id="valor_consumo" min="1" max="999.99" step="0.01" placeholder="R$ 000.00" value="<?php if (isset($res)) {echo $res['valor_consumo'];} ?>" required><br>
            <label for="juros_mora">Juros Moratórios: </label>
            <input type="number" name="juros_mora" id="juros_mora" min="0" max="99.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['juros_mora'];} ?>"><br>
            <label for="valor_multa">Valor multa: </label>
            <input type="number" name="valor_multa" id="valor_multa" min="0" max="99.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['valor_multa'];} ?>"><br>
            <label for="dic">Dic: </label>
            <input type="number" name="dic" id="dic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00" value="<?php if (isset($res)) {echo $res['dic'];} ?>"><br>
            <label for="fic">Fic: </label>
            <input type="number" name="fic" id="fic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00" value="<?php if (isset($res)) {echo $res['fic'];} ?>"><br>
            <label for="dmic">Dmic: </label>
            <input type="number" name="dmic" id="dmic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00" value="<?php if (isset($res)) {echo $res['dmic'];} ?>"><br>
            <label for="dicri">Dicri: </label>
            <input type="number" name="dicri" id="dicri" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00" value="<?php if (isset($res)) {echo $res['dicri'];} ?>"><br>
            <label for="religacao">Religação: </label>
            <input type="number" name="religacao" id="religacao" min="0" max="99.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['religacao'];} ?>"><br>
            <label for="emissao_2via">Emissão 2° via: </label>
            <input type="number" name="emissao_2via" id="emissao_2via" min="0" max="99.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['emissao_2via'];} ?>"><br>
            <label for="total">Total: </label>
            <input type="number" name="total" id="total" min="1" max="999.99" step="0.01" placeholder="R$ 00.00" value="<?php if (isset($res)) {echo $res['total'];} ?>" required><br>
            <label for="leit_anterior">Leitura anterior: </label>
            <input type="number" name="leit_anterior" id="leit_anterior" min="1" max="99998"  placeholder="00000" value="<?php if (isset($res)) {echo $res['leit_anterior'];} ?>" required><br>
            <label for="leit_atual">Leitura atual: </label>
            <input type="number" name="leit_atual" id="leit_atual" min="1" max="99999"  placeholder="00000" value="<?php if (isset($res)) {echo $res['leit_atual'];} ?>" required><br>
            <label for="consumo_kWh">Consumo kWh: </label>
            <input type="number" name="consumo_kWh" id="consumo_kWh" min="1" max="255"  placeholder="000" value="<?php if (isset($res)) {echo $res['consumo_kWh'];} ?>" required><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P" <?php isset($res) && !empty($res) && $res['situacao'] == 'P' ? print 'checked' : ''?>>
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" <?php isset($res) && !empty($res) && $res['situacao'] != 'P' ? print 'checked' : (!isset($res) ? print 'checked' : '')?>>
                <label for="np">Conta não paga</label>
            </fieldset>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;"><?php if(isset($res) && !empty($res)) {echo $res['observacao'];} ?></textarea><br>
            <input type="text" name="page" id="page" hidden>
            <input type="submit" onclick="setPage()" id="button" value="<?php if (isset($_GET['data_conta']) &&  !empty($_GET['data_conta']) && isset($_GET['opc']) && $_GET['opc'] == 2) {echo 'Atualizar';} else {echo 'Registrar';} ?>">
            <a href="<?php if(isset($res)) {echo '../search.php';} else {echo 'register.php';} ?>"><input type="button" id="button" value="Voltar"></a>

            <?php
                if (isset($_GET['data_conta']) && !empty($_GET['data_conta']) && isset($_GET['opc']) && $_GET['opc'] == 2)
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