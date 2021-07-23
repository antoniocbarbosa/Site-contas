<?php

    if (isset($_POST['data_conta']))
    {

        session_start();

        require_once 'connection.php';
        require_once '../functions.php';

        $conn = getConnection();
        $page = isset($_POST['page']) ? $_POST['page'] : '../register/varied.php';

        if ($conn)
        {
            if (empty($_POST['data_conta']) || empty($_POST['nome']) || empty($_POST['valor']))
            {
                $_SESSION['error'] = 'Não pode deixar nenhum campo obrigatório em branco. Os campos obrigatórios tem um asterisco * na frente do nome.';
                header('Location: ' . $page);
                exit;
            }
            
            if ($_SESSION['opc'] == 1) //Registrar contas variadas
            {
                $action = 'register';

                $sql = ('INSERT INTO variadas (data_conta, nome, valor, situacao, observacao)
                VALUES
                (:data_conta, :nome, :valor, :situacao, :observacao)');
            }
            elseif ($_SESSION['opc'] == 2) //Atualizar contas variadas
            {
                $action = 'update';
                $id = $_POST['id'];

                $sql = ("UPDATE variadas SET data_conta = :data_conta, nome = :nome, valor = :valor, situacao = :situacao, observacao = :observacao WHERE id = '{$id}'");
            }

            $stmt = $conn -> prepare($sql);

            $data_conta = $_POST['data_conta'];
            $nome = addslashes(trim(preg_replace('/ + /', ' ', $_POST['nome'])));
            $valor = (float) $_POST['valor'];
            $situacao = $_POST['situacao'];
            $observacao = addslashes(isset($_POSTeee['observacao']) ? trim(preg_replace('/ + /', ' ', $_POST['observacao'])) : null);

            $stmt -> bindParam(':data_conta', $data_conta);
            $stmt -> bindParam(':nome', $nome);
            $stmt -> bindParam(':valor', $valor);
            $stmt -> bindParam(':situacao', $situacao);
            $stmt -> bindParam(':observacao', $observacao);

            execQuery($stmt, $action);

            header('Location: ' . $page);
            exit;
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