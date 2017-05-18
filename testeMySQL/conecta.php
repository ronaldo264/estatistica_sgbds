<?php
    @define(HOST, "localhost");
    @define(DB, "testeestatistica");
    @define(USER,"root");
    @define(PASS,"");
    
    try {
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB;
    $conexao = new PDO($dsn, USER, PASS);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo"Erro ao Selecionar o Banco de Dados" . $e->getMessage();
}