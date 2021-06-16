<?php require_once '../header.php' ?>
    <title>Registrar água</title>
</head>
<body>
    
    <div class="register">

        <form action="" method="POST">
            <label for="leit_anterior">Leitura anterior*: </label>
            <input type="number" name="leit_anterior" id="leit_anterior" min="1" max="99999" placeholder="00000"><br>
            <label for="leit_atual">Leitura atual*: </label>
            <input type="number" name="leit_atual" id="leit_atual" min="1" max="99999" placeholder="00000"><br>
            <label for="volume_m3">Volume (m<sub>3</sub>)*: </label>
            <input type="number" name="volume_m3" id="volume_m3" min="1" max="999" placeholder="000"><br>
            <label for="media_semestral_m3">Média semestral (m<sub>3</sub>): </label>
            <input type="number" name="media_semestral_m3" id="media_semestral_m3" min="1" max="100" placeholder="000"><br>
            <label for="data_conta">Data conta*: </label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01"><br>
            <label for="valor_consumo">Valor consumo*: </label>
            <input type="number" name="valor_consumo" id="valor_consumo" min="0" max="999.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="multa_porc">Multa (%)*: </label>
            <input type="number" name="multa_porc" id="multa_porc" min="1" max="30" placeholder="0"><br>
            <label for="val_multa">Valor da multa:</label>
            <input type="number" name="val_multa" id="val_multa" min="0" max="100" step="0.01" placeholder="R$ 00.00"><br>
            <label for="tarifa_juros">Tarifa do juros:</label>
            <input type="number" name="tarifa_juros" id="tarifa_juros" min="0.001" max="0.999" step="0.001" placeholder="0.000"><br>
            <label for="val_juros">Valor do juros:</label>
            <input type="number" name="val_juros" id="val_juros" min="0" max="100" step="0.01" placeholder="R$ 00.00"><br>
            <label for="religacao">Religação:</label>
            <input type="number" name="religacao" id="religacao" min="0" max="100" step="0.01" placeholder="R$ 00.00"><br>
            <label for="emissao_2via">Emissão 2° via:</label>
            <input type="number" name="emissao_2via" id="emissao_2via" min="0" max="100" step="0.01" placeholder="R$ 00.00"><br>
            <label for="total">Total*:</label>
            <input type="number" name="total" id="total" min="0.01" max="999.99" step="0.01" placeholder="R$ 000.00"><br>
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P">
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP">
                <label for="np">Conta não paga</label>
            </fieldset>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;"></textarea><br>
            <input type="submit" value="Registrar" id="button">
            <a href="register.php"><input type="button" value="Voltar" id="button"></a>
        </form>

    </div>

</body>
</html>