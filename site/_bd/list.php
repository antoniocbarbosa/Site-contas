<?php

    if (isset($_POST['mes']) || isset($_POST['ano']))
    {
        session_start();
        require_once 'connection.php';
        require_once '../functions.php';
        
        $conn = getConnection();

        if ($conn)
        {

            if (empty($_POST['mes']) || empty($_POST['ano']))
            {
                $_SESSION['erro'] = 'Não pode deixar nenhum campo obrigatório em branco. Os campos obrigatórios tem um asterisco * na frente do nome.';
                header('Location: ' . $_SESSION['pagina']);
                exit;
            }

            $mes = $_POST['mes'];
            $ano = $_POST['ano'];

            $tbEnergia = buscarContas($conn, 'energia', $mes, $ano);
            $tbAgua = buscarContas($conn, 'agua', $mes, $ano);
            $tbVariadas = buscarContas($conn, 'variadas', $mes, $ano);

            if (count($tbEnergia) || count($tbAgua) || count($tbVariadas))
            {
                require_once '../header.php';

                echo '<title>Contas</title>';
                echo '<script type="text/javascript" src="../_js/backToTop.js"></script>';
                echo '</head>';
                echo '<a href="../search.php"><input type="button" value="Voltar" id="button"></a>';

                exibirContas($tbEnergia, 'energia', 'energy');
                exibirContas($tbAgua, 'agua', 'water');
                exibirContas($tbVariadas, 'variadas', 'varied');
                
                echo '<button id="btnTop"><img src="../_media/top.png" title="Topo"></button>';
            }
            else
            {
                $_SESSION['erro'] = 'Não foi encontrado nenhuma conta que contém a data informada.';
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