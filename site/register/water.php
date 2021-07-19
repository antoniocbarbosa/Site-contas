<?php 

    session_start();
    
    if (isset($_GET['data_conta']) && !empty($_GET['data_conta']) && isset($_GET['opc']) 
        && $_GET['opc'] == 2)
    {
        require_once '../functions.php';
    
        $data_conta = isset($_GET['data_conta']) ? $_GET['data_conta'] : null;
        $data_conta_old = $data_conta;
        $tabela = 'agua';
        $res = buscarDadosConta($tabela, 'data_conta', ':data_conta', $data_conta, 'water');

        require_once '../header.php';
        echo '<title>Atualizar água</title>';
    }
    else
    {
        require_once '../header.php';
        echo '<title>Registar água</title>';
    }

?>
    <script type="text/javascript" src="../_js/previousPage.js";></script>
</head>
<body>
    
    <div class="register">

        <form action="../_bd/edit_water.php" method="POST">
            <fieldset><legend>Padrão do imóvel*:</legend>
                <input type="radio" name="padrao_imovel" id="baixo" value="Baixo" <?php if(isset($res) && !empty($res) && $res['padrao_imovel'] == 'Baixo') {echo 'checked';} ?>>
                <label for="baixo">Baixo</label>
                <input type="radio" name="padrao_imovel" id="medio" value="Médio" <?php if(isset($res) && !empty($res) && $res['padrao_imovel'] == 'Médio') {echo 'checked';} ?>>
                <label for="medio">Médio</label>
                <input type="radio" name="padrao_imovel" id="alto" value="Alto" <?php if(isset($res) && !empty($res) && $res['padrao_imovel'] == 'Alto') {echo 'checked';} ?>>
                <label for="alto">Alto</label>
            </fieldset><br>
            <fieldset><legend>Economias*:</legend>
                <select name="categoria_imovel" id="categoria_imovel">
                    <option value="Residencial 001" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Residencial 001') {echo 'selected';} ?>>Residencial 001</option>
                    <option value="Residencial 002" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Residencial 002') {echo 'selected';} ?>>Residencial 002</option>
                    <option value="Residencial 003" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Residencial 003') {echo 'selected';} ?>>Residencial 003</option>
                    <option value="Comercial 001" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Comercial 001') {echo 'selected';} ?>>Comercial 001</option>
                    <option value="Comercial 002" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Comercial 002') {echo 'selected';} ?>>Comercial 002</option>
                    <option value="Industrial 001" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Industrial 001') {echo 'selected';} ?>>Industrial 001</option>
                    <option value="Pública 001" <?php if(isset($res) && !empty($res) && $res['categoria_imovel'] == 'Pública 001') {echo 'selected';} ?>>Pública 001</option>
                </select>
            </fieldset><br>
            <label for="leit_anterior">Leitura anterior*: </label>
            <input type="number" name="leit_anterior" id="leit_anterior" min="1" max="99998" placeholder="00000" value="<?php if(isset($res)) {echo $res['leit_anterior'];} ?>"><br>
            <label for="leit_atual">Leitura atual*: </label>
            <input type="number" name="leit_atual" id="leit_atual" min="1" max="99999" placeholder="00000" value="<?php if(isset($res)) {echo $res['leit_atual'];} ?>"><br>
            <label for="volume_m3">Volume (m<sub>3</sub>)*: </label>
            <input type="number" name="volume_m3" id="volume_m3" min="1" max="255" placeholder="000" value="<?php if(isset($res)) {echo $res['volume_m3'];} ?>"><br>
            <label for="media_semestral_m3">Média semestral (m<sub>3</sub>): </label>
            <input type="number" name="media_semestral_m3" id="media_semestral_m3" min="0" max="100" placeholder="000" value="<?php if(isset($res)) {echo $res['media_semestral_m3'];} ?>"><br>
            <label for="data_conta">Data conta*: </label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01" value="<?php if(isset($res)) {echo $res['data_conta'];} ?>"><br>
            <input type="date" name="data_conta_old" id="data_conta_old" min="2000-01-01" value="<?php if (isset($res)) {echo $data_conta_old;} ?>" hidden>
            <label for="valor_consumo">Valor consumo*: </label>
            <input type="number" name="valor_consumo" id="valor_consumo" min="1" max="999.99" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['valor_consumo'];} ?>"><br>
            <label for="multa_porc">Multa (%): </label>
            <input type="number" name="multa_porc" id="multa_porc" min="0" max="30" placeholder="0" value="<?php if(isset($res)) {echo $res['multa_porc'];} ?>"><br>
            <label for="val_multa">Valor da multa:</label>
            <input type="number" name="val_multa" id="val_multa" min="0" max="100" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['val_multa'];} ?>"><br>
            <label for="tarifa_juros">Tarifa do juros:</label>
            <input type="number" name="tarifa_juros" id="tarifa_juros" min="0.000" max="0.999" step="0.001" placeholder="0.000" value="<?php if(isset($res)) {echo $res['tarifa_juros'];} ?>"><br>
            <label for="val_juros">Valor do juros:</label>
            <input type="number" name="val_juros" id="val_juros" min="0" max="100" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['val_juros'];} ?>"><br>
            <label for="religacao">Religação:</label>
            <input type="number" name="religacao" id="religacao" min="0" max="100" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['religacao'];} ?>"><br>
            <label for="emissao_2via">Emissão 2° via:</label>
            <input type="number" name="emissao_2via" id="emissao_2via" min="0" max="100" step="0.01" placeholder="R$ 00.00" value="<?php if(isset($res)) {echo $res['emissao_2via'];} ?>"><br>
            <label for="total">Total*:</label>
            <input type="number" name="total" id="total" min="0.01" max="999.99" step="0.01" placeholder="R$ 000.00" value="<?php if(isset($res)) {echo $res['total'];} ?>"><br><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P" <?php isset($res) && !empty($res) && $res['situacao'] == 'P' ? print 'checked' : ''?>>
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" <?php isset($res) && !empty($res) && $res['situacao'] != 'P' ? print 'checked' : (!isset($res) ? print 'checked' : '')?>> 
                <label for="np">Conta não paga</label>
            </fieldset><br>
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