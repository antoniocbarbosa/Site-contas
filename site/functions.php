<?php

    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
    {
        header("Location: index.php");
        exit;
    }
    else
    {
        
        require_once "_bd/connection.php";

        function checarData($tabela, $data_conta)
        {
            $conn = getConnection();
            $sql = ("SELECT * FROM " . $tabela . " WHERE data_conta = '{$data_conta}'");

            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $checarData = $stmt -> fetchAll();

            if (count($checarData) > 0)
            {
                $_SESSION["erro"] = "Já existe uma conta cadastrada com a data informada.";
                header("Location: " . $_SESSION["pagina"]);
                exit;
            }
        }

        function checarLeitura($leit_atual, $leit_anteior, $pagina)
        {

            if ($leit_atual < $leit_anteior)
            {
                $_SESSION["erro"] = "A leitura atual não pode ser menor que a leitura anterior.";
                header("Location: " . $pagina);
                exit;
            }

            if ($leit_atual == $leit_anteior)
            {
                $_SESSION["erro"] = "A leitura atual não pode ser igual a leitura anterior.";
                header("Location: " . $pagina);
                exit;
            }

        }

        function checarCadastro()
        {

            if (isset($_SESSION["cadastro"]))
            {
                echo "<p style='font-weight: bold;'>Cadastro realizado com sucesso!</p>";
				unset($_SESSION["cadastro"]);
            }
            elseif (isset($_SESSION["erro"]))
            {
                echo "<p style='font-weight: bold;'>" . $_SESSION["erro"] . "</p>";
				unset($_SESSION["erro"]);
            }

        }

        function execQuery($stmt)
        {

            if ($stmt -> execute())
            {
                $_SESSION["cadastro"] = 1;
            }
            else
            {
                $_SESSION["erro"] = $stmt -> error;
            }

        }

    }