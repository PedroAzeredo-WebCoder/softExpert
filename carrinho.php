<?php

require_once("./inc/common.php");
checkAccess();

$query = new sqlQuery();
$query->addTable("cad_produtos");
$query->addcolumn("id");
$query->addcolumn("nome");
$query->addcolumn("preco");
$query->addcolumn("quantidade");
$query->addcolumn("(SELECT nome FROM cad_tipo_produto WHERE id = cad_produtos.cad_tipo_produto_id) AS tipo_produto");
$query->addcolumn("(SELECT percentual_imposto FROM cad_tipo_produto WHERE id = cad_produtos.cad_tipo_produto_id ) AS percentual");
$query->addcolumn("descricao");
$query->addWhere("id", "=", '1');

foreach ($conn->query($query->getSQL()) as $row) {
    $f_nome = $row["nome"];
    $f_preco = number_format($row["preco"], 2, ",", ".");
    $f_quantidade = $row["quantidade"];
    $f_tipo_produto = $row["tipo_produto"];
    $f_percentual = $row["percentual"];
    $cad_tipo_produto_id = $row["cad_tipo_produto_id"];
    $f_descricao = $row["descricao"];
    $valorImposto = number_format($f_preco * $f_percentual, 2, ",", ".");
}

$dash = array();
$dash[] = '
<div class="row">
    <div class="col-lg-6">
        <h3 class="fw-bolder text-danger">Meu Carrinho</h3>
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/400x400" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">' . $f_nome . '</h5>
                        <p class="card-text">' . $f_descricao . '</p>
                        <p class="card-text">
                            <span class="badge bg-dark">' . $f_tipo_produto . '</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="row justify-content-between align-items-end">
                    <div class="col-lg-4">
                        <p>Quantidade:</p>
                        <div class="input-group">
                            <button id="subtract-btn" class="btn" type="button">
                                <i class="fa-solid fa-circle-minus"></i>
                            </button>
                            <input id="quantity-input" type="number" class="form-control" value="1" data-quantidade="' . $f_quantidade . '">
                            <button id="add-btn" class="btn" type="button">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col text-end">
                        <h3 class="fw-bolder text-dark count-valor-qtd" data-valor="' . str_replace(" ,", "." , $f_preco) . '">Valor R$ ' . $f_preco . '</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <h3 class="fw-bolder text-danger">Resumo da compra</h3>
        <div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush py-2">
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Subtotal (<span id="qtd">1</span> item)</span>
                            <span class="text-muted count-valor-qtd" data-valor="' . str_replace(",", "." , $f_preco) . '">R$ ' . $f_preco . '</span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Valor Produto</span>
                            <span class="text-muted">R$ ' . $f_preco . '</span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Valor Total</span>
                            <div class="text-end">
                                <span class="text-muted" id="percentual-qtd" data-percentual="' . $f_percentual . '">R$ ' . $valorImposto . '</span>
                                <br>
                                <p class="card-text"><small class="text-muted">Valor adicional de ' . $f_percentual . '% pela <br> quantidade de itens selecionados</small></p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button">Finalizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
';
$template = new Template();
$template->addContent(implode("", $dash));
$template->writeHtml();
