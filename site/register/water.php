<?php session_start(); require_once "../header.php" ?>
    <title>Registrar água</title>
</head>
<body>
    
    <div class="register">

        <form action="../_bd/edit_water.php" method="POST">
            <fieldset><legend>Padrão do imóvel*:</legend>
                <input type="radio" name="padrao_imovel" id="baixo" value="Baixo">
                <label for="baixo">Baixo</label>
                <input type="radio" name="padrao_imovel" id="medio" value="Médio">
                <label for="medio">Médio</label>
                <input type="radio" name="padrao_imovel" id="alto" value="Alto">
                <label for="alto">Alto</label>
            </fieldset><br>
            <fieldset><legend>Economias*:</legend>
                <select name="categoria_imovel" id="categoria_imovel">
                    <option value="Residencial 001">Residencial 001</option>
                    <option value="Residencial 002">Residencial 002</option>
                    <option value="Residencial 003">Residencial 003</option>
                    <option value="Comercial 001">Comercial 001</option>
                    <option value="Comercial 002">Comercial 002</option>
                    <option value="Industrial 001">Industrial 001</option>
                    <option value="Pública 001">Pública 001</option>
                </select>
            </fieldset><br>
            <label for="leit_anterior">Leitura anterior*: </label>
            <input type="number" name="leit_anterior" id="leit_anterior" min="1" max="99999" placeholder="00000"><br>
            <label for="leit_atual">Leitura atual*: </label>
            <input type="number" name="leit_atual" id="leit_atual" min="1" max="99999" placeholder="00000"><br>
            <label for="media_semestral_m3">Média semestral (m<sub>3</sub>): </label>
            <input type="number" name="media_semestral_m3" id="media_semestral_m3" min="1" max="100" placeholder="000"><br>
            <label for="data_conta">Data conta*: </label>
            <input type="date" name="data_conta" id="data_conta" min="2000-01-01"><br>
            <label for="valor_consumo">Valor consumo*: </label>
            <input type="number" name="valor_consumo" id="valor_consumo" min="1" max="999.99" step="0.01" placeholder="R$ 00.00"><br>
            <label for="multa_porc">Multa (%): </label>
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
            <fieldset><legend>Situação:</legend>
                <input type="radio" name="situacao" id="p" value="P">
                <label for="p">Conta paga</label><br>
                <input type="radio" name="situacao" id="np" value="NP" checked> 
                <label for="np">Conta não paga</label>
            </fieldset><br>
            <label for="observacao">Observação:</label><br>
            <textarea name="observacao" id="observacao" cols="60" rows="6" maxlength="200" placeholder="Alguma característica da conta." style="resize: none;"></textarea><br>
            <input type="submit" value="Registrar" id="button">
            <a href="register.php"><input type="button" value="Voltar" id="button"></a>

            <?php
                $_SESSION["opc"] = 1;
                $_SESSION["pagina"] = "../register/water.php";
            ?>
        </form>

        <?php
            require_once "../functions.php";
            checarCadastro();
        ?>

    </div>

</body>
</html>