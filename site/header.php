<?php
     
    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
        header('Location: index.php');
        exit;
    }else{
        echo '<!DOCTYPE html>';
        echo '<html lang="pt-br">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<link rel="stylesheet" href="../_css/style.css">';
        echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js";></script>';
    }

?>