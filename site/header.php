<?php
     
    if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
        header('Location: index.php');
        exit;
    }else{
        echo '<!DOCTYPE html>';
        echo '<html lang="pt-br">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="_css/style.css">';
    }

?>