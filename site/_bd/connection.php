<?php

    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
    {
        header("Location: ../index.php");
        exit;
    }
    else
    {
        function getConnection()
        {
            $DSN = "mysql:";
            $HOST = "host=127.0.0.1";
            $DBNAME = "contas";
            $USER = "root";
            $PASS = "@carlos10";

            try
            {
                $conn = new PDO($DSN . $HOST . ";dbname=" . $DBNAME, $USER, $PASS);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }
            catch (PDOException $e)
            {
                //Chama a função passando o código do erro do PDO como parâmetro e retorna uma mensagem de acordo com o código.
                $_SESSION["erro"] = msgErroSql($e -> getCode(), $e);
                
                //Mensagem genérica de erro na conexão com o BD.
                // $_SESSION["erro"] = "Falha na conexão com o banco de dados.";
            }
            
        }
    }