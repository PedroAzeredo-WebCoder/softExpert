<?php

require_once("./inc/common.php");
checkAccess();

$query = new sqlQuery();
$query->addTable("cad_produtos");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("preco");
$query->addcolumn("(SELECT nome FROM cad_tipo_produto WHERE id = cad_produtos.cad_tipo_produto_id) AS tipo_produto");
$query->addcolumn("descricao");

if ($conn->query($query->getSQL())  && getDbValue($query->getCount()) != 0) {
    $card = array();
    foreach ($conn->query($query->getSQL()) as $row) {
        $f_nome = $row["nome"];
        $f_preco = number_format($row["preco"], 2, ",", ".");
        $f_tipo_produto = $row["tipo_produto"];
        $f_descricao = $row["descricao"];

        $card[] = '
        <div class="col-lg-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x270" class="img-fluid" alt="...">
                <div class="card-body">
                    <h5 class="card-title">' . $f_nome . '</h5>
                    <p class="card-text">' . $f_descricao . '</p>
                    <p class="fw-bolder">R$ ' . $f_preco . '</p>
                    <p class="card-text">
                        <span class="badge bg-dark">' . $f_tipo_produto . '</span>
                    </p>
                    ' . btn("Comprar", ["carrinho.php", ["cad_produtos_id" => $row["id"]]]) . '
                </div>
            </div>
        </div>
        ';
    }
}

$dash = array();
$dash[] = '
<div class="row">
    ' . implode("", $card) . '
</div>
';
$template = new Template();
$template->addContent(implode("", $dash));
$template->writeHtml();
