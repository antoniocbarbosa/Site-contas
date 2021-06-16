<?php require_once '../header.php' ?>
    <title>Registrar energia</title>
</head>
<body>
    
    <div class="register">

        <form action="" method="POST">
            <label for="data_conta">Data conta*: </label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01"><br>
            <label for="tarifa_band_amar">Tarifa bandeira amarela: </label>
            <input type="number" name="tarifa_band_amar" id="tarifa_band_amar" min="0.00001" max="0.99999" step="0.00001" placeholder="0.00000"><br>
            <label for="valor_band_amar">Valor bandeira amarela: </label>
            <input type="number" name="valor_band_amar" id="valor_band_amar" min="0" max="999.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="tarifa_band_verm">Tarifa bandeira vermelha: </label>
            <input type="number" name="tarifa_band_verm" id="tarifa_band_verm" min="0.00001" max="0.99999" step="0.00001" placeholder="0.00000"><br>
            <label for="valor_band_verm">Valor bandeira vermelha: </label>
            <input type="number" name="valor_band_verm" id="valor_band_verm" min="0" max="999.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="ilum_public">Iluminação pública*: </label>
            <input type="number" name="ilum_public" id="ilum_public" min="0.01" max="99.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="tarifa_kWh">Tarifa kWh*: </label>
            <input type="number" name="tarifa_kWh" id="tarifa_kWh" min="0.00001" max="0.99999" step="0.00001" placeholder="0.00000"><br>
            <label for="valor_consumo">Valor consumo*: </label>
            <input type="number" name="valor_consumo" id="valor_consumo" min="0.01" max="999.99" step="0.01" placeholder="R$ 000.00"><br>
            <label for="juros_mora">Juros Moratórios: </label>
            <input type="number" name="juros_mora" id="juros_mora" min="0" max="99.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="valor_multa">Valor multa: </label>
            <input type="number" name="valor_multa" id="valor_multa" min="0" max="99.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="dic">Dic: </label>
            <input type="number" name="dic" id="dic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00"><br>
            <label for="fic">Fic: </label>
            <input type="number" name="fic" id="fic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00"><br>
            <label for="dmic">Dmic: </label>
            <input type="number" name="dmic" id="dmic" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00"><br>
            <label for="dicri">Dicri: </label>
            <input type="number" name="dicri" id="dicri" min="-30.00" max="0" step="0.01" placeholder="R$ -00.00"><br>
            <label for="religacao">Religação: </label>
            <input type="number" name="religacao" id="religacao" min="0" max="99.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="emissao_2via">Emissão 2° via: </label>
            <input type="number" name="emissao_2via" id="emissao_2via" min="0" max="99.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="total">Total*: </label>
            <input type="number" name="total" id="total" min="0" max="999.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="leit_anterior">Leitura anterior*: </label>
            <input type="number" name="leit_anterior" id="leit_anterior" min="1" max="99999"  placeholder="00000"><br>
            <label for="leit_atual">Leitura atual*: </label>
            <input type="number" name="leit_atual" id="leit_atual" min="1" max="99999"  placeholder="00000"><br>
            <label for="consumo_kWh">Consumo kWh*: </label>
            <input type="number" name="consumo_kWh" id="consumo_kWh" min="1" max="999"  placeholder="000"><br>
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