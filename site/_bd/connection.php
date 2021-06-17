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
            $DSN = "mysql:host=";
            $HOST = "127.0.0.1";
            $DBNAME = "contas";
            $USER = "root";
            $PASS = "@carlos10";

            try
            {
                $conn = new PDO($DSN . $HOST . ";dbname=" . $DBNAME, $USER, $PASS);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }
            catch (PDOException $erro)
            {
                $_SESSION["erro"] = "Falha na conexão com o banco de dados.";
            }
            
        }
    }