<?php

    if (isset($_POST['data_conta']))
    {

        session_start();

        require_once 'connection.php';
        require_once '../functions.php';

        $conn = getConnection();
        $page = isset($_POST['page']) ? $_POST['page'] : '../register/water.php';

        if ($conn)
        {
            if (empty($_POST['padrao_imovel']) || empty($_POST['categoria_imovel']) || 
                empty($_POST['leit_anterior']) || empty($_POST['leit_atual']) || 
                empty($_POST['volume_m3']) || empty($_POST['data_conta']) || 
                empty($_POST['valor_consumo']) || empty($_POST['total']))
            {
                $_SESSION['error'] = 'Não pode deixar nenhum campo obrigatório em branco. Os campos obrigatórios tem um asterisco * na frente do nome.';
                header('Location: ' . $page);
                exit;
            }

            $padrao_imovel = $_POST['padrao_imovel'];
            $categoria_imovel = $_POST['categoria_imovel'];
            $leit_anterior = $_POST['leit_anterior'];
            $leit_atual = $_POST['leit_atual'];
            $volume_m3 = $_POST['volume_m3'];
            $media_semestral_m3 = $_POST['media_semestral_m3'];
            $data_conta = $_POST['data_conta'];
            $valor_consumo = (float) $_POST['valor_consumo'];
            $multa_porc = $_POST['multa_porc'];
            $val_multa = (float) $_POST['val_multa'];
            $tarifa_juros = (float) $_POST['tarifa_juros'];
            $val_juros = (float) $_POST['val_juros'];
            $religacao = (float) $_POST['religacao'];
            $emissao_2via = (float) $_POST['emissao_2via'];
            $total = (float) $_POST['total'];
            $situacao = $_POST['situacao'];
            $observacao = addslashes(isset($_POST['observacao']) ? trim(preg_replace('/ +/', ' ', $_POST['observacao'])) : null);
            
            if ($_SESSION['opc'] == 1) //Registrar conta de água
            {
                checarData('agua', $data_conta, $page);

                $action = 'register';

                $sql = ('INSERT INTO agua (padrao_imovel, categoria_imovel, leit_anterior, leit_atual, volume_m3, media_semestral_m3, data_conta, valor_consumo, multa_porc, val_multa, tarifa_juros, val_juros, religacao, emissao_2via, total, situacao, observacao)
                VALUES
                (:padrao_imovel, :categoria_imovel, :leit_anterior, :leit_atual, :volume_m3, :media_semestral_m3, :data_conta, :valor_consumo, :multa_porc, :val_multa, :tarifa_juros, :val_juros, :religacao, :emissao_2via, :total, :situacao, :observacao)');
            }
            elseif ($_SESSION['opc'] == 2) //Atualizar conta de água
            {
                $action = 'update';
                $data_conta_old = $_POST['data_conta_old'];

                if ($data_conta != $data_conta_old)
                {
                    checarData('agua', $data_conta, $page);
                }

                $sql = ("UPDATE agua SET padrao_imovel = :padrao_imovel, categoria_imovel = :categoria_imovel, leit_anterior = :leit_anterior, leit_atual = :leit_atual, volume_m3 = :volume_m3, media_semestral_m3 = :media_semestral_m3, data_conta = :data_conta, valor_consumo = :valor_consumo, multa_porc = :multa_porc, val_multa = :val_multa, tarifa_juros = :tarifa_juros, val_juros = :val_juros, religacao = :religacao, emissao_2via = :emissao_2via, total = :total, situacao = :situacao, observacao = :observacao WHERE data_conta = '{$data_conta_old}'");
            }

            checarLeitura($leit_atual, $leit_anterior, $page);

            checarValor($volume_m3, $leit_atual, $leit_anterior, 'Volume (m<sub>3</sub>)', $page);

            if ($valor_consumo + $val_multa + $val_juros + $religacao + $emissao_2via != $total)
            {
                $_SESSION['error'] = 'O valor informado no campo Total não é igual a soma dos valores informados nos campos Valor consumo, Valor da multa, Valor do juros, Religação e  Emissão 2° via.';
                header('Location: ' . $page);
                exit;
            }

            $stmt = $conn -> prepare($sql);

            $stmt -> bindParam(':padrao_imovel', $padrao_imovel);
            $stmt -> bindParam(':categoria_imovel', $categoria_imovel);
            $stmt -> bindParam(':leit_anterior', $leit_anterior, PDO::PARAM_INT);
            $stmt -> bindParam(':leit_atual', $leit_atual, PDO::PARAM_INT);
            $stmt -> bindParam(':volume_m3', $volume_m3, PDO::PARAM_INT);
            $stmt -> bindParam(':media_semestral_m3', $media_semestral_m3, PDO::PARAM_INT);
            $stmt -> bindParam(':data_conta', $data_conta);
            $stmt -> bindParam(':valor_consumo', $valor_consumo);
            $stmt -> bindParam(':multa_porc', $multa_porc, PDO::PARAM_INT);
            $stmt -> bindParam(':val_multa', $val_multa);
            $stmt -> bindParam(':tarifa_juros', $tarifa_juros);
            $stmt -> bindParam(':val_juros', $val_juros);
            $stmt -> bindParam(':religacao', $religacao);
            $stmt -> bindParam(':emissao_2via', $emissao_2via);
            $stmt -> bindParam(':total', $total);
            $stmt -> bindParam(':situacao', $situacao);
            $stmt -> bindParam(':observacao', $observacao);

            execQuery($stmt, $action);

            if ($_SESSION['opc'] == 1)
            {
                header('Location: ' . $page);
            }
            elseif ($_SESSION['opc'] == 2)
            {
                header("Location: ../register/water.php?data_conta={$data_conta}&opc=2");
            }

        }
        else
        {
            header('Location: ' . $page);
            exit;
        }

    }
    else
    {
        header('Location: ../index.php');
        exit;
    }