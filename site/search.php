<?php session_start(); require_once 'header.php'; ?>
    <title>Buscar</title>
</head>
<body>
    
    <div class="search">
    
        <h1>Buscar contas</h1>

        <form action="../_bd/list.php" method="POST">
            <label for="mes">Mês*: </label>
            <input type="number" name="mes" id="mes" min="1" max="12" placeholder="0"><br>
            <label for="ano">Ano*: </label>
            <input type="number" name="ano" id="ano" min="2000" max="9999" placeholder="0000"><br>
            <input type="submit" value="Buscar">
            <a href="../index.php"><input type="button" value="Voltar" id="button"></a>

            <?php
                $_SESSION['pagina'] = '../search.php';
            ?>
        </form>

        <?php
            require_once 'functions.php';
            checarExclusao();
        ?>

    </div>

</body>
</html>