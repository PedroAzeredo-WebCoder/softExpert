<?php
require_once("./inc/common.php");
checkAccess("produtosList");

$pagination = new Pagination();

$table = new Table();
$table->cardHeader(btn("Novo", "produtosCad.php"));
$table->addHeader("Nome");
$table->addHeader("Preço");
$table->addHeader("Quantidade");
$table->addHeader("Status",     "text-center", "col-1", false);
$table->addHeader("Editar",       "text-center", "col-1", false);

$query = new sqlQuery();
$query->addTable("cad_produtos");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("preco");
$query->addcolumn("quantidade");
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
        $table->addCol("R$ " . number_format($row["preco"], 2, ",", "."), "text-end");
        $table->addCol($row["quantidade"]);
        $table->addCol($status, "text-center");
        $table->addCol(btn("<i data-feather='edit-3'></i>", ["produtosCad.php", ["cad_produtos_id" => $row["id"]]], NULL, "btn-sm"), "text-center");
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
