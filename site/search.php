<?php require_once 'header.php' ?>
    <title>Buscar</title>
</head>
<body>
    
    <div class="search">
    
        <h1>Buscar contas</h1>
        <form action="" method="POST">
            <label for="month">Mês: </label>
            <input type="number" name="month" id="month" min="1" max="12"><br>
            <label for="year">Ano: </label>
            <input type="number" name="year" id="year" min="2000" max="3000"><br>
            <input type="submit" value="Buscar">
            <a href="index.php"><input type="button" value="Voltar" id="button"></a>
        </form>

    </div>

</body>
</html>