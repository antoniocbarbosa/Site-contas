<?php

    session_start();

    if (empty($_GET['data_conta']) || empty($_GET['tabela']) || $_GET['tabela'] == 'variadas' && empty($_GET['id']))
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
            $data_conta = $_GET['data_conta'];
            $tabela = $_GET['tabela'];
            
            if ($tabela == 'variadas')
            {
                $id = $_GET['id'];

                $sql = ("SELECT * FROM {$tabela} WHERE id = :id AND data_conta = :data_conta");
                $stmt = $conn -> prepare($sql);
                $stmt -> bindParam(':id', $id);
                $stmt -> bindParam(':data_conta', $data_conta);
                $stmt -> execute();
                $res = $stmt -> fetchAll();
                        
                if (count($res))
                {
                    $sql = '';
                    $stmt = '';
                    try
                    {
                        $sql = ("DELETE FROM {$tabela} WHERE id = :id AND data_conta = :data_conta");
                        $stmt = $conn -> prepare($sql);
                        $stmt -> bindParam(':id', $id);
                        $stmt -> bindParam(':data_conta', $data_conta);
                        execQuery($stmt, 'excluir');
                    }
                    catch (PDOException $e)
                    {
                        $_SESSION['erro'] = $e -> getMessage();
                    }

                    header('Location: ../search.php');
                    exit;
                    
                }
                else
                {
                    //Mensagem para caso digite um id que não tem na tabela variadas do BD diretamente na url
                    $_SESSION['erro'] = 'Não foi encontrado nenhuma conta que contém o id e data informados.';
                    header('Location: ../search.php');
                    exit;
                }
            }
            else //Caso não seja uma conta do tipo variadas
            {
                $sql = ("SELECT * FROM {$tabela} WHERE data_conta = :data_conta");
                $stmt = $conn -> prepare($sql);
                $stmt -> bindParam(':data_conta', $data_conta);
                $stmt -> execute();
                $res = $stmt -> fetchAll();
                        
                if (count($res))
                {
                    $sql = '';
                    $stmt = '';
                    try
                    {
                        $sql = ("DELETE FROM {$tabela} WHERE data_conta = :data_conta");
                        $stmt = $conn -> prepare($sql);
                        $stmt -> bindParam(':data_conta', $data_conta);
                        execQuery($stmt, 'excluir');
                    }
                    catch (PDOException $e)
                    {
                        $_SESSION['erro'] = $e -> getMessage();
                    }
                            
                    header('Location: ../search.php');
                    exit;
                }
                else
                {
                    //Mensagem para caso digite uma data que não tem nas tabelas energia e agua do BD diretamente na url
                    $_SESSION['erro'] = 'Não foi encontrado nenhuma conta que contém a data informada.';
                    header('Location: ../search.php');
                    exit;
                }
            }
        }
        else
        {
            header('Location: ../search.php');
            exit;
        }

    }