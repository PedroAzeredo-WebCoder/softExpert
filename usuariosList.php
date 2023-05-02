<?php
require_once("./inc/common.php");
checkAccess("usuariosList");

$pagination = new Pagination();

$table = new Table();
$table->cardHeader(btn("Novo", "usuariosCad.php"));
$table->addHeader("Nome");
$table->addHeader("E-mail");
$table->addHeader("Status",     "text-center", "col-1", false);
$table->addHeader("Editar",       "text-center", "col-1", false);

$query = new sqlQuery();
$query->addTable("cad_usuarios");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("email");
$query->addcolumn("status");
$query->addOrder("id", "DESC");

$f_searchTableStatus = getParam("f_searchTableStatus");
if ($f_searchTableStatus || $f_searchTableStatus == "0") {
    $query->addWhere("status", "=", "'0'");
} else {
    $query->addWhere("status", "=", "'1'");
}

if ($conn->query($query->getSQL())  && getDbValue($query->getCount()) != 0) {
    foreach ($conn->query($query->getSQL()) as $row) {
        if ($row["status"] == 1) {
            $status = badge("Ativo", "success");
        } else {
            $status = badge("Inativo", "danger");
        }

        if (!empty($row["email"])) {
            $email = "<a href='mailto:" . $row["email"] . "' target='_blank'>" . $row["email"] . "</a>";
        }

        $table->addCol($row["nome"]);
        $table->addCol($email);
        $table->addCol($status, "text-center");
        $table->addCol(btn("<i data-feather='edit-3'></i>", ["usuariosCad.php", ["cad_usuarios_id" => $row["id"]]], NULL, "btn-sm") . btn("<i data-feather='x'></i>", ["usuariosCadSave.php", ["cad_usuario_id_delete" => $row["id"]]], NULL, "btn-sm text-danger bg-transparent mx-1"), "text-center");
        $table->endRow();
    }
} else {
    $table->addCol("Nenhum registro encontrado!", "text-center", count($table->getHeaders()));
    $table->endRow();
}

$template = new Template("Listagem de Usuários");
$template->addBreadcrumb("Home", "index.php");
$template->addContent($table->writeHtml());
$template->writeHtml();
