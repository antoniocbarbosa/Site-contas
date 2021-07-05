<?php

    if (isset($_POST['data_conta']))
    {

        session_start();

        require_once 'connection.php';
        require_once '../functions.php';

        $conn = getConnection($_SESSION['pagina']);

        if ($conn)
        {

            //Registrar contas variadas
            if ($_SESSION['opc'] == 1)
            {

                if (empty($_POST['data_conta']) || empty($_POST['nome']) || empty($_POST['valor']))
                {
                    $_SESSION['erro'] = 'Não pode deixar nenhum campo obrigatório em branco. Os campos obrigatórios tem um asterisco * na frente do nome.';
                    header('Location: ' . $_SESSION['pagina']);
                    exit;
                }

                $sql = ('INSERT INTO variadas (data_conta, nome, valor, situacao, observacao)
                VALUES
                (:data_conta, :nome, :valor, :situacao, :observacao)');

                $stmt = $conn -> prepare($sql);

                $data_conta = $_POST['data_conta'];
                $nome = addslashes(trim(preg_replace('/ + /', ' ', $_POST['nome'])));
                $valor = (float) $_POST['valor'];
                $situacao = $_POST['situacao'];
                $observacao = addslashes(isset($_POST['observacao']) ? trim(preg_replace('/ + /', ' ', $_POST['observacao'])) : null);

                $stmt -> bindParam(':data_conta', $data_conta);
                $stmt -> bindParam(':nome', $nome);
                $stmt -> bindParam(':valor', $valor);
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