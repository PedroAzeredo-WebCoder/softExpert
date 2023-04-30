<?php
require_once("./inc/common.php");
checkAccess("usuariosList");

$e = getParam("e", true);
$cad_usuarios_id = $e["cad_usuarios_id"];

$f_acessos = array();

$f_status = "checked";

if ($cad_usuarios_id) {
    $query = new sqlQuery();
    $query->addTable("cad_usuarios");
    $query->addcolumn("id");
    $query->addcolumn("nome");
    $query->addcolumn("email");
    $query->addcolumn("status");
    $query->addWhere("id", "=", $cad_usuarios_id);

    foreach ($conn->query($query->getSQL()) as $row) {
        $f_nome = $row["nome"];
        $f_email = $row["email"];
        $f_status = "";

        if ($row["status"] == 1) {
            $f_status = "checked";
        }
    }
}

$form = new Form("usuariosCadSave.php");
$form->addField(hiddenField($cad_usuarios_id, "cad_usuarios_id"));
$form->addField(textField("Nome", $f_nome, NUll, true));
$form->addField(emailField("E-mail", $f_email, NUll, true, "^(?=.{1,256})(?=.{1,64}@)[^\s@]+@[^\s@]+\.[^\s@]{2,}$", NULL, "text-lowercase"));
$form->addField(passField("Senha"));
$form->addField(passField("Confirmar Senha"));
$form->addField(checkboxField("Ativo", $f_status));
$form->addField(submitBtn("Salvar"));

$template = new Template("Cadastro de Usuários");
$template->addBreadcrumb("Home", "index.php");
$template->addBreadcrumb("Listagem de Usuários", "usuariosList.php");
$template->addContent($form->writeHtml(), true);
$template->writeHtml();
