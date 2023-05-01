<?php
require_once("./inc/common.php");
checkAccess("tiposProdutosList");

$e = getParam("e", true);
$cad_tiposProdutos_id = $e["cad_tiposProdutos_id"];

$f_status = "checked";

if ($cad_tiposProdutos_id) {
    $query = new sqlQuery();
    $query->addTable("cad_tipo_produto");
    $query->addcolumn("id");
    $query->addcolumn("nome");
    $query->addcolumn("descricao");
    $query->addcolumn("status");
    $query->addWhere("id", "=", $cad_tiposProdutos_id);

    foreach ($conn->query($query->getSQL()) as $row) {
        $f_nome = $row["nome"];
        $f_descricao = $row["descricao"];
        $f_status = "";

        if ($row["status"] == 1) {
            $f_status = "checked";
        }
    }
}

$form = new Form("tiposProdutosCadSave.php");
$form->addField(hiddenField($cad_tiposProdutos_id, "cad_tiposProdutos_id"));
$form->addField(textField("Nome", $f_nome, NUll, true));
$form->addField(editorAreaField("Descrição", $f_descricao));
$form->addField(checkboxField("Ativo", $f_status));
$form->addField(submitBtn("Salvar"));

$template = new Template("Cadastro de Tipos de Produtos");
$template->addBreadcrumb("Home", "index.php");
$template->addBreadcrumb("Listagem de Tipos de Produtos", "tiposProdutosList.php");
$template->addContent($form->writeHtml(), true);
$template->writeHtml();
