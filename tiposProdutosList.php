<?php
require_once("./inc/common.php");
checkAccess("tiposProdutosList");

$pagination = new Pagination();

$table = new Table();
$table->cardHeader(btn("Novo", "tiposProdutosCad.php"));
$table->addHeader("Nome");
$table->addHeader("Imposto");
$table->addHeader("Descrição");
$table->addHeader("Status",     "text-center", "col-1", false);
$table->addHeader("Editar",       "text-center", "col-1", false);

$query = new sqlQuery();
$query->addTable("cad_tipo_produto");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("percentual_imposto");
$query->addcolumn("descricao");
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

        $table->addCol($row["nome"]);
        $table->addCol($row["percentual_imposto"] . "%");
        $table->addCol($row["descricao"]);
        $table->addCol($status, "text-center");
        $table->addCol(btn("<i data-feather='edit-3'></i>", ["tiposProdutosCad.php", ["cad_tiposProdutos_id" => $row["id"]]], NULL, "btn-sm"), "text-center");
        $table->endRow();
    }
} else {
    $table->addCol("Nenhum registro encontrado!", "text-center", count($table->getHeaders()));
    $table->endRow();
}

$template = new Template("Listagem de Tipos de Produtos");
$template->addBreadcrumb("Home", "index.php");
$template->addContent($table->writeHtml());
$template->writeHtml();
