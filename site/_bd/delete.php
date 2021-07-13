<?php

    session_start();

    if (!isset($_GET['tabela']) || empty($_GET['tabela']) || $_GET['tabela'] != 'variadas'
    && empty($_GET['data_conta']) || $_GET['tabela'] == 'variadas' && empty($_GET['id'])) 
    {
        header('Location: ../index.php');
        exit;
    }
    else
    {

        require_once 'connection.php';
        require_once '../functions.php';

        $conn = getConnection();

        if ($conn)
        {
            $tabela = $_GET['tabela'];

            if ($tabela == 'variadas')
            {
                $id = $_GET['id'];
                delete($conn, $tabela, 'id', ':id', $id);
            }
            elseif ($tabela == 'energia' || $tabela == 'agua')
            {
                $data_conta = $_GET['data_conta'];
                delete($conn, $tabela, 'data_conta', ':data_conta', $data_conta);
            }
            else
            {
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

    function delete($conn, $tabela, $atributo, $parametro, $valor_parametro)
    {
        try
        {
            $sql = ("SELECT * FROM {$tabela} WHERE {$atributo} = {$parametro}");
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("{$parametro}", $valor_parametro);
            $stmt->execute();
            $res = $stmt->fetchAll();
        }
        catch (PDOException $e)
        {
            $_SESSION['error'] = $e -> getMessage();
        }

        if (!empty($res))
        {
            unset($sql);
            unset($stmt);
            try
            {
                $sql = ("DELETE FROM {$tabela} WHERE {$atributo} = {$parametro}");
                $stmt = $conn->prepare($sql);
                $stmt->bindParam("{$parametro}", $valor_parametro);
                execQuery($stmt, 'delete');
            }
            catch (PDOException $e)
            {
                $_SESSION['error'] = $e->getMessage();
            }
        }
        elseif ($tabela == 'variadas' && empty($res))
        {
            //Mensagem para caso digite um id que não tem na tabela variadas do BD diretamente na url
            $_SESSION['error'] = 'Não foi encontrado nenhuma conta que contém o id informado.';
        }
        elseif ($tabela != 'variadas' && empty($res))
        {
            //Mensagem para caso digite uma data que não tem nas tabelas energia e agua do BD diretamente na url
            $_SESSION['error'] = 'Não foi encontrado nenhuma conta que contém a data informada.';
        }

        header('Location: ../search.php');
        exit;
    }