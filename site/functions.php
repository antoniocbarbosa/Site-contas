<?php

    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
    {
        header('Location: index.php');
        exit;
    }
    else
    {
        
        require_once '_bd/connection.php';

        function checarData($tabela, $data_conta)
        {
            $conn = getConnection();
            $sql = ("SELECT * FROM {$tabela} WHERE data_conta = '{$data_conta}'");

            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $checarData = $stmt -> fetchAll();

            if (count($checarData) > 0)
            {
                $_SESSION['erro'] = 'Já existe uma conta cadastrada com a data informada.';
                header('Location: ' . $_SESSION['pagina']);
                exit;
            }
        }

        function checarLeitura($leit_atual, $leit_anteior, $pagina)
        {

            if ($leit_atual < $leit_anteior)
            {
                $_SESSION['erro'] = 'A leitura atual não pode ser menor que a leitura anterior.';
                header('Location: ' . $pagina);
                exit;
            }

            if ($leit_atual == $leit_anteior)
            {
                $_SESSION['erro'] = 'A leitura atual não pode ser igual a leitura anterior.';
                header('Location: ' . $pagina);
                exit;
            }

        }

        function checarCadastro()
        {

            if (isset($_SESSION['cadastro']))
            {
                echo '<p style="font-weight: bold;">Conta registrada com sucesso!</p>';
				unset($_SESSION['cadastro']);
            }
            elseif (isset($_SESSION['erro']))
            {
                echo "<p style='font-weight: bold;'>{$_SESSION['erro']}</p>";
				unset($_SESSION['erro']);
            }

        }

        function checarExclusao()
        {

            if (isset($_SESSION['excluir']))
            {
                echo '<p style="font-weight: bold;">Conta excluida com sucesso!</p>';
				unset($_SESSION['excluir']);
            }
            elseif (isset($_SESSION['erro']))
            {
                echo "<p style='font-weight: bold;'>{$_SESSION['erro']}</p>";
				unset($_SESSION['erro']);
            }

        }

        function execQuery($stmt, $session)
        {

            try
            {
                $stmt -> execute();
                $_SESSION[$session] = 1;
            }
            catch (PDOException $e)
            {
                $_SESSION['erro'] = $e -> getMessage();
                // $_SESSION['erro'] = msgErroSql($e -> getCode(), $e);
            }

        }

        function checarValor($valor, $leit_atual, $leit_anteior, $nome_campo, $pagina)
        {
            
            if ($valor != $leit_atual - $leit_anteior)
            {
                $_SESSION['erro'] = "O valor no campo {$nome_campo} não pode ser diferente da subtração entre os valores dos campos Leitura atual e Leitura anterior.";
                header('Location: ' . $pagina);
                exit;
            }

        }

        function buscarContas($conn, $tabela, $mes, $ano)
        {
            $tabela = ("SELECT * FROM {$tabela} WHERE YEAR(data_conta) = :ano AND MONTH(data_conta) = :mes");
            $stmt = $conn -> prepare($tabela);
            $stmt -> bindParam(':mes', $mes);
            $stmt -> bindParam(':ano', $ano);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

        function exibirContas($tabela, $tipo_conta, $pagina)
        {
            
            foreach ($tabela as $linha)
            {
                if ($tipo_conta == 'variadas')
                {
                    echo "<br>Data da conta: {$linha['data_conta']} Tipo conta: {$tipo_conta} Nome: {$linha['nome']}<br>";
                    echo "<a href='../register/{$pagina}.php?id={$linha['id']}&data_conta={$linha['data_conta']}&opc=2'><img src='../_media/edit.png' class='edit' title='Editar'></a>";
                    echo "<a href='../_bd/delete.php?id={$linha['id']}&data_conta={$linha['data_conta']}&tabela={$tipo_conta}'><img src='../_media/delete.png' class='delete' title='Excluir'></a><br>";
                }
                else
                {
                    echo "<br>Data da conta: {$linha['data_conta']} Tipo conta: {$tipo_conta}<br>";
                    echo "<a href='../register/{$pagina}.php?data_conta={$linha['data_conta']}&opc=2'><img src='../_media/edit.png' class='edit' title='Editar'></a>";
                    echo "<a href='../_bd/delete.php?data_conta={$linha['data_conta']}&tabela={$tipo_conta}'><img src='../_media/delete.png' class='delete' title='Excluir'></a><br>";
                }
            }
        }

        function msgErroSql($codeErro, $e)
        {

            switch ($codeErro)
            {
                case 0:
                    $msg = 'DSN ausente ou inválido.';
                    break;
                case 2002:
                    $msg = 'HOST ausente ou inválido.';
                    break;
                case 1045:
                    $msg = 'USER ou PASS ausente ou inválido.';
                    break;
                case 1049:
                    $msg = 'DBNAME ausente ou inválida.';
                    break;
                case '42S02':
                    $msg = 'TABLE ausente ou inválida.';
                    break;
                case '42S22':
                    $msg = 'Algum dos campos passados na query não existe ou o seu nome está incorreto.';
                    break;
                case '21S01':
                    $msg = 'Existem algum campo ausente ou incorreto na query.';
                    break;
                case 'HY093':
                    $msg = 'Existe algum parâmetro ausente ou incorreto na query.';
                    break;
                case 42000:
                    $msg = 'Existe algum parâmetro ausente ou incorreto na query.';
                    break;
                default:
                    $msg = $e -> getMessage();
            }

            return $msg;

        }

    }