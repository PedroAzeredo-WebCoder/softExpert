<?php
require_once("./inc/common.php");
checkAccess("produtosList");

$pagination = new Pagination();

$table = new Table();
$table->cardHeader(btn("Novo", "produtosCad.php"));
$table->addHeader("Nome");
$table->addHeader("Preço");
$table->addHeader("Quantidade");
$table->addHeader("Tipo de Produto");
$table->addHeader("Status",     "text-center", "col-1", false);
$table->addHeader("Editar",       "text-center", "col-1", false);

$query = new sqlQuery();
$query->addTable("cad_produtos");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("preco");
$query->addcolumn("quantidade");
$query->addcolumn("(SELECT nome FROM cad_tipo_produto WHERE id = cad_produtos.cad_tipo_produto_id) AS tipo_produto");
$query->addcolumn("status");
$query->addOrder("id", "DESC");

$f_searchTableStatus = getParam("f_searchTableStatus");
if ($f_searchTableStatus || $f_searchTableStatus == "0") {
    $query->addWhere("status", "=", "'0'");
} else {
    $query->addWhere("status", "=", "true");
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
        $table->addCol($row["tipo_produto"]);
        $table->addCol($status, "text-center");
        $table->addCol(btn("<i data-feather='edit-3'></i>", ["produtosCad.php", ["cad_produtos_id" => $row["id"]]], NULL, "btn-sm") . btn("<i data-feather='x'></i>", ["produtosCadSave.php", ["cad_produtos_id_delete" => $row["id"]]], NULL, "btn-sm text-danger bg-transparent mx-1"), "text-center");
        $table->endRow();
    }
} else {
    $table->addCol("Nenhum registro encontrado!", "text-center", count($table->getHeaders()));
    $table->endRow();
}

$template = new Template("Listagem de Produtos");
$template->addBreadcrumb("Home", "index.php");
$template->addContent($table->writeHtml());
$template->writeHtml();
