<?php

    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
    {
        header('Location: index.php');
        exit;
    }
    else
    {
        
        require_once '_bd/connection.php';

        function checarData($tabela, $data_conta, $page)
        {
            $conn = getConnection();
            $sql = ("SELECT * FROM {$tabela} WHERE data_conta = :data_conta");
            $stmt = $conn -> prepare($sql);
            $stmt -> bindParam(':data_conta', $data_conta);
            $stmt -> execute();
            $checarData = $stmt -> fetchAll();

            if (count($checarData) > 0)
            {
                $_SESSION['error'] = 'Já existe uma conta cadastrada com a data informada.';
                header('Location: ' . $page);
                exit;
            }
        }

        function checarLeitura($leit_atual, $leit_anteior, $page)
        {
            if ($leit_atual < $leit_anteior)
            {
                $_SESSION['error'] = 'A leitura atual não pode ser menor que a leitura anterior.';
                header('Location: ' . $page);
                exit;
            }

            if ($leit_atual == $leit_anteior)
            {
                $_SESSION['error'] = 'A leitura atual não pode ser igual a leitura anterior.';
                header('Location: ' . $page);
                exit;
            }
        }

        function checarValor($valor, $leit_atual, $leit_anteior, $nome_campo, $page)
        {
            if ($valor != $leit_atual - $leit_anteior)
            {
                $_SESSION['error'] = "O valor no campo {$nome_campo} não pode ser diferente da subtração entre os valores dos campos Leitura atual e Leitura anterior.";
                header('Location: ' . $page);
                exit;
            }
        }

        function checarAcao()
        {

            if (isset($_SESSION['register']))
            {
                echo '<p style="font-weight: bold;">Conta registrada com sucesso!</p>';
				unset($_SESSION['register']);
            }
            elseif (isset($_SESSION['update']))
            {
                echo '<p style="font-weight: bold;">Conta atualizada com sucesso!</p>';
                unset($_SESSION['update']);
            }
            elseif (isset($_SESSION['delete']))
            {
                echo '<p style="font-weight: bold;">Conta excluida com sucesso!</p>';
                unset($_SESSION['delete']);
            }
            elseif (isset($_SESSION['error']))
            {
                echo '<p style="font-weight: bold;">' . $_SESSION['error'] . '</p>';
				unset($_SESSION['error']);
            }

        }

        function execQuery($stmt, $action)
        {
            try
            {
                $stmt -> execute();
                $_SESSION[$action] = 1;
            }
            catch (PDOException $e)
            {
                $_SESSION['error'] = $e -> getMessage();
            }
        }

        function buscarContas($conn, $tabela, $mes, $ano, $filters)
        {
            /* Condições para realizar a busca de acordo com o filtro escolhido pelo usuário */
            
            //Filtros selecionados: nenhum, água, energia e variadas.
            if (empty($filters) || (in_array('agua', $filters) || in_array('energia', $filters) || in_array('variadas', $filters)) && !in_array('P', $filters) && !in_array('NP', $filters))
            {
                $tabela = ("SELECT * FROM {$tabela} WHERE YEAR(data_conta) = :ano AND MONTH(data_conta) = :mes");
            }
            //Filtros selecionados: contas pagas, água + contas pagas, energia + contas pagas e variadas + contas pagas.
            elseif (in_array('P', $filters) || (in_array('agua', $filters) || in_array('energia', $filters) || in_array('variadas', $filters)) && in_array('P', $filters))
            {
                $tabela = ("SELECT * FROM {$tabela} WHERE YEAR(data_conta) = :ano AND MONTH(data_conta) = :mes AND situacao = 'P'");
            }
            //Filtros selecionados: contas não pagas, água + contas não pagas, energia + contas não pagas e variadas + contas não pagas.
            elseif (in_array('NP', $filters) || (in_array('agua', $filters) || in_array('energia', $filters) || in_array('variadas', $filters)) && in_array('NP', $filters))
            {
                $tabela = ("SELECT * FROM {$tabela} WHERE YEAR(data_conta) = :ano AND MONTH(data_conta) = :mes AND situacao = 'NP'");
            }

            $stmt = $conn -> prepare($tabela);
            $stmt -> bindParam(':mes', $mes);
            $stmt -> bindParam(':ano', $ano);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

        function exibirContas($tabela, $tipo_conta, $page)
        {
            foreach ($tabela as $linha)
            {
                if ($tipo_conta == 'variadas')
                {
                    echo "<br>Data da conta: {$linha['data_conta']} Tipo conta: {$tipo_conta} Valor: R$ " . number_format($linha['valor'], 2, ",", ".") . " Situação:";
                    $linha['situacao'] == 'P' ? print ' Paga' : print ' Não paga';
                    echo "<br>Nome: {$linha['nome']}";
                    echo "<br><a href='../register/{$page}.php?id={$linha['id']}&opc=3'><img src='../_media/view.png' class='view' title='Visualizar'></a>";
                    echo "<a href='../register/{$page}.php?id={$linha['id']}&opc=2'><img src='../_media/edit.png' class='edit' title='Editar'></a>";
                    echo "<a href='../_bd/delete.php?id={$linha['id']}&tabela={$tipo_conta}'><img src='../_media/delete.png' class='delete' title='Excluir'></a><br>";
                }
                else
                {
                    echo "<br>Data da conta: {$linha['data_conta']} Tipo conta: {$tipo_conta} Valor: R$ " . number_format($linha['total'], 2, ",", ".") . " Situação:";
                    $linha['situacao'] == 'P' ? print ' Paga' : print ' Não paga';
                    echo "<br><a href='../register/{$page}.php?data_conta={$linha['data_conta']}&opc=3'><img src='../_media/view.png' class='view' title='Visualizar'></a>";
                    echo "<a href='../register/{$page}.php?data_conta={$linha['data_conta']}&opc=2'><img src='../_media/edit.png' class='edit' title='Editar'></a>";
                    echo "<a href='../_bd/delete.php?data_conta={$linha['data_conta']}&tabela={$tipo_conta}'><img src='../_media/delete.png' class='delete' title='Excluir'></a><br>";
                }
            }
        }

        function buscarDadosConta($tabela, $atributo, $parametro, $valor_parametro, $page)
        {
            $conn = getConnection();

            try
            {
                $sql = ("SELECT * FROM {$tabela} WHERE {$atributo} = {$parametro}");
                $stmt = $conn -> prepare($sql);
                $stmt -> bindParam("{$parametro}", $valor_parametro);
                $stmt -> execute();
                $res = $stmt -> fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e)
            {
                $_SESSION['error'] = $e -> getMessage();
            }
            
            if (isset($res) && !empty($res))
            {
                return $res;
            }
            else
            {
                header("Location: ../register/{$page}.php");
                exit;
            }
        }

        function msgErroSql($codeError, $e)
        {

            switch ($codeError)
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
                default:
                    $msg = $e -> getMessage();
            }

            return $msg;

        }

    }