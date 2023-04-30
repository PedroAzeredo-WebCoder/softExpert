<?php
require_once("./inc/common.php");
checkAccess("usuariosList");

writeLogs("==== " . __FILE__ . " ====", "access");
writeLogs(print_r($_POST, true), "access");

$cad_usuarios_id        = getParam("cad_usuarios_id");
$f_nome                 = getParam("f_nome");
$f_email                = strtolower(getParam("f_email"));
$f_senha                = getParam("f_senha");
$f_confirmar_senha      = getParam("f_confirmar_senha");
$f_ativo                = getParam("f_ativo");

if ($f_ativo == "on") {
    $f_ativo = "1";
} else {
    $f_ativo = "0";
}

validar_email($f_email);

$dados = array(
    "id"              => $cad_usuarios_id,
    "nome"            => $f_nome,
    "email"           => $f_email,
    "status"          => $f_ativo,
);

if (!empty($f_senha) && !empty($f_confirmar_senha)) {
    $dados["senha"] = validar_senha($f_senha, $f_confirmar_senha);
}

if (!empty($cad_usuarios_id)) {
    $sql_update = "
		UPDATE cad_usuarios SET
            nome = :nome,
			email = :email,
			status = :status
		WHERE
			id = :id
		";

    if ($f_senha != "") {
        $sql_update = "
            UPDATE cad_usuarios SET
                nome = :nome,
                senha = :senha,
                email = :email,
                status = :status
            WHERE
                id = :id
            ";
    }

    try {
        $conn->prepare($sql_update)->execute($dados);
        $lastInsertId = $cad_usuarios_id;
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
    $dados["uniqid"] = uniqIdNew();

    $sql_insert = "
			INSERT INTO cad_usuarios (
				id, 
				nome, 
				senha, 
				email,
                uniqid,
				status
			) VALUES (
				:id, 
				:nome, 
				:senha, 
				:email,
                :uniqid, 
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
redirect("usuariosList.php");
