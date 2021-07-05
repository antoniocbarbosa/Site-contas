<?php

    if (isset($_POST['data_conta']))
    {

        session_start();

        require_once 'connection.php';
        require_once '../functions.php';

        $conn = getConnection($_SESSION['pagina']);

        if ($conn)
        {

            //Registrar conta de energia
            if ($_SESSION['opc'] == 1)
            {

                if (empty($_POST['data_conta']) || empty($_POST['ilum_public']) || 
                    empty($_POST['tarifa_kWh']) || empty($_POST['valor_consumo']) || 
                    empty($_POST['total']) || empty($_POST['leit_anterior']) || 
                    empty($_POST['leit_atual']) || empty($_POST['consumo_kWh']))
                {
                    $_SESSION['erro'] = 'Não pode deixar nenhum campo obrigatório em branco. Os campos obrigatórios tem um asterisco * na frente do nome.';
                    header('Location: ' . $_SESSION['pagina']);
                    exit;
                }

                $data_conta = $_POST['data_conta'];
                $tarifa_band_amar = (float) $_POST['tarifa_band_amar'];
                $valor_band_amar = (float) $_POST['valor_band_amar'];
                $tarifa_band_verm = (float) $_POST['tarifa_band_verm'];
                $valor_band_verm = (float) $_POST['valor_band_verm'];
                $ilum_public = (float) $_POST['ilum_public'];
                $tarifa_kWh = (float) $_POST['tarifa_kWh'];
                $valor_consumo = (float) $_POST['valor_consumo'];
                $juros_mora = (float) $_POST['juros_mora'];
                $valor_multa = (float) $_POST['valor_multa'];
                $dic = (float) $_POST['dic'];
                $fic = (float) $_POST['fic'];
                $dmic = (float) $_POST['dmic'];
                $dicri = (float) $_POST['dicri'];
                $religacao = (float) $_POST['religacao'];
                $emissao_2via = (float) $_POST['emissao_2via'];
                $total = (float) $_POST['total'];
                $leit_anterior = $_POST['leit_anterior'];
                $leit_atual = $_POST['leit_atual'];
                $consumo_kWh = $_POST['consumo_kWh'];
                $situacao = $_POST['situacao'];
                $observacao = addslashes(isset($_POST['observacao']) ? trim(preg_replace('/ +/', ' ', $_POST['observacao'])) : null);

                checarData('energia', $data_conta);

                checarLeitura($leit_atual, $leit_anterior, $_SESSION['pagina']);

                checarValor($consumo_kWh, $leit_atual, $leit_anterior, 'Consumo kWh', $_SESSION['pagina']);

                if ($valor_band_amar + $valor_band_verm + $ilum_public + $valor_consumo + $juros_mora + $valor_multa + ($dic) + ($fic) + ($dmic) + ($dicri) + $religacao + $emissao_2via != $total)
                {
                    $_SESSION['erro'] = 'O valor informado no campo Total não é igual a soma dos valores informados nos campos Valor bandeira amarela, Valor bandeira vermelha, Iluminação pública, Valor consumo, Juros Moratórios, Valor multa, Dic, Fic, Dmic, Dicri, Religação e Emissão 2° via.';
                    header('Location: ' . $_SESSION['pagina']);
                    exit;
                }

                $sql = ('INSERT INTO energia (data_conta, tarifa_band_amar, valor_band_amar, tarifa_band_verm, valor_band_verm, ilum_public, tarifa_kWh, valor_consumo, juros_mora, valor_multa, dic, fic, dmic, dicri, religacao, emissao_2via, total, leit_anterior, leit_atual, consumo_kWh, situacao, observacao)
                VALUES
                (:data_conta, :tarifa_band_amar, :valor_band_amar, :tarifa_band_verm, :valor_band_verm, :ilum_public, :tarifa_kWh, :valor_consumo, :juros_mora, :valor_multa, :dic, :fic, :dmic, :dicri, :religacao, :emissao_2via, :total, :leit_anterior, :leit_atual, :consumo_kWh, :situacao, :observacao)');

                $stmt = $conn -> prepare($sql);

                $stmt -> bindParam(':data_conta', $data_conta);
                $stmt -> bindParam(':tarifa_band_amar', $tarifa_band_amar);
                $stmt -> bindParam(':valor_band_amar', $valor_band_amar);
                $stmt -> bindParam(':tarifa_band_verm', $tarifa_band_verm);
                $stmt -> bindParam(':valor_band_verm', $valor_band_verm);
                $stmt -> bindParam(':ilum_public', $ilum_public);
                $stmt -> bindParam(':tarifa_kWh', $tarifa_kWh);
                $stmt -> bindParam(':valor_consumo', $valor_consumo);
                $stmt -> bindParam(':juros_mora', $juros_mora);
                $stmt -> bindParam(':valor_multa', $valor_multa);
                $stmt -> bindParam(':dic', $dic);
                $stmt -> bindParam(':fic', $fic);
                $stmt -> bindParam(':dmic', $dmic);
                $stmt -> bindParam(':dicri', $dicri);
                $stmt -> bindParam(':religacao', $religacao);
                $stmt -> bindParam(':emissao_2via', $emissao_2via);
                $stmt -> bindParam(':total', $total);
                $stmt -> bindParam(':leit_anterior', $leit_anterior, PDO::PARAM_INT);
                $stmt -> bindParam(':leit_atual', $leit_atual, PDO::PARAM_INT);
                $stmt -> bindParam(':consumo_kWh', $consumo_kWh, PDO::PARAM_INT);
                $stmt -> bindParam(':situacao', $situacao);
                $stmt -> bindParam(':observacao', $observacao);

                execQuery($stmt, 'cadastro');

                header('Location: ' . $_SESSION['pagina']);
                exit;

            }
            elseif ($_SESSION['opc'] == 2)
            {

            }

        }
        else
        {
            header('Location: ' . $_SESSION['pagina']);
            exit;
        }

    }
    else
    {
        header('Location: ../index.php');
        exit;
    }