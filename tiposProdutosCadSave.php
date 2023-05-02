<?php
require_once("./inc/common.php");
checkAccess("tiposProdutosList");

writeLogs("==== " . __FILE__ . " ====", "access");
writeLogs(print_r($_POST, true), "access");

$cad_tiposProdutos_id   = getParam("cad_tiposProdutos_id");
$f_nome                 = getParam("f_nome");
$f_percentual_imposto   = str_replace("%", "", getParam("f_porcentagem"));
$f_descricao            = getParam("f_descricao");
$f_ativo                = getParam("f_ativo");

if ($f_ativo == "on") {
    $f_ativo = "1";
} else {
    $f_ativo = "0";
}

$dados = array(
    "nome"                  => $f_nome,
    "percentual_imposto"    => $f_percentual_imposto,
    "descricao"             => $f_descricao,
    "status"                => $f_ativo
);

$e = getParam("e", true);
$cad_tiposProdutos_id_delete = $e["cad_tiposProdutos_id_delete"];
if ($cad_tiposProdutos_id_delete) {
    $dados["id"] = $cad_tiposProdutos_id_delete;
    $sql_delete = "DELETE FROM cad_tipo_produto WHERE id = :id";

    try {
        $conn->prepare($sql_delete)->execute(array("id" => $cad_tiposProdutos_id_delete));
        $actionText = "Exclusão efetuada com sucesso";
        $tipo = 'success';
    } catch (PDOException $e) {
        $actionText = "Erro ao excluir";
        $tipo = 'error';
        writeLogs("==== " . __FILE__ . " ====", "error");
        writeLogs("Action: DELETE SQL", "error");
        writeLogs(print_r($e, true), "error");
        writeLogs(printSQL($sql_delete, array("id" => $cad_tiposProdutos_id_delete), true), "error");
    }
} else {
    if (!empty($cad_tiposProdutos_id)) {
        $dados["id"] = $cad_tiposProdutos_id;
        $sql_update = "
		UPDATE cad_tipo_produto SET
            nome = :nome,
            percentual_imposto = :percentual_imposto,
			descricao = :descricao,
			status = :status
        WHERE
            id = :id
    ";

        try {
            $conn->prepare($sql_update)->execute($dados);
            $lastInsertId = $cad_tiposProdutos_id;
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
			INSERT INTO cad_tipo_produto (
				nome, 
                percentual_imposto,
                descricao,
				status
			) VALUES (
				:nome, 
                :percentual_imposto,
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
}

setAlert($actionText, $tipo);
redirect("tiposProdutosList.php");
