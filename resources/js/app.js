require("jquery");
require("bootstrap");
require("@fortawesome/fontawesome-free");
require("jquery-mask-plugin/dist/jquery.mask.min");
import AOS from "aos";
import Quill from "quill";
require("sweetalert2/dist/sweetalert2.all.min");
require("jquery-maskmoney/dist/jquery.maskMoney.min");

window._ = require("lodash");

try {
  window.Popper = require("@popperjs/core").default;
  window.$ = window.jQuery = require("jquery");
} catch (e) {}

jQuery(function () {
  masks();
  consultaCep();
  themeColor();
  switchChange();
  featherIcons();
  AOS.init();

  $(window).ready(function () {
    masks();
    consultaCep();
    themeColor();
    addShowPasswordButtons();
    AOS.init();
  });

  $(window).on("load", function () {
    masks();
    consultaCep();
    themeColor();
    featherIcons();
    AOS.init();
  });

  function masks() {
    //Telefone
    let phoneFields = $(
      '[type="tel"], [id="tel"], [name="f_telefone"], [name="f_celular"]'
    );

    let phoneMaskBehavior = function (val) {
      if (val !== undefined && val !== null) {
        return val.replace(/\D/g, "").length === 11
          ? "(00) 00000-0000"
          : "(00) 0000-00009";
      }
    };

    let phoneOptions = {
      onKeyPress: function (val, e, field, options) {
        field.mask(phoneMaskBehavior.apply({}, arguments), options);
      },
    };
    phoneFields.mask(phoneMaskBehavior, phoneOptions);
    phoneFields.attr("inputmode", "numeric");

    //CEP
    let cepFields = $('[name="cep"], [id="cep"], [name="f_cep"]');
    cepFields.mask("00000-000", {
      reverse: true,
    });
    cepFields.attr("inputmode", "numeric");

    //CPF
    let cpf = $('.mask-cpf, [name="cpf"], [id="cpf"], [name="f_cpf"]');
    cpf.mask("000.000.000-00", {
      reverse: true,
    });
    cpf.attr("inputmode", "numeric");

    //CNPJ
    let cnpj = $('.mask-cnpj, [name="cnpj"], [id="cnpj"], [name="f_cnpj"]');
    cnpj.mask("00.000.000/0000-00", {
      reverse: true,
    });
    cnpj.attr("inputmode", "numeric");

    //CPF ou CNPJ
    let cpfCnpj = $('[name="cpf-cnpj"], [id="cpf-cnpj"], [name="f_documento"]');

    let options = {
      onKeyPress: function (cpf, ev, el, op) {
        let masks = ["000.000.000-00#", "00.000.000/0000-00"];
        let sanitizedValue = cpfCnpj.val()?.replace(/\D/g, "");
        cpfCnpj.mask(sanitizedValue.length > 11 ? masks[1] : masks[0], op);
      },
    };

    let sanitizedValue = cpfCnpj.val();
    if (sanitizedValue !== undefined && sanitizedValue !== null) {
      cpfCnpj.mask(
        sanitizedValue.length > 14 ? "00.000.000/0000-00" : "000.000.000-00#",
        options
      );
    }

    cpfCnpj.attr("inputmode", "numeric");

    //Números cartão de crédito
    let creditCard = $(
      '.mask-credit-card, [name="credit-card"], [id="credit-card"]'
    );
    creditCard.mask("0000 0000 0000 0000", {
      reverse: true,
    });
    creditCard.attr("inputmode", "numeric");

    //CVV
    let cvv = $('.mask-cvv, [name="cvv"], [id="cvv"]');
    cvv.mask("000", {
      reverse: true,
    });
    cvv.attr("inputmode", "numeric");

    //Data
    // let date = $('.mask-date, [name="date"], [id="date"], [type="date"]')
    // date.mask('00/00/0000', {
    //   reverse: true
    // })
    // date.attr('inputmode', 'numeric')

    //Mes e ano
    let mesAno = $('.mask-mesAno, [name="mesAno"], [id="mesAno"]');
    mesAno.mask("00/0000", {
      reverse: true,
    });
    mesAno.attr("inputmode", "numeric");

    let ano = $(
      '.mask-mesAno, [name="mesAno"], [id="mesAno"], [name="f_ano_fabricacao"], [name="f_ano_veiculo"]'
    );
    ano.mask("0000", {
      reverse: true,
    });
    mesAno.attr("inputmode", "numeric");

    let money = $(
      '[name="f_valor"], [name="f_preco"], [name="f_valor_unitario"]'
    );
    money.attr("inputmode", "numeric");
    money.maskMoney({
      prefix: "R$ ",
      defaultValue: "R$ 0,00",
      allowNegative: true,
      thousands: ".",
      decimal: ",",
      affixesStay: true,
    });

    let porcentage = $('[name="f_porcentagem"],[name="porcentagem"]');
    porcentage.attr("inputmode", "numeric");
    porcentage.mask("##0,00%", {
      reverse: true,
    });

    // Placa Veicular (Car Plate Number)
    let carPlateFields = $('[name="placa"], [id="placa"], [name="f_placa"]');
    let carPlateOptions = {
      onKeyPress: function (val, e, field, options) {
        // Define two possible masks for car plate numbers
        let masks = ["AAA-0000", "AAA0A00"];
        // Sanitize the input value by removing non-alphanumeric characters
        let sanitizedValue = field.val().replace(/[^A-Z0-9]/g, "");
        // Apply the appropriate mask based on the sanitized value's length and format
        field.mask(
          sanitizedValue.match(/^[A-Z0-9]{4}$/) ? masks[0] : masks[1],
          options
        );
      },
    };

    // Apply the initial mask to the car plate input field(s)
    let masks = ["AAA-0000", "AAA0A00"];
    carPlateFields.each(function () {
      let field = $(this);
      field.mask(
        // Check if the current value matches the expected format for the first mask option
        field.val().match(/^[A-Z]{3}[0-9]{4}$/) ? masks[0] : masks[1],
        carPlateOptions
      );
    });

    // Update the mask whenever the value of the car plate input field changes
    carPlateFields.on("input", function () {
      let field = $(this);
      field.unmask(); // Remove the current mask
      field.mask(
        // Check if the new value matches the expected format for the first mask option
        field.val().match(/^[A-Z]{3}[0-9]{4}$/) ? masks[0] : masks[1],
        carPlateOptions
      );
    });
  }

  function consultaCep() {
    const elementos = [
      {
        name: "uf",
        selector: "#js_estado",
      },
      {
        name: "bairro",
        selector: "#js_bairro",
      },
      {
        name: "logradouro",
        selector: "#js_logradouro",
      },
      {
        name: "localidade",
        selector: "#js_cidade",
      },
      {
        selector: "#js_numero",
      },
      {
        selector: "#js_complemento",
      },
    ];

    const campos = elementos.map((elemento) => {
      return $(
        `[name="f_${elemento.name}"],[name="${elemento.name}"],${elemento.selector}`
      );
    });

    const mostrarCampos = () =>
      campos.forEach((campo) => campo.removeClass("d-none"));

    const ocultarCampos = () =>
      campos.forEach((campo) => campo.addClass("d-none"));

    const preencherCampos = (valor) => {
      elementos.forEach(({ name, selector }) => {
        const campo = $(`[name="f_${name}"],[name="${name}"],${selector}`);
        campo.val(valor[name]);
      });
    };

    const mostrarErro = () => {
      swal({
        title: "CEP inválido!",
        icon: "error",
        timer: 3000,
      });
    };

    const buscarCep = (cep) => {
      return $.getJSON(`https://viacep.com.br/ws/${cep}/json/`);
    };

    const onCepChange = function () {
      const cep = $(this).val();
      if (!cep) return;

      const consultaCep = buscarCep(cep);

      consultaCep.always(() => {
        const valor = consultaCep.responseJSON;

        if (!("erro" in valor)) {
          mostrarCampos();
          preencherCampos(valor);
        } else {
          ocultarCampos();
          mostrarErro();
        }
      });
    };

    ocultarCampos();
    $('.mask-cep, [name="cep"], [id="cep"],[name="f_cep"]').on(
      "change",
      onCepChange
    );

    // chama a função onCepChange quando a página é carregada
    const cepInicial = $('[name="f_cep"]').val();
    if (cepInicial) onCepChange.call($('[name="f_cep"]')[0]);
  }

  function addShowPasswordButton(element) {
    const id = element.attr("id");
    element.after(
      `<button type='button' class='showPass' toggle='#${id}'><svg viewBox='0 0 24 24' width='24' height='24' stroke='#000' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round' class='css-i6dzq1'><path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path><circle cx='12' cy='12' r='3'></circle></svg></button>`
    );
  }

  function togglePassword(input, button) {
    const inputType = input.attr("type");
    if (inputType === "password") {
      input.attr("type", "text");
      button
        .children("svg")
        .html(
          '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>'
        );
    } else {
      input.attr("type", "password");
      button
        .children("svg")
        .html(
          '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
        );
    }
  }

  function addShowPasswordButtons() {
    const passwordInputs = $("[type='password'][id]");
    passwordInputs.each(function () {
      addShowPasswordButton($(this));
    });
    $(".showPass").click(function () {
      const input = $($(this).attr("toggle"));
      togglePassword(input, $(this));
    });
  }

  // add theme-all-scripts main color in header meta tags
  function themeColor() {
    const themeColor = $(
      '[name="theme-color"], [name="msapplication-navbutton-color"], [name="msapplication-TileColor"]'
    );
    const value = getComputedStyle(document.documentElement).getPropertyValue(
      "--bs-primary"
    );
    themeColor.attr("content", value);
  }

  function switchChange() {
    $("#id_swithChangeOn").on("change", function () {
      $("#searchTable form").submit();
    });
  }

  function featherIcons() {
    if (feather) {
      feather.replace({
        width: 14,
        height: 14,
      });
    }
  }

  function initializeEditors() {
    $(".editor-field").each(function () {
      const $editor = $(this);
      const toolbarOptions = $editor.data("toolbaroptions")
        ? JSON.parse($editor.data("toolbaroptions"))
        : null;
      const quill = new Quill(this, {
        modules: {
          toolbar: toolbarOptions || [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ direction: "rtl" }],
            [{ size: ["small", false, "large", "huge"] }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ color: [] }, { background: [] }],
            [{ font: [] }],
            [{ align: [] }],
            ["clean"],
          ],
        },
        theme: "snow",
      });

      const $targetInput = $(`#${$editor.data("target")}`);

      if ($targetInput.val()) {
        quill.root.innerHTML = $targetInput.val();
      }

      quill.on("text-change", function () {
        $targetInput.val(quill.root.innerHTML);
      });
    });
  }

  // Exemplo de uso
  initializeEditors();

  // Editor personalizado
  const toolbarOptionsCustom = JSON.stringify([
    ["bold", "italic", "underline", "strike"],
    ["blockquote", "code-block"],
    [{ header: 1 }, { header: 2 }],
    [{ list: "ordered" }, { list: "bullet" }],
    [{ script: "sub" }, { script: "super" }],
    [{ indent: "-1" }, { indent: "+1" }],
    [{ direction: "rtl" }],
    [{ size: ["small", false, "large", "huge"] }],
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
    [{ color: [] }, { background: [] }],
    [{ font: [] }],
    [{ align: [] }],
    ["clean"],
  ]);

  const editorCustom = document.querySelector("#editor-custom");
  if (editorCustom) {
    editorCustom.dataset.toolbaroptions = toolbarOptionsCustom;
    initializeEditors();
  }

  $(function () {
    const countValorQtdElements = $(".count-valor-qtd");
    const quantityInput = $("#quantity-input");
    const percentual = $("#percentual-qtd").data("percentual");

    function updateValor() {
      const quantidade = quantityInput.val();
      const valor = parseFloat(countValorQtdElements.data("valor"));
      const novoValor = valor * quantidade;
      const novoValorPercentual = novoValor * percentual;
      const formattedValor = novoValor.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
      });
      const valorAdicional = novoValorPercentual.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
      });
      countValorQtdElements.text(`R$ ${formattedValor}`);
      $(".qtd").text(quantidade).val(quantidade);
      $("#percentual-qtd").text(`R$ ${valorAdicional}`);
    }

    function increaseQuantity() {
      let value = parseInt(quantityInput.val());
      const maxQuantity = parseInt(quantityInput.data("quantidade"));
      if (value < maxQuantity) {
        quantityInput.val(value + 1);
        updateValor();
      }
    }

    function decreaseQuantity() {
      let value = parseInt(quantityInput.val());
      if (value > 1) {
        quantityInput.val(value - 1);
        updateValor();
      }
    }

    $("#add-btn").on("click", increaseQuantity);

    $("#subtract-btn").on("click", decreaseQuantity);

    quantityInput.on("input", updateValor);

    updateValor();
  });
});
