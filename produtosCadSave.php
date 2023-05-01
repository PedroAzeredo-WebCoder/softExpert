<?php
require_once("./inc/common.php");
checkAccess("produtosList");

writeLogs("==== " . __FILE__ . " ====", "access");
writeLogs(print_r($_POST, true), "access");

$cad_produtos_id   = getParam("cad_produtos_id");
$f_nome                 = getParam("f_nome");
$f_preco                = str_replace(array(',', 'R$'), array('.', ''), getParam("f_preco"));
$f_quantidade           = getParam("f_quantidade");
$cad_tipo_produto_id    = getParam("cad_tipo_produto_id");
$f_descricao            = getParam("f_descricao");
$f_ativo                = getParam("f_ativo");

if ($f_ativo == "on") {
    $f_ativo = "1";
} else {
    $f_ativo = "0";
}

$dados = array(
    "id"                  => $cad_produtos_id,
    "nome"                => $f_nome,
    "preco"               => $f_preco,
    "quantidade"          => $f_quantidade,
    "cad_tipo_produto_id" => $cad_tipo_produto_id,
    "descricao"           => $f_descricao,
    "status"              => $f_ativo
);

if (!empty($cad_produtos_id)) {
    $sql_update = "
		UPDATE cad_produtos SET
            nome = :nome,
            preco = :preco,
            quantidade = :quantidade,
            cad_tipo_produto_id = :cad_tipo_produto_id,
			descricao = :descricao,
			status = :status
        WHERE
            id = :id
    ";

    try {
        $conn->prepare($sql_update)->execute($dados);
        $lastInsertId = $cad_produtos_id;
        $actionText = "Alteração efetuada com sucesso";
        $tipo = 'success';
    } catch (PDOException $e) {
        $actionText = "Erro ao alterar";
        $tipo = 'error';
        writeLogs("==== " . __FILE__ . " ====", "error");
        writeLogs("Action: UPDATE SQL", "error");
        writeLogs(print_r($e, true), "error");
        writeLogs(printSQL($sql_update, $dados, true), "error");
    }
} else {

    $sql_insert = "
			INSERT INTO cad_produtos (
				id, 
				nome, 
                preco,
                quantidade,
                cad_tipo_produto_id,
                descricao,
				status
			) VALUES (
				:id, 
				:nome, 
                :preco,
                :quantidade,
                :cad_tipo_produto_id,
				:descricao,
				:status
			)";

    try {
        $conn->prepare($sql_insert)->execute($dados);
        $lastInsertId = $conn->lastInsertId();
        $actionText = "Cadastro efetuado com sucesso";
        $tipo = 'success';
    } catch (PDOException $e) {
        $actionText = "Erro ao cadastrar";
        $tipo = 'error';
        writeLogs("==== " . __FILE__ . " ====", "error");
        writeLogs("Action: Insert SQL", "error");
        writeLogs(print_r($e, true), "error");
        writeLogs(printSQL($sql_insert, $dados, true), "error");
    }
}

setAlert($actionText, $tipo);
redirect("produtosList.php");
