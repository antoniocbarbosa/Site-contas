<?php

    if (isset($_GET['mes']) || isset($_GET['ano']))
    {
        session_start();
        require_once 'connection.php';
        require_once '../functions.php';
        
        $conn = getConnection();

        if ($conn)
        {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $filters = isset($_POST['filters']) ? $_POST['filters'] : null;
            $tbAgua = [];
            $tbEnergia = [];
            $tbVariadas = [];

            $patterns = ['/\'/', '/"/', '/!/', '/@/', '/#/', '/\$/', '/%/', '/¨/', '/&/', '/\*/', '/\(/', '/\)/', '/_/', '/-/', '/\+/', '/=/', '/§/', '/\\\/', '/\|/', '/</', '/>/', '/:/', '/;/', '/\?/', '/\//', '/°/', '/\[/', '/\]/', '/{/', '/}/', '/ª/', '/º/', '/¹/', '/²/', '/³/', '/£/', '/¢/', '/¬/'];

            $temp = isset($_POST['keyword']) ? trim(preg_replace('/ +/', ' ', preg_replace($patterns, '', "{$_POST['keyword']}"))) : null;
            $keyword = !empty($temp) ? "%{$temp}%" : null;

            /* Condições para criar as variáveis das tabelas e armazenar valores nelas de acordo com o filtro escolhido pelo usuário */
            
            //Filtros selecionados: nenhum, contas pagas, contas não pagas e agua + energia + variadas.
            if ((empty($filters) || (in_array('P', $filters) || in_array('NP', $filters)) && !in_array('agua', $filters) && !in_array('energia', $filters) && !in_array('variadas', $filters) || in_array('agua', $filters) && in_array('energia', $filters) && in_array('variadas', $filters)) && empty($keyword))
            {
                $tbAgua = buscarContas($conn, 'agua', $mes, $ano, $filters);
                $tbEnergia = buscarContas($conn, 'energia', $mes, $ano, $filters);
                $tbVariadas = buscarContas($conn, 'variadas', $mes, $ano, $filters);
            }
            //Filtros selecionados: água, água + contas pagas e água + contas não pagas.
            if ((!empty($filters) && ((in_array('agua', $filters) || in_array('P', $filters) && in_array('agua', $filters) || in_array('NP', $filters) && in_array('agua', $filters)) && !in_array('energia', $filters) && !in_array('variadas', $filters))) && empty($keyword))
            {
                $tbAgua = buscarContas($conn, 'agua', $mes, $ano, $filters);
            }
            //Filtros selecionados: energia, energia + contas pagas e energia + contas não pagas.
            elseif ((!empty($filters) && ((in_array('energia', $filters) || in_array('P', $filters) && in_array('energia', $filters) || in_array('NP', $filters) && in_array('energia', $filters)) && !in_array('agua', $filters) && !in_array('variadas', $filters))) && empty($keyword))
            {
                $tbEnergia = buscarContas($conn, 'energia', $mes, $ano, $filters);
            }
            //Filtros selecionados: variadas, variadas + contas pagas e variadas + contas não pagas.
            elseif ((!empty($filters) && ((in_array('variadas', $filters) || in_array('P', $filters) && in_array('variadas', $filters) || in_array('NP', $filters) && in_array('variadas', $filters)) && !in_array('agua', $filters) && !in_array('energia', $filters))) && empty($keyword))
            {
                $tbVariadas = buscarContas($conn, 'variadas', $mes, $ano, $filters);
            }
            //Filtros selecionados: água + energia.
            elseif ((!empty($filters) && in_array('agua', $filters) && in_array('energia', $filters) && !in_array('variadas', $filters)) && empty($keyword))
            {
                $tbAgua = buscarContas($conn, 'agua', $mes, $ano, $filters);
                $tbEnergia = buscarContas($conn, 'energia', $mes, $ano, $filters);
            }
            //Filtros selecionados: água + variadas.
            elseif ((!empty($filters) && in_array('agua', $filters) && in_array('variadas', $filters) && !in_array('energia', $filters)) && empty($keyword))
            {
                $tbAgua = buscarContas($conn, 'agua', $mes, $ano, $filters);
                $tbVariadas = buscarContas($conn, 'variadas', $mes, $ano, $filters);
            }
            //Filtros selecionados: energia + variadas.
            elseif ((!empty($filters) && in_array('energia', $filters) && in_array('variadas', $filters) && !in_array('agua', $filters)) && empty($keyword))
            {
                $tbEnergia = buscarContas($conn, 'energia', $mes, $ano, $filters);
                $tbVariadas = buscarContas($conn, 'variadas', $mes, $ano, $filters);
            }
            elseif (empty($filters) && !empty($keyword))
            {
                $tabela = ("SELECT * FROM variadas WHERE nome LIKE :keyword AND MONTH(data_conta) = :mes");
                $stmt = $conn -> prepare($tabela);
                $stmt -> bindParam(':keyword', $keyword);
                $stmt -> bindParam(':mes', $mes);
                $stmt -> execute();
                $tbVariadas = $stmt -> fetchAll();
                if (!count($tbVariadas))
                {
                    $_SESSION['error'] = 'Não foi encontrada nenhuma conta que contenha a palavra informada no nome.';
                }
            }
            elseif (!empty($filters) && !empty($keyword))
            {
                $_SESSION['error'] = 'Não pode informar uma palavra-chave e selecionar um filtro ao mesmo tempo.';
            }

            if (count($tbEnergia) || count($tbAgua) || count($tbVariadas))
            {
                require_once '../header.php';

                echo '<title>Contas</title>';
                echo '<script type="text/javascript" src="../_js/backToTop.js"></script>';
                echo '</head>';
                echo '<a href="../search.php"><input type="button" value="Voltar" id="button"></a>';

                echo "<form action='../_bd/list.php?mes={$mes}&ano={$ano}' method='POST'>";
                echo '<br><br><fieldset><legend>Filtrar contas:</legend>';
                echo '<input type="radio" name="filters[]" id="contasPagas" value="P">';
                echo '<label for="contasPagas">Contas pagas </label>';
                echo '<input type="radio" name="filters[]" id="contasNaoPagas" value="NP">';
                echo '<label for="contasNaoPagas">Contas não pagas </label>';
                echo '<input type="checkbox" name="filters[]" id="agua" value="agua">';
                echo '<label for="agua">Água </label>';
                echo '<input type="checkbox" name="filters[]" id="energia" value="energia">';
                echo '<label for="energia">Energia </label>';
                echo '<input type="checkbox" name="filters[]" id="variadas" value="variadas">';
                echo '<label for="variadas">Variadas</label><br><br>';
                echo '<label for ="keyword">Palavra-chave: </label>';
                echo '<input type="text" name="keyword" id="keyword" size="50" maxlength="50">';
                echo '</fieldset><br>';
                echo '<input type="submit" value="Aplicar">';
                echo '</form>';

                if (!empty($_SESSION['error']))
                {
                    echo '<p style="font-weight: bold;">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }

                exibirContas($tbAgua, 'agua', 'water');
                exibirContas($tbEnergia, 'energia', 'energy');
                exibirContas($tbVariadas, 'variadas', 'varied');

                echo '<button id="btnTop"><img src="../_media/top.png" title="Topo"></button>';
            }
            elseif (!empty($filters) && (empty($tbEnergia) || empty($tbAgua) || empty($tbVariadas)) || !empty($keyword) && empty($tbVariadas)) //Condição para caso as contas da data pesquisada não tenha o filtro escolhido pelo usuário
            {
                header("Location: ../_bd/list.php?mes={$mes}&ano={$ano}");
                exit;
            }
            else
            {
                $_SESSION['error'] = 'Não foi encontrado nenhuma conta que contém a data informada.';
                header('Location: ../search.php');
                exit;
            }
        }
        else
        {
            header('Location: ../search.php');
            exit;
        }

    }
    else
    {
        header('Location: ../index.php');
        exit;
    }