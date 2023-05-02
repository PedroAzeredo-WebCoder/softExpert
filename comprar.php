<?php
require_once("./inc/common.php");
checkAccess();

writeLogs("==== " . __FILE__ . " ====", "access");
writeLogs(print_r($_POST, true), "access");

$cad_produto_id        = getParam("cad_produto_id");
$cad_usuario_id        = getParam("cad_usuario_id");
$f_quantidade          = getParam("quantidade");

$dados = array(
    "cad_produto_id"      => $cad_produto_id,
    "cad_usuario_id"      => $cad_usuario_id,
    "quantidade"        => $f_quantidade
);

$sql_insert = "
INSERT INTO cad_compras(
    cad_produto_id,
    cad_usuario_id,
    quantidade,
    dt_compra
)
VALUES(
    :cad_produto_id,
    :cad_usuario_id,
    :quantidade,
    NOW())";

try {
    $conn->prepare($sql_insert)->execute($dados);
    $lastInsertId = $conn->lastInsertId();
    $actionText = "Compra realizada com sucesso";
    $tipo = 'success';
} catch (PDOException $e) {
    $actionText = "Erro ao comprar";
    $tipo = 'error';
    writeLogs("==== " . __FILE__ . " ====", "error");
    writeLogs("Action: Insert SQL", "error");
    writeLogs(print_r($e, true), "error");
    writeLogs(printSQL($sql_insert, $dados, true), "error");
}

setAlert($actionText, $tipo);
redirect("index.php");
