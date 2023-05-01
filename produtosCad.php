<?php
require_once("./inc/common.php");
checkAccess("produtosList");

$e = getParam("e", true);
$cad_produtos_id = $e["cad_produtos_id"];

$f_status = "checked";

if ($cad_produtos_id) {
    $query = new sqlQuery();
    $query->addTable("cad_produtos");
    $query->addcolumn("id");
    $query->addcolumn("nome");
    $query->addcolumn("preco");
    $query->addcolumn("quantidade");
    $query->addcolumn("cad_tipo_produto_id");
    $query->addcolumn("descricao");
    $query->addcolumn("status");
    $query->addWhere("id", "=", $cad_produtos_id);

    foreach ($conn->query($query->getSQL()) as $row) {
        $f_nome = $row["nome"];
        $f_preco = number_format($row["preco"], 2, ",", ".");
        $f_quantidade = $row["quantidade"];
        $cad_tipo_produto_id = $row["cad_tipo_produto_id"];
        $f_descricao = $row["descricao"];
        $f_status = "";

        if ($row["status"] == 1) {
            $f_status = "checked";
        }
    }
}

$tiposProdutos = new sqlQuery();
$tiposProdutos->addTable("cad_tipo_produto");
$tiposProdutos->addcolumn("id");
$tiposProdutos->addcolumn("nome");
$tiposProdutos->addWhere("status", "=", "1");

if ($conn->query($tiposProdutos->getSQL()) && getDbValue($tiposProdutos->getCount()) != 0) {
    foreach ($conn->query($tiposProdutos->getSQL()) as $row) {
        $options_f_tipo_produto[] = array("id" => $row["id"], "name" => $row["nome"]);
    }
} else {
    $options_f_tipo_produto[] = array("id" => NULL, "name" => "Nenhum registro encontrado!");
}

$form = new Form("produtosCadSave.php");
$form->addField(hiddenField($cad_produtos_id, "cad_produtos_id"));
$form->addField(textField("Nome", $f_nome, NUll, true));
$form->addField(textField("Preço", 'R$ ' . $f_preco, NULL, true));
$form->addField(textField("Quantidade", $f_quantidade, NULL, true));
$form->addField(listField("Tipo de Produto", $options_f_tipo_produto, $cad_tipo_produto_id, "cad_tipo_produto_id", true));
$form->addField(editorAreaField("Descrição", $f_descricao));
$form->addField(checkboxField("Ativo", $f_status));
$form->addField(submitBtn("Salvar"));

$template = new Template("Cadastro de Produtos");
$template->addBreadcrumb("Home", "index.php");
$template->addBreadcrumb("Listagem de Produtos", "produtosList.php");
$template->addContent($form->writeHtml(), true);
$template->writeHtml();
