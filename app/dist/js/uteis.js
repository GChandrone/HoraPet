/*******************************************
** Reseta os campos das Modais quando fecha*
********************************************/

$(document).ready(function () {
  // Limpar campos ao fechar modais de inclusão
  $('.modal-limpar').on('hidden.bs.modal', function () {
    // Resetar inputs de texto, e-mail, senha, número, data e hora (exceto readonly por padrão)
    $(this).find('input[type="text"]:not([readonly]), input[type="email"]:not([readonly]), input[type="password"]:not([readonly]), input[type="tel"]:not([readonly]), input[type="date"]:not([readonly]), input[type="number"]:not([readonly]), input[type="time"]:not([readonly])').val('');

    // Resetar o campo 'file' visualmente
    const fileInput = $(this).find('input[type="file"]');
    if (fileInput.length) {
      // Remove o nome do arquivo visualmente
      fileInput.val('');
      const label = fileInput.siblings('label');
      if (label) {
        label.text('Nenhum arquivo escolhido');
      }
    }

    // Resetar selects para o primeiro valor
    $(this).find('select').val('');

    // Limpar textareas
    $(this).find('textarea').val('');

    // Remover classes de validação
    $(this).find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
  });

  // Limpar campos (inclusive readonly) ao fechar uma modal específica
  $('.limpar-readonly').on('hidden.bs.modal', function () {
    // Limpar apenas campos do tipo readonly
    $(this).find('input[readonly]').val(''); 

    // Remover classes de validação
    $(this).find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
  });
});

/*************************************
** Substituir Input de Envio na Logo *
**************************************/
var readURL = function(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('.foto-perfil .foto').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(".arquivo").on('change', function(){
  readURL(this);
});

/**************************
** Pegar parâmetro da URL *
***************************/

var lvm_get_parametro = function lvm_get_parametro(sParam) {
  var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
};

/*********************************************************
** Formatar input de telefone no formato (XX) X XXXX-XXXX *
***********************************************************/
document.querySelectorAll('.telefone-formatado').forEach(function(input) {

  // Impede que letras e outros caracteres não numéricos sejam digitados
  input.addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) {
      e.preventDefault();
    }
  });

  // Formatar o input do telefone
  input.addEventListener('input', function() {
    // Remove tudo que não é número
    let value = this.value.replace(/\D/g, '');

    // Limita a 11 dígitos no máximo (DDD + 9 dígitos)
    if (value.length > 11) value = value.slice(0, 11);

    // Aplica a formatação conforme a quantidade de dígitos digitados
    if (value.length > 6) {
      value = `(${value.slice(0, 2)}) ${value.slice(2, 3)} ${value.slice(3, 7)}-${value.slice(7)}`;
    } else if (value.length > 2) {
      value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
    } else if (value.length > 0) {
      value = `(${value}`;
    }

    this.value = value; // Atualiza o campo com o valor formatado
  });

  // Permite apagar hífen, espaço e parênteses
  input.addEventListener('keydown', function(e) {
    if (e.key === "Backspace") {
      const value = this.value;

      // Verifica se o valor contém o hífen ou outros caracteres de formatação
      if (value.endsWith('-')) {
        this.value = value.slice(0, -1); // Remove o hífen
      } else if (value.endsWith(' ')) {
        this.value = value.slice(0, -1); // Remove o espaço
      } else if (value.endsWith(')')) {
        this.value = value.slice(0, -1); // Remove o parêntese final
      } else if (value.endsWith('(')) {
        this.value = value.slice(0, -1); // Remove o parêntese inicial
      }
    }
  });
});

 /********************************************************
 ** Impedir que sejam digitados letras em campos de valor*
 *********************************************************/
 document.querySelectorAll('.valor-real').forEach(function(input) {
  // Impede que letras sejam digitadas
  input.addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) {
      e.preventDefault();
    }
  });
  
 /*******************************************************
 ** Formatar input no padrão de moeda Real (R$ 1.000,00)*
 ********************************************************/
  input.addEventListener('input', function() {
    // Remove tudo que não é número
    let value = this.value.replace(/\D/g, '');
    
    // Converte para moeda, adiciona vírgula para os centavos
    value = (value / 100).toFixed(2).replace('.', ',');
    
    // Adiciona os pontos de milhar
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    // Adiciona o símbolo "R$"
    this.value = 'R$ ' + value;
  });
});
 
/*******************************************************
** Função para mostrar os campos conforme opção de porte*
********************************************************/
// Função para mostrar os campos conforme o porte selecionado
function mostrarCampos(porte, modalId = null) {
  // Determinar o escopo dos campos
  let scope;

  if (modalId) {
    // Se modalId foi passado, buscamos dentro da modal específica
    scope = document.getElementById(modalId);

    if (!scope) {
      console.error('Modal não encontrada:', modalId);
      return;
    }
  } else {
    // Caso seja a modal de inclusão, usamos o documento como escopo global
    scope = document;
  }

  // Esconde todos os campos no escopo
  scope.querySelectorAll('.porte-campos').forEach((campo) => {
    campo.style.display = 'none';
  });

  // Mostra os campos do porte selecionado no escopo
  if (porte === 'pequeno') {
    const pequeno = scope.querySelector('#camposPequeno') || scope.querySelector('#camposPequenoAlterar');
    if (pequeno) pequeno.style.display = 'block';
  } else if (porte === 'medio') {
    const medio = scope.querySelector('#camposMedio') || scope.querySelector('#camposMedioAlterar');
    if (medio) medio.style.display = 'block';
  } else if (porte === 'grande') {
    const grande = scope.querySelector('#camposGrande') || scope.querySelector('#camposGrandeAlterar');
    if (grande) grande.style.display = 'block';
  }
}

// Ao abrir qualquer modal, configure os campos para o porte "pequeno"
document.querySelectorAll('.modal').forEach((modal) => {
  modal.addEventListener('shown.bs.modal', function () {
    const idModal = this.id; // Captura o ID da modal

    // Verifica se a modal é de edição
    const modalEdit = this.querySelector('form').id === 'formAjusteServico';

    // Exibe os campos para o porte "pequeno" ao abrir (se for a modal de edição ou inclusão)
    mostrarCampos('pequeno', idModal);

    // Se for a modal de edição, garante que o rádio de "pequeno" esteja selecionado
    if (modalEdit) {
      const radioPequeno = this.querySelector(`input[name="porte"][id="portePequeno"]`);
      if (radioPequeno && !radioPequeno.checked) {
        radioPequeno.checked = true; // Marca o botão "pequeno" se ainda não estiver marcado
      }
    }
  });
});

// Garantir que o clique nos botões de porte altere os campos corretamente
document.querySelectorAll('.btn-group-toggle .btn').forEach((button) => {
  button.addEventListener('click', function () {
    const porte = this.querySelector('input').id.replace('porte', '').toLowerCase(); // Obtém o valor de 'pequeno', 'medio', 'grande'
    const modalId = this.closest('.modal').id; // Pega o id da modal onde o botão foi clicado
    mostrarCampos(porte, modalId); // Exibe os campos do porte selecionado
  });
});

 // Função de validação de campos
function validarCampos(servicoId = '') {
  let erro = false;

  // Prefixo para edição (se não estiver em edição, o prefixo será vazio)
  const prefixo = servicoId ? 'Alterar' + servicoId : '';

  // Obtém os valores dos campos com o prefixo para edição ou sem prefixo para inclusão
  const valorPequeno = document.getElementById('valorPequeno' + prefixo)?.value.trim();
  const duracaoPequeno = document.getElementById('duracaoPequeno' + prefixo)?.value.trim();
  const valorMedio = document.getElementById('valorMedio' + prefixo)?.value.trim();
  const duracaoMedio = document.getElementById('duracaoMedio' + prefixo)?.value.trim();
  const valorGrande = document.getElementById('valorGrande' + prefixo)?.value.trim();
  const duracaoGrande = document.getElementById('duracaoGrande' + prefixo)?.value.trim();

  // Verifica se algum dos campos necessários está vazio
  if (!valorPequeno || !duracaoPequeno || !valorMedio || !duracaoMedio || !valorGrande || !duracaoGrande) {
    erro = true;
    Swal.fire({
      type: 'warning',
      title: 'Configuração incompleta',
      text: 'Por favor, preencha todos os campos corretamente.',
    });
  }

  return !erro; // Retorna true se não houver erro
}


// Validação no envio do formulário para criação de novo serviço
$(document).on('submit', '#formNovoServico', function (event) {
  // Chama a função de validação personalizada
  if (!validarCampos()) {
    event.preventDefault(); // Impede o envio se a validação falhar
  }
});


// Validação no envio do formulário para ajuste de serviço
document.querySelectorAll('[id^="formAjusteServico"]').forEach((form) => {
  form.addEventListener('submit', function (event) {
    const servicoId = form.getAttribute('data-servico-id'); // Obtém o ID do serviço para edição

    // Verifica a validação padrão do formulário
    if (!form.checkValidity()) {
      form.reportValidity(); // Mostra mensagens nativas do navegador
      event.preventDefault(); // Impede o envio se a validação do HTML não passar
      return;
    }

    // Aplica a validação personalizada para a edição
    if (!validarCampos(servicoId)) {
      event.preventDefault(); // Impede o envio se a validação personalizada falhar
    }
  });
});

/**********************************************************************************************
** Função para atualizar o campo Porte automaticamente, conforme o peso, altura e o tipo do pet*
***********************************************************************************************/
function atualizarPorte() {
  // Seleciona todos os campos de altura, peso e tipo do pet
  const alturas = document.querySelectorAll('[id^="iAltura"]');
  const pesos = document.querySelectorAll('[id^="iPeso"]');
  const tipos = document.querySelectorAll('[id^="iTipoPet"]'); // Campo de seleção do tipo do pet
  
  // Itera sobre todos os campos de altura, peso e tipo do pet
  for (let i = 0; i < alturas.length; i++) {
    const altura  = parseFloat(alturas[i].value) || 0; // Pega o valor de altura
    const peso    = parseFloat(pesos[i].value) || 0;     // Pega o valor de peso
    const tipoPet = parseInt(tipos[i].value) || 1;    // Pega o valor do tipo do pet (1 = Cachorro, 2 = Gato)
    
    let porte = ''; // Inicializa o porte como vazio
    const pontuacao = (peso * 1.5) + (altura * 1); // Pontuação ponderada entre peso e altura

    // Lógica de classificação baseada no tipo do pet
    if (tipoPet == 1) { 
      // Classificação para Cachorros
      if (pontuacao <= 55) {
        porte = 'Pequeno';
      } else if (pontuacao > 55 && pontuacao <= 87) {
        porte = 'Médio';
      } else {
        porte = 'Grande';
      }
    } else if (tipoPet == 2) {
      // Classificação para Gatos
      if (pontuacao <= 37) {
        porte = 'Pequeno';
      } else if (pontuacao > 37 && pontuacao <= 55) {
        porte = 'Médio';
      } else {
        porte = 'Grande';
      }
    }

    // Atualiza todos os campos de porte (inclusão e edição)
    const portes = document.querySelectorAll('[id^="iPorte"]');
    if (portes[i]) {
      portes[i].value = porte; // Define o porte no campo correspondente
    }
  }
}

// Adiciona eventos de mudança para os campos de altura, peso e tipo do pet
document.querySelectorAll('[id^="iAltura"]').forEach(function(alturaField) {
  alturaField.addEventListener('input', atualizarPorte);
});

document.querySelectorAll('[id^="iPeso"]').forEach(function(pesoField) {
  pesoField.addEventListener('input', atualizarPorte);
});

document.querySelectorAll('[id^="iTipoPet"]').forEach(function(tipoField) {
  tipoField.addEventListener('change', atualizarPorte);
});


/***************************************************************
** Lista dinâmica com Ajax para carregar as Raça conforme o pet*
****************************************************************/
$(document).on('change', '.tipoPetAjax', function () {
  carregarRacas($(this)); // Aciona a função AJAX ao mudar o valor
});

// Função para carregar raças dinamicamente
function carregarRacas(tipoPetElement) {
    const modal = tipoPetElement.closest('.modal'); // Obtém o modal atual
    const tipoPet = tipoPetElement.val(); // Pega o tipo do pet selecionado
    let optionRaca = ''; // Inicializa a lista de raças

    // Verifica se o tipo de pet foi selecionado
    if (tipoPet !== "" && tipoPet !== "0") {
        $.getJSON('php/carregaRaca.php?tipo=' + tipoPet, function (dados) {
            optionRaca = '<option value="">Selecione...</option>'; // Primeira opção

            const racaAtual = modal.find('.racaAjax').val(); // Raça atualmente selecionada

            if (dados.length > 0) {
                // Se dados de raças forem retornados
                $.each(dados, function (i, obj) {
                    const selected = obj.id_raca == racaAtual ? 'selected' : '';
                    optionRaca += '<option value="' + obj.id_raca + '" ' + selected + '>' + obj.nome + '</option>';
                });
            }

            // Atualiza o campo de raças
            modal.find('.racaAjax').attr('required', 'required').html(optionRaca).show();
        });
    } else {
        // Se tipo de pet não for selecionado, reseta as raças
        optionRaca += '<option value="">Selecione...</option>';
        modal.find('.racaAjax').html(optionRaca).show();
    }
}

// Ao abrir a modal de edição, se Tipo Pet já estiver selecionado, carrega as raças
$(document).on('show.bs.modal', '.modal', function () {
    const modal = $(this);
    const tipoPetElement = modal.find('.tipoPetAjax');

    // Se Tipo Pet está selecionado, carrega as raças
    if (tipoPetElement.val() !== "" && tipoPetElement.val() !== "0") {
        carregarRacas(tipoPetElement);
    }
});


/******************************************************************
** Lista dinâmica com Ajax para carregar somente os pets dos donos*
*******************************************************************/
$(document).on('change', '.clienteAjax', function () {
  carregarPets($(this));
});

// Função para carregar pets dinamicamente
function carregarPets(clienteElement) {
  const cliente = clienteElement.val(); // Valor do cliente selecionado
  const petAtual = $('#iPet').val(); // Valor do pet selecionado

  // Apenas atualiza os pets se o cliente for válido
  if (cliente !== "" && cliente !== "0") {
    $.getJSON('php/carregaPet.php?idCliente=' + cliente, function (dados) {
      let optionPet = '<option value="">Selecione...</option>'; // Primeira opção padrão

      // Verifica se há pets retornados pelo PHP
      if (dados.length > 0) {
        $.each(dados, function (i, obj) {
          const selected = obj.id_pet == petAtual ? 'selected' : '';
          optionPet += `<option value="${obj.id_pet}" ${selected}>${obj.nome}</option>`;
        });
      }

      // Atualiza o campo de pets apenas se não houver um pet já definido
      if (!petAtual || !dados.some(obj => obj.id_pet == petAtual)) {
        $('#iPet').html(optionPet).attr('required', 'required').show();
      }
    });
  } else {
    // Se não há cliente selecionado e o pet não está definido, reseta a lista
    if (!petAtual) {
      $('#iPet').html('<option value="">Selecione...</option>').show();
    }
  }
}

// No carregamento da página, garante que o pet atual não seja sobrescrito
$(document).ready(function () {
  const clienteElement = $('#iCliente');

  if (clienteElement.val() !== "" && clienteElement.val() !== "0") {
    carregarPets(clienteElement);
  }
});

/**************************
****** jQuery Mask JS *****
***************************/
var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.findInternal=function(a,n,f){a instanceof String&&(a=String(a));for(var p=a.length,k=0;k<p;k++){var b=a[k];if(n.call(f,b,k,a))return{i:k,v:b}}return{i:-1,v:void 0}};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;$jscomp.defineProperty=$jscomp.ASSUME_ES5||"function"==typeof Object.defineProperties?Object.defineProperty:function(a,n,f){a!=Array.prototype&&a!=Object.prototype&&(a[n]=f.value)};$jscomp.getGlobal=function(a){return"undefined"!=typeof window&&window===a?a:"undefined"!=typeof global&&null!=global?global:a};$jscomp.global=$jscomp.getGlobal(this);$jscomp.polyfill=function(a,n,f,p){if(n){f=$jscomp.global;a=a.split(".");for(p=0;p<a.length-1;p++){var k=a[p];k in f||(f[k]={});f=f[k]}a=a[a.length-1];p=f[a];n=n(p);n!=p&&null!=n&&$jscomp.defineProperty(f,a,{configurable:!0,writable:!0,value:n})}};$jscomp.polyfill("Array.prototype.find",function(a){return a?a:function(a,f){return $jscomp.findInternal(this,a,f).v}},"es6","es3");(function(a,n,f){"function"===typeof define&&define.amd?define(["jquery"],a):"object"===typeof exports&&"undefined"===typeof Meteor?module.exports=a(require("jquery")):a(n||f)})(function(a){var n=function(b,d,e){var c={invalid:[],getCaret:function(){try{var a=0,r=b.get(0),h=document.selection,d=r.selectionStart;if(h&&-1===navigator.appVersion.indexOf("MSIE 10")){var e=h.createRange();e.moveStart("character",-c.val().length);a=e.text.length}else if(d||"0"===d)a=d;return a}catch(C){}},setCaret:function(a){try{if(b.is(":focus")){var c=b.get(0);if(c.setSelectionRange)c.setSelectionRange(a,a);else{var g=c.createTextRange();g.collapse(!0);g.moveEnd("character",a);g.moveStart("character",a);g.select()}}}catch(B){}},events:function(){b.on("keydown.mask",function(a){b.data("mask-keycode",a.keyCode||a.which);b.data("mask-previus-value",b.val());b.data("mask-previus-caret-pos",c.getCaret());c.maskDigitPosMapOld=c.maskDigitPosMap}).on(a.jMaskGlobals.useInput?"input.mask":"keyup.mask",c.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){b.keydown().keyup()},100)}).on("change.mask",function(){b.data("changed",!0)}).on("blur.mask",function(){f===c.val()||b.data("changed")||b.trigger("change");b.data("changed",!1)}).on("blur.mask",function(){f=c.val()}).on("focus.mask",function(b){!0===e.selectOnFocus&&a(b.target).select()}).on("focusout.mask",function(){e.clearIfNotMatch&&!k.test(c.val())&&c.val("")})},getRegexMask:function(){for(var a=[],b,c,e,t,f=0;f<d.length;f++)(b=l.translation[d.charAt(f)])?(c=b.pattern.toString().replace(/.{1}$|^.{1}/g,""),e=b.optional,(b=b.recursive)?(a.push(d.charAt(f)),t={digit:d.charAt(f),pattern:c}):a.push(e||b?c+"?":c)):a.push(d.charAt(f).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));a=a.join("");t&&(a=a.replace(new RegExp("("+t.digit+"(.*"+t.digit+")?)"),"($1)?").replace(new RegExp(t.digit,"g"),t.pattern));return new RegExp(a)},destroyEvents:function(){b.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(a){var c=b.is("input")?"val":"text";if(0<arguments.length){if(b[c]()!==a)b[c](a);c=b}else c=b[c]();return c},calculateCaretPosition:function(a){var d=c.getMasked(),h=c.getCaret();if(a!==d){var e=b.data("mask-previus-caret-pos")||0;d=d.length;var g=a.length,f=a=0,l=0,k=0,m;for(m=h;m<d&&c.maskDigitPosMap[m];m++)f++;for(m=h-1;0<=m&&c.maskDigitPosMap[m];m--)a++;for(m=h-1;0<=m;m--)c.maskDigitPosMap[m]&&l++;for(m=e-1;0<=m;m--)c.maskDigitPosMapOld[m]&&k++;h>g?h=10*d:e>=h&&e!==g?c.maskDigitPosMapOld[h]||(e=h,h=h-(k-l)-a,c.maskDigitPosMap[h]&&(h=e)):h>e&&(h=h+(l-k)+f)}return h},behaviour:function(d){d=d||window.event;c.invalid=[];var e=b.data("mask-keycode");if(-1===a.inArray(e,l.byPassKeys)){e=c.getMasked();var h=c.getCaret(),g=b.data("mask-previus-value")||"";setTimeout(function(){c.setCaret(c.calculateCaretPosition(g))},a.jMaskGlobals.keyStrokeCompensation);c.val(e);c.setCaret(h);return c.callbacks(d)}},getMasked:function(a,b){var h=[],f=void 0===b?c.val():b+"",g=0,k=d.length,n=0,p=f.length,m=1,r="push",u=-1,w=0;b=[];if(e.reverse){r="unshift";m=-1;var x=0;g=k-1;n=p-1;var A=function(){return-1<g&&-1<n}}else x=k-1,A=function(){return g<k&&n<p};for(var z;A();){var y=d.charAt(g),v=f.charAt(n),q=l.translation[y];if(q)v.match(q.pattern)?(h[r](v),q.recursive&&(-1===u?u=g:g===x&&g!==u&&(g=u-m),x===u&&(g-=m)),g+=m):v===z?(w--,z=void 0):q.optional?(g+=m,n-=m):q.fallback?(h[r](q.fallback),g+=m,n-=m):c.invalid.push({p:n,v:v,e:q.pattern}),n+=m;else{if(!a)h[r](y);v===y?(b.push(n),n+=m):(z=y,b.push(n+w),w++);g+=m}}a=d.charAt(x);k!==p+1||l.translation[a]||h.push(a);h=h.join("");c.mapMaskdigitPositions(h,b,p);return h},mapMaskdigitPositions:function(a,b,d){a=e.reverse?a.length-d:0;c.maskDigitPosMap={};for(d=0;d<b.length;d++)c.maskDigitPosMap[b[d]+a]=1},callbacks:function(a){var g=c.val(),h=g!==f,k=[g,a,b,e],l=function(a,b,c){"function"===typeof e[a]&&b&&e[a].apply(this,c)};l("onChange",!0===h,k);l("onKeyPress",!0===h,k);l("onComplete",g.length===d.length,k);l("onInvalid",0<c.invalid.length,[g,a,b,c.invalid,e])}};b=a(b);var l=this,f=c.val(),k;d="function"===typeof d?d(c.val(),void 0,b,e):d;l.mask=d;l.options=e;l.remove=function(){var a=c.getCaret();l.options.placeholder&&b.removeAttr("placeholder");b.data("mask-maxlength")&&b.removeAttr("maxlength");c.destroyEvents();c.val(l.getCleanVal());c.setCaret(a);return b};l.getCleanVal=function(){return c.getMasked(!0)};l.getMaskedVal=function(a){return c.getMasked(!1,a)};l.init=function(g){g=g||!1;e=e||{};l.clearIfNotMatch=a.jMaskGlobals.clearIfNotMatch;l.byPassKeys=a.jMaskGlobals.byPassKeys;l.translation=a.extend({},a.jMaskGlobals.translation,e.translation);l=a.extend(!0,{},l,e);k=c.getRegexMask();if(g)c.events(),c.val(c.getMasked());else{e.placeholder&&b.attr("placeholder",e.placeholder);b.data("mask")&&b.attr("autocomplete","off");g=0;for(var f=!0;g<d.length;g++){var h=l.translation[d.charAt(g)];if(h&&h.recursive){f=!1;break}}f&&b.attr("maxlength",d.length).data("mask-maxlength",!0);c.destroyEvents();c.events();g=c.getCaret();c.val(c.getMasked());c.setCaret(g)}};l.init(!b.is("input"))};a.maskWatchers={};var f=function(){var b=a(this),d={},e=b.attr("data-mask");b.attr("data-mask-reverse")&&(d.reverse=!0);b.attr("data-mask-clearifnotmatch")&&(d.clearIfNotMatch=!0);"true"===b.attr("data-mask-selectonfocus")&&(d.selectOnFocus=!0);if(p(b,e,d))return b.data("mask",new n(this,e,d))},p=function(b,d,e){e=e||{};var c=a(b).data("mask"),f=JSON.stringify;b=a(b).val()||a(b).text();try{return"function"===typeof d&&(d=d(b)),"object"!==typeof c||f(c.options)!==f(e)||c.mask!==d}catch(w){}},k=function(a){var b=document.createElement("div");a="on"+a;var e=a in b;e||(b.setAttribute(a,"return;"),e="function"===typeof b[a]);return e};a.fn.mask=function(b,d){d=d||{};var e=this.selector,c=a.jMaskGlobals,f=c.watchInterval;c=d.watchInputs||c.watchInputs;var k=function(){if(p(this,b,d))return a(this).data("mask",new n(this,b,d))};a(this).each(k);e&&""!==e&&c&&(clearInterval(a.maskWatchers[e]),a.maskWatchers[e]=setInterval(function(){a(document).find(e).each(k)},f));return this};a.fn.masked=function(a){return this.data("mask").getMaskedVal(a)};a.fn.unmask=function(){clearInterval(a.maskWatchers[this.selector]);delete a.maskWatchers[this.selector];return this.each(function(){var b=a(this).data("mask");b&&b.remove().removeData("mask")})};a.fn.cleanVal=function(){return this.data("mask").getCleanVal()};a.applyDataMask=function(b){b=b||a.jMaskGlobals.maskElements;(b instanceof a?b:a(b)).filter(a.jMaskGlobals.dataMaskAttr).each(f)};k={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,keyStrokeCompensation:10,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&k("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}};a.jMaskGlobals=a.jMaskGlobals||{};k=a.jMaskGlobals=a.extend(!0,{},k,a.jMaskGlobals);k.dataMask&&a.applyDataMask();setInterval(function(){a.jMaskGlobals.watchDataMask&&a.applyDataMask()},k.watchInterval)},window.jQuery,window.Zepto);
var nonoDigito = function (val) {  return val.replace(/\D/g, '').length === 11 ? '(00) 0 0000-0000' : '(00) 0000-00009';
},spOptions = {
  onKeyPress: function(val, e, field, options) {
    field.mask(nonoDigito.apply({}, arguments), options);
  }
};

$('.cpf').mask('000.000.000-00');
$('.cnpj').mask('00.000.000/0000-00');
$('.cep').mask('00000-000');
$('.telefone').mask('(00) 0000-0000');
$('.celular').mask(nonoDigito, spOptions);

/**************************
**** Max Lenght Inout *****
***************************/
(function(){var j=false;window.JQClass=function(){};JQClass.classes={};JQClass.extend=function extender(f){var g=this.prototype;j=true;var h=new this();j=false;for(var i in f){h[i]=typeof f[i]=='function'&&typeof g[i]=='function'?(function(d,e){return function(){var b=this._super;this._super=function(a){return g[d].apply(this,a||[])};var c=e.apply(this,arguments);this._super=b;return c}})(i,f[i]):f[i]}function JQClass(){if(!j&&this._init){this._init.apply(this,arguments)}}JQClass.prototype=h;JQClass.prototype.constructor=JQClass;JQClass.extend=extender;return JQClass}})();(function($){JQClass.classes.JQPlugin=JQClass.extend({name:'plugin',defaultOptions:{},regionalOptions:{},_getters:[],_getMarker:function(){return'is-'+this.name},_init:function(){$.extend(this.defaultOptions,(this.regionalOptions&&this.regionalOptions[''])||{});var c=camelCase(this.name);$[c]=this;$.fn[c]=function(a){var b=Array.prototype.slice.call(arguments,1);if($[c]._isNotChained(a,b)){return $[c][a].apply($[c],[this[0]].concat(b))}return this.each(function(){if(typeof a==='string'){if(a[0]==='_'||!$[c][a]){throw'Unknown method: '+a;}$[c][a].apply($[c],[this].concat(b))}else{$[c]._attach(this,a)}})}},setDefaults:function(a){$.extend(this.defaultOptions,a||{})},_isNotChained:function(a,b){if(a==='option'&&(b.length===0||(b.length===1&&typeof b[0]==='string'))){return true}return $.inArray(a,this._getters)>-1},_attach:function(a,b){a=$(a);if(a.hasClass(this._getMarker())){return}a.addClass(this._getMarker());b=$.extend({},this.defaultOptions,this._getMetadata(a),b||{});var c=$.extend({name:this.name,elem:a,options:b},this._instSettings(a,b));a.data(this.name,c);this._postAttach(a,c);this.option(a,b)},_instSettings:function(a,b){return{}},_postAttach:function(a,b){},_getMetadata:function(d){try{var f=d.data(this.name.toLowerCase())||'';f=f.replace(/'/g,'"');f=f.replace(/([a-zA-Z0-9]+):/g,function(a,b,i){var c=f.substring(0,i).match(/"/g);return(!c||c.length%2===0?'"'+b+'":':b+':')});f=$.parseJSON('{'+f+'}');for(var g in f){var h=f[g];if(typeof h==='string'&&h.match(/^new Date\((.*)\)$/)){f[g]=eval(h)}}return f}catch(e){return{}}},_getInst:function(a){return $(a).data(this.name)||{}},option:function(a,b,c){a=$(a);var d=a.data(this.name);if(!b||(typeof b==='string'&&c==null)){var e=(d||{}).options;return(e&&b?e[b]:e)}if(!a.hasClass(this._getMarker())){return}var e=b||{};if(typeof b==='string'){e={};e[b]=c}this._optionsChanged(a,d,e);$.extend(d.options,e)},_optionsChanged:function(a,b,c){},destroy:function(a){a=$(a);if(!a.hasClass(this._getMarker())){return}this._preDestroy(a,this._getInst(a));a.removeData(this.name).removeClass(this._getMarker())},_preDestroy:function(a,b){}});function camelCase(c){return c.replace(/-([a-z])/g,function(a,b){return b.toUpperCase()})}$.JQPlugin={createPlugin:function(a,b){if(typeof a==='object'){b=a;a='JQPlugin'}a=camelCase(a);var c=camelCase(b.name);JQClass.classes[c]=JQClass.classes[a].extend(b);new JQClass.classes[c]()}}})(jQuery);
(function($){var h='maxlength';$.JQPlugin.createPlugin({name:h,defaultOptions:{max:200,truncate:true,showFeedback:true,feedbackTarget:null,onFull:null},regionalOptions:{'':{feedbackText:'{r}/{m}',overflowText:'{o} characters too many ({m} maximum)'}},_getters:['curLength'],_feedbackClass:h+'-feedback',_fullClass:h+'-full',_overflowClass:h+'-overflow',_disabledClass:h+'-disabled',_instSettings:function(a,b){return{feedbackTarget:$([])}},_postAttach:function(c,d){c.on('keypress.'+d.name,function(a){if(!d.options.truncate){return true}var b=String.fromCharCode(a.charCode==undefined?a.keyCode:a.charCode);return(a.ctrlKey||a.metaKey||b=='\u0000'||$(this).val().length<d.options.max)}).on('keyup.'+d.name+' paste.'+d.name+' cut.'+d.name,function(e){if(e.type==='keyup'){$.maxlength._checkLength(c)}else{setTimeout(function(){$.maxlength._checkLength(c)},1)}})},_optionsChanged:function(a,b,c){$.extend(b.options,c);if(b.feedbackTarget.length>0){if(b.hadFeedbackTarget){b.feedbackTarget.empty().val('').removeClass(this._feedbackClass+' '+this._fullClass+' '+this._overflowClass)}else{b.feedbackTarget.remove()}b.feedbackTarget=$([])}if(b.options.showFeedback){b.hadFeedbackTarget=!!b.options.feedbackTarget;if($.isFunction(b.options.feedbackTarget)){b.feedbackTarget=b.options.feedbackTarget.apply(a[0],[])}else if(b.options.feedbackTarget){b.feedbackTarget=$(b.options.feedbackTarget)}else{b.feedbackTarget=$('<span></span>').insertAfter(a)}b.feedbackTarget.addClass(this._feedbackClass)}a.off('mouseover.'+b.name+' focus.'+b.name+'mouseout.'+b.name+' blur.'+b.name);if(b.options.showFeedback=='active'){a.on('mouseover.'+b.name,function(){b.feedbackTarget.css('visibility','visible')}).on('mouseout.'+b.name,function(){if(!b.focussed){b.feedbackTarget.css('visibility','hidden')}}).on('focus.'+b.name,function(){b.focussed=true;b.feedbackTarget.css('visibility','visible')}).on('blur.'+b.name,function(){b.focussed=false;b.feedbackTarget.css('visibility','hidden')});b.feedbackTarget.css('visibility','hidden')}this._checkLength(a)},curLength:function(a){var b=this._getInst(a);var c=a.val();var d=c.replace(/\r\n/g,'~~').replace(/\n/g,'~~').length;return{used:d,remaining:b.options.max-d}},_checkLength:function(a){var b=this._getInst(a);var c=a.val();var d=c.replace(/\r\n/g,'~~').replace(/\n/g,'~~').length;a.toggleClass(this._fullClass,d>=b.options.max).toggleClass(this._overflowClass,d>b.options.max);if(d>b.options.max&&b.options.truncate){var f=a.val().split(/\r\n|\n/);c='';var i=0;while(c.length<b.options.max&&i<f.length){c+=f[i].substring(0,b.options.max-c.length)+'\r\n';i++}a.val(c.substring(0,b.options.max));a[0].scrollTop=a[0].scrollHeight;d=b.options.max}b.feedbackTarget.toggleClass(this._fullClass,d>=b.options.max).toggleClass(this._overflowClass,d>b.options.max);var g=(d>b.options.max?b.options.overflowText:b.options.feedbackText).replace(/\{c\}/,d).replace(/\{m\}/,b.options.max).replace(/\{r\}/,b.options.max-d).replace(/\{o\}/,d-b.options.max);try{b.feedbackTarget.text(g)}catch(e){}try{b.feedbackTarget.val(g)}catch(e){}if(d>=b.options.max&&$.isFunction(b.options.onFull)){b.options.onFull.apply(a,[d>b.options.max])}},enable:function(a){a=$(a);if(!a.hasClass(this._getMarker())){return}var b=this._getInst(a);a.prop('disabled',false).removeClass(b.name+'-disabled');b.feedbackTarget.removeClass(b.name+'-disabled')},disable:function(a){a=$(a);if(!a.hasClass(this._getMarker())){return}var b=this._getInst(a);a.prop('disabled',true).addClass(b.name+'-disabled');b.feedbackTarget.addClass(b.name+'-disabled')},_preDestroy:function(a,b){if(b.feedbackTarget.length>0){if(b.hadFeedbackTarget){b.feedbackTarget.empty().val('').css('visibility','visible').removeClass(this._feedbackClass+' '+this._fullClass+' '+this._overflowClass)}else{b.feedbackTarget.remove()}}a.removeClass(this._fullClass+' '+this._overflowClass).off('.'+b.name)}})})(jQuery);

$('textarea[maxlength="200"]').maxlength({max: 200});
$('textarea[maxlength="100"]').maxlength({max: 100});

/**************************
****** Sweet Alert JS *****
***************************/
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.Sweetalert2=e()}(this,function(){"use strict";function r(t){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function i(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}function a(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t}function s(){return(s=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t}).apply(this,arguments)}function u(t){return(u=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function c(t,e){return(c=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function l(t,e,n){return(l=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],function(){})),!0}catch(t){return!1}}()?Reflect.construct:function(t,e,n){var o=[null];o.push.apply(o,e);var i=new(Function.bind.apply(t,o));return n&&c(i,n.prototype),i}).apply(null,arguments)}function d(t,e){return!e||"object"!=typeof e&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function p(t,e,n){return(p="undefined"!=typeof Reflect&&Reflect.get?Reflect.get:function(t,e,n){var o=function(t,e){for(;!Object.prototype.hasOwnProperty.call(t,e)&&null!==(t=u(t)););return t}(t,e);if(o){var i=Object.getOwnPropertyDescriptor(o,e);return i.get?i.get.call(n):i.value}})(t,e,n||t)}function f(e){return Object.keys(e).map(function(t){return e[t]})}function m(t){return Array.prototype.slice.call(t)}function g(t){console.error("".concat(e," ").concat(t))}function h(t,e){!function(t){-1===n.indexOf(t)&&(n.push(t),w(t))}('"'.concat(t,'" is deprecated and will be removed in the next major release. Please use "').concat(e,'" instead.'))}function v(t){return t&&Promise.resolve(t)===t}function t(t){var e={};for(var n in t)e[t[n]]="swal2-"+t[n];return e}function b(t,e){return t.classList.contains(e)}function y(e,t,n){m(e.classList).forEach(function(t){-1===f(x).indexOf(t)&&-1===f(S).indexOf(t)&&e.classList.remove(t)}),t&&t[n]&&rt(e,t[n])}var e="SweetAlert2:",w=function(t){console.warn("".concat(e," ").concat(t))},n=[],C=function(t){return"function"==typeof t?t():t},k=Object.freeze({cancel:"cancel",backdrop:"backdrop",close:"close",esc:"esc",timer:"timer"}),x=t(["container","shown","height-auto","iosfix","popup","modal","no-backdrop","toast","toast-shown","toast-column","fade","show","hide","noanimation","close","title","header","content","actions","confirm","cancel","footer","icon","image","input","file","range","select","radio","checkbox","label","textarea","inputerror","validation-message","progress-steps","active-progress-step","progress-step","progress-step-line","loading","styled","top","top-start","top-end","top-left","top-right","center","center-start","center-end","center-left","center-right","bottom","bottom-start","bottom-end","bottom-left","bottom-right","grow-row","grow-column","grow-fullscreen","rtl"]),S=t(["success","warning","info","question","error"]),P={previousBodyPadding:null};function B(t,e){if(!e)return null;switch(e){case"select":case"textarea":case"file":return st(t,x[e]);case"checkbox":return t.querySelector(".".concat(x.checkbox," input"));case"radio":return t.querySelector(".".concat(x.radio," input:checked"))||t.querySelector(".".concat(x.radio," input:first-child"));case"range":return t.querySelector(".".concat(x.range," input"));default:return st(t,x.input)}}function A(t){if(t.focus(),"file"!==t.type){var e=t.value;t.value="",t.value=e}}function E(t,e,n){t&&e&&("string"==typeof e&&(e=e.split(/\s+/).filter(Boolean)),e.forEach(function(e){t.forEach?t.forEach(function(t){n?t.classList.add(e):t.classList.remove(e)}):n?t.classList.add(e):t.classList.remove(e)}))}function T(t,e,n){n||0===parseInt(n)?t.style[e]="number"==typeof n?n+"px":n:t.style.removeProperty(e)}function L(t,e){var n=1<arguments.length&&void 0!==e?e:"flex";t.style.opacity="",t.style.display=n}function O(t){t.style.opacity="",t.style.display="none"}function M(t,e,n){e?L(t,n):O(t)}function V(t){return!(!t||!(t.offsetWidth||t.offsetHeight||t.getClientRects().length))}function H(t){var e=window.getComputedStyle(t),n=parseFloat(e.getPropertyValue("animation-duration")||"0"),o=parseFloat(e.getPropertyValue("transition-duration")||"0");return 0<n||0<o}function j(){return document.body.querySelector("."+x.container)}function I(t){var e=j();return e?e.querySelector(t):null}function q(t){return I("."+t)}function R(){return q(x.popup)}function D(){var t=R();return m(t.querySelectorAll("."+x.icon))}function N(){var t=D().filter(function(t){return V(t)});return t.length?t[0]:null}function U(){return q(x.title)}function F(){return q(x.content)}function _(){return q(x.image)}function z(){return q(x["progress-steps"])}function W(){return q(x["validation-message"])}function K(){return I("."+x.actions+" ."+x.confirm)}function Z(){return I("."+x.actions+" ."+x.cancel)}function Q(){return q(x.actions)}function Y(){return q(x.header)}function $(){return q(x.footer)}function J(){return q(x.close)}function X(){var t=m(R().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function(t,e){return t=parseInt(t.getAttribute("tabindex")),(e=parseInt(e.getAttribute("tabindex")))<t?1:t<e?-1:0}),e=m(R().querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex="0"], [contenteditable], audio[controls], video[controls]')).filter(function(t){return"-1"!==t.getAttribute("tabindex")});return function(t){for(var e=[],n=0;n<t.length;n++)-1===e.indexOf(t[n])&&e.push(t[n]);return e}(t.concat(e)).filter(function(t){return V(t)})}function G(){return!ut()&&!document.body.classList.contains(x["no-backdrop"])}function tt(){return"undefined"==typeof window||"undefined"==typeof document}function et(t){Fe.isVisible()&&it!==t.target.value&&Fe.resetValidationMessage(),it=t.target.value}function nt(t,e){t instanceof HTMLElement?e.appendChild(t):"object"===r(t)?dt(e,t):t&&(e.innerHTML=t)}function ot(t,e){var n=Q(),o=K(),i=Z();e.showConfirmButton||e.showCancelButton||O(n),y(n,e.customClass,"actions"),ft(o,"confirm",e),ft(i,"cancel",e),e.buttonsStyling?function(t,e,n){rt([t,e],x.styled),n.confirmButtonColor&&(t.style.backgroundColor=n.confirmButtonColor);n.cancelButtonColor&&(e.style.backgroundColor=n.cancelButtonColor);var o=window.getComputedStyle(t).getPropertyValue("background-color");t.style.borderLeftColor=o,t.style.borderRightColor=o}(o,i,e):(at([o,i],x.styled),o.style.backgroundColor=o.style.borderLeftColor=o.style.borderRightColor="",i.style.backgroundColor=i.style.borderLeftColor=i.style.borderRightColor=""),e.reverseButtons&&o.parentNode.insertBefore(i,o)}var it,rt=function(t,e){E(t,e,!0)},at=function(t,e){E(t,e,!1)},st=function(t,e){for(var n=0;n<t.childNodes.length;n++)if(b(t.childNodes[n],e))return t.childNodes[n]},ut=function(){return document.body.classList.contains(x["toast-shown"])},ct='\n <div aria-labelledby="'.concat(x.title,'" aria-describedby="').concat(x.content,'" class="').concat(x.popup,'" tabindex="-1">\n   <div class="').concat(x.header,'">\n     <ul class="').concat(x["progress-steps"],'"></ul>\n     <div class="').concat(x.icon," ").concat(S.error,'">\n       <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span>\n     </div>\n     <div class="').concat(x.icon," ").concat(S.question,'"></div>\n     <div class="').concat(x.icon," ").concat(S.warning,'"></div>\n     <div class="').concat(x.icon," ").concat(S.info,'"></div>\n     <div class="').concat(x.icon," ").concat(S.success,'">\n       <div class="swal2-success-circular-line-left"></div>\n       <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n       <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n       <div class="swal2-success-circular-line-right"></div>\n     </div>\n     <img class="').concat(x.image,'" />\n     <h2 class="').concat(x.title,'" id="').concat(x.title,'"></h2>\n     <button type="button" class="').concat(x.close,'"></button>\n   </div>\n   <div class="').concat(x.content,'">\n     <div id="').concat(x.content,'"></div>\n     <input class="').concat(x.input,'" />\n     <input type="file" class="').concat(x.file,'" />\n     <div class="').concat(x.range,'">\n       <input type="range" />\n       <output></output>\n     </div>\n     <select class="').concat(x.select,'"></select>\n     <div class="').concat(x.radio,'"></div>\n     <label for="').concat(x.checkbox,'" class="').concat(x.checkbox,'">\n       <input type="checkbox" />\n       <span class="').concat(x.label,'"></span>\n     </label>\n     <textarea class="').concat(x.textarea,'"></textarea>\n     <div class="').concat(x["validation-message"],'" id="').concat(x["validation-message"],'"></div>\n   </div>\n   <div class="').concat(x.actions,'">\n     <button type="button" class="').concat(x.confirm,'">OK</button>\n     <button type="button" class="').concat(x.cancel,'">Cancel</button>\n   </div>\n   <div class="').concat(x.footer,'">\n   </div>\n </div>\n').replace(/(^|\n)\s*/g,""),lt=function(t){if(function(){var t=j();t&&(t.parentNode.removeChild(t),at([document.documentElement,document.body],[x["no-backdrop"],x["toast-shown"],x["has-column"]]))}(),tt())g("SweetAlert2 requires document to initialize");else{var e=document.createElement("div");e.className=x.container,e.innerHTML=ct;var n=function(t){return"string"==typeof t?document.querySelector(t):t}(t.target);n.appendChild(e),function(t){var e=R();e.setAttribute("role",t.toast?"alert":"dialog"),e.setAttribute("aria-live",t.toast?"polite":"assertive"),t.toast||e.setAttribute("aria-modal","true")}(t),function(t){"rtl"===window.getComputedStyle(t).direction&&rt(j(),x.rtl)}(n),function(){var t=F(),e=st(t,x.input),n=st(t,x.file),o=t.querySelector(".".concat(x.range," input")),i=t.querySelector(".".concat(x.range," output")),r=st(t,x.select),a=t.querySelector(".".concat(x.checkbox," input")),s=st(t,x.textarea);e.oninput=et,n.onchange=et,r.onchange=et,a.onchange=et,s.oninput=et,o.oninput=function(t){et(t),i.value=o.value},o.onchange=function(t){et(t),o.nextSibling.value=o.value}}()}},dt=function(t,e){if(t.innerHTML="",0 in e)for(var n=0;n in e;n++)t.appendChild(e[n].cloneNode(!0));else t.appendChild(e.cloneNode(!0))},pt=function(){if(tt())return!1;var t=document.createElement("div"),e={WebkitAnimation:"webkitAnimationEnd",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(var n in e)if(Object.prototype.hasOwnProperty.call(e,n)&&void 0!==t.style[n])return e[n];return!1}();function ft(t,e,n){M(t,n["showC"+e.substring(1)+"Button"],"inline-block"),t.innerHTML=n[e+"ButtonText"],t.setAttribute("aria-label",n[e+"ButtonAriaLabel"]),t.className=x[e],y(t,n.customClass,e+"Button"),rt(t,n[e+"ButtonClass"])}function mt(t,e){var n=j();n&&(function(t,e){"string"==typeof e?t.style.background=e:e||rt([document.documentElement,document.body],x["no-backdrop"])}(n,e.backdrop),!e.backdrop&&e.allowOutsideClick&&w('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`'),function(t,e){e in x?rt(t,x[e]):(w('The "position" parameter is not valid, defaulting to "center"'),rt(t,x.center))}(n,e.position),function(t,e){if(e&&"string"==typeof e){var n="grow-"+e;n in x&&rt(t,x[n])}}(n,e.grow),y(n,e.customClass,"container"),e.customContainerClass&&rt(n,e.customContainerClass))}function gt(t,e){t.placeholder&&!e.inputPlaceholder||(t.placeholder=e.inputPlaceholder)}var ht={promise:new WeakMap,innerParams:new WeakMap,domCache:new WeakMap},vt=["input","file","range","select","radio","checkbox","textarea"],bt=function(t){if(!Ct[t.input])return g('Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'.concat(t.input,'"'));var e=Ct[t.input](t);L(e),setTimeout(function(){A(e)})},yt=function(t,e){var n=B(F(),t);if(n)for(var o in function(t){for(var e=0;e<t.attributes.length;e++){var n=t.attributes[e].name;-1===["type","value","style"].indexOf(n)&&t.removeAttribute(n)}}(n),e)"range"===t&&"placeholder"===o||n.setAttribute(o,e[o])},wt=function(t,e,n){t.className=e,n.inputClass&&rt(t,n.inputClass),n.customClass&&rt(t,n.customClass.input)},Ct={};Ct.text=Ct.email=Ct.password=Ct.number=Ct.tel=Ct.url=function(t){var e=st(F(),x.input);return"string"==typeof t.inputValue||"number"==typeof t.inputValue?e.value=t.inputValue:v(t.inputValue)||w('Unexpected type of inputValue! Expected "string", "number" or "Promise", got "'.concat(r(t.inputValue),'"')),gt(e,t),e.type=t.input,e},Ct.file=function(t){var e=st(F(),x.file);return gt(e,t),e.type=t.input,e},Ct.range=function(t){var e=st(F(),x.range),n=e.querySelector("input"),o=e.querySelector("output");return n.value=t.inputValue,n.type=t.input,o.value=t.inputValue,e},Ct.select=function(t){var e=st(F(),x.select);if(e.innerHTML="",t.inputPlaceholder){var n=document.createElement("option");n.innerHTML=t.inputPlaceholder,n.value="",n.disabled=!0,n.selected=!0,e.appendChild(n)}return e},Ct.radio=function(){var t=st(F(),x.radio);return t.innerHTML="",t},Ct.checkbox=function(t){var e=st(F(),x.checkbox),n=B(F(),"checkbox");return n.type="checkbox",n.value=1,n.id=x.checkbox,n.checked=Boolean(t.inputValue),e.querySelector("span").innerHTML=t.inputPlaceholder,e},Ct.textarea=function(t){var e=st(F(),x.textarea);if(e.value=t.inputValue,gt(e,t),"MutationObserver"in window){var n=parseInt(window.getComputedStyle(R()).width),o=parseInt(window.getComputedStyle(R()).paddingLeft)+parseInt(window.getComputedStyle(R()).paddingRight);new MutationObserver(function(){var t=e.offsetWidth+o;R().style.width=n<t?t+"px":null}).observe(e,{attributes:!0,attributeFilter:["style"]})}return e};function kt(t,e){var n=F().querySelector("#"+x.content);e.html?(nt(e.html,n),L(n,"block")):e.text?(n.textContent=e.text,L(n,"block")):O(n),function(t,o){var i=F(),e=ht.innerParams.get(t),r=!e||o.input!==e.input;vt.forEach(function(t){var e=x[t],n=st(i,e);yt(t,o.inputAttributes),wt(n,e,o),r&&O(n)}),o.input&&r&&bt(o)}(t,e),y(F(),e.customClass,"content")}function xt(t,i){var r=z();if(!i.progressSteps||0===i.progressSteps.length)return O(r);L(r),r.innerHTML="";var a=parseInt(null===i.currentProgressStep?Fe.getQueueStep():i.currentProgressStep);a>=i.progressSteps.length&&w("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"),i.progressSteps.forEach(function(t,e){var n=function(t){var e=document.createElement("li");return rt(e,x["progress-step"]),e.innerHTML=t,e}(t);if(r.appendChild(n),e===a&&rt(n,x["active-progress-step"]),e!==i.progressSteps.length-1){var o=function(t){var e=document.createElement("li");return rt(e,x["progress-step-line"]),t.progressStepsDistance&&(e.style.width=t.progressStepsDistance),e}(t);r.appendChild(o)}})}function St(t,e){var n=Y();y(n,e.customClass,"header"),xt(0,e),function(t,e){var n=ht.innerParams.get(t);if(n&&e.type===n.type&&N())y(N(),e.customClass,"icon");else if(At(),e.type)if(Et(),-1!==Object.keys(S).indexOf(e.type)){var o=I(".".concat(x.icon,".").concat(S[e.type]));L(o),y(o,e.customClass,"icon"),E(o,"swal2-animate-".concat(e.type,"-icon"),e.animation)}else g('Unknown type! Expected "success", "error", "warning", "info" or "question", got "'.concat(e.type,'"'))}(t,e),function(t,e){var n=_();if(!e.imageUrl)return O(n);L(n),n.setAttribute("src",e.imageUrl),n.setAttribute("alt",e.imageAlt),T(n,"width",e.imageWidth),T(n,"height",e.imageHeight),n.className=x.image,y(n,e.customClass,"image"),e.imageClass&&rt(n,e.imageClass)}(0,e),function(t,e){var n=U();M(n,e.title||e.titleText),e.title&&nt(e.title,n),e.titleText&&(n.innerText=e.titleText),y(n,e.customClass,"title")}(0,e),function(t,e){var n=J();n.innerHTML=e.closeButtonHtml,y(n,e.customClass,"closeButton"),M(n,e.showCloseButton),n.setAttribute("aria-label",e.closeButtonAriaLabel)}(0,e)}function Pt(t,e){!function(t,e){var n=R();T(n,"width",e.width),T(n,"padding",e.padding),e.background&&(n.style.background=e.background),n.className=x.popup,e.toast?(rt([document.documentElement,document.body],x["toast-shown"]),rt(n,x.toast)):rt(n,x.modal),y(n,e.customClass,"popup"),"string"==typeof e.customClass&&rt(n,e.customClass),E(n,x.noanimation,!e.animation)}(0,e),mt(0,e),St(t,e),kt(t,e),ot(0,e),function(t,e){var n=$();M(n,e.footer),e.footer&&nt(e.footer,n),y(n,e.customClass,"footer")}(0,e)}function Bt(){return K()&&K().click()}var At=function(){for(var t=D(),e=0;e<t.length;e++)O(t[e])},Et=function(){for(var t=R(),e=window.getComputedStyle(t).getPropertyValue("background-color"),n=t.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix"),o=0;o<n.length;o++)n[o].style.backgroundColor=e};function Tt(){var t=R();t||Fe.fire(""),t=R();var e=Q(),n=K(),o=Z();L(e),L(n),rt([t,e],x.loading),n.disabled=!0,o.disabled=!0,t.setAttribute("data-loading",!0),t.setAttribute("aria-busy",!0),t.focus()}function Lt(){return new Promise(function(t){var e=window.scrollX,n=window.scrollY;Ht.restoreFocusTimeout=setTimeout(function(){Ht.previousActiveElement&&Ht.previousActiveElement.focus?(Ht.previousActiveElement.focus(),Ht.previousActiveElement=null):document.body&&document.body.focus(),t()},100),void 0!==e&&void 0!==n&&window.scrollTo(e,n)})}function Ot(t){return Object.prototype.hasOwnProperty.call(jt,t)}function Mt(t){return qt[t]}var Vt=[],Ht={},jt={title:"",titleText:"",text:"",html:"",footer:"",type:null,toast:!1,customClass:"",customContainerClass:"",target:"body",backdrop:!0,animation:!0,heightAuto:!0,allowOutsideClick:!0,allowEscapeKey:!0,allowEnterKey:!0,stopKeydownPropagation:!0,keydownListenerCapture:!1,showConfirmButton:!0,showCancelButton:!1,preConfirm:null,confirmButtonText:"OK",confirmButtonAriaLabel:"",confirmButtonColor:null,confirmButtonClass:"",cancelButtonText:"Cancel",cancelButtonAriaLabel:"",cancelButtonColor:null,cancelButtonClass:"",buttonsStyling:!0,reverseButtons:!1,focusConfirm:!0,focusCancel:!1,showCloseButton:!1,closeButtonHtml:"&times;",closeButtonAriaLabel:"Close this dialog",showLoaderOnConfirm:!1,imageUrl:null,imageWidth:null,imageHeight:null,imageAlt:"",imageClass:"",timer:null,width:null,padding:null,background:null,input:null,inputPlaceholder:"",inputValue:"",inputOptions:{},inputAutoTrim:!0,inputClass:"",inputAttributes:{},inputValidator:null,validationMessage:null,grow:!1,position:"center",progressSteps:[],currentProgressStep:null,progressStepsDistance:null,onBeforeOpen:null,onAfterClose:null,onOpen:null,onClose:null,scrollbarPadding:!0},It=["title","titleText","text","html","type","customClass","showConfirmButton","showCancelButton","confirmButtonText","confirmButtonAriaLabel","confirmButtonColor","confirmButtonClass","cancelButtonText","cancelButtonAriaLabel","cancelButtonColor","cancelButtonClass","buttonsStyling","reverseButtons","imageUrl","imageWidth","imageHeigth","imageAlt","imageClass","progressSteps","currentProgressStep"],qt={customContainerClass:"customClass",confirmButtonClass:"customClass",cancelButtonClass:"customClass",imageClass:"customClass",inputClass:"customClass"},Rt=["allowOutsideClick","allowEnterKey","backdrop","focusConfirm","focusCancel","heightAuto","keydownListenerCapture"],Dt=Object.freeze({isValidParameter:Ot,isUpdatableParameter:function(t){return-1!==It.indexOf(t)},isDeprecatedParameter:Mt,argsToParams:function(n){var o={};switch(r(n[0])){case"object":s(o,n[0]);break;default:["title","html","type"].forEach(function(t,e){switch(r(n[e])){case"string":o[t]=n[e];break;case"undefined":break;default:g("Unexpected type of ".concat(t,'! Expected "string", got ').concat(r(n[e])))}})}return o},isVisible:function(){return V(R())},clickConfirm:Bt,clickCancel:function(){return Z()&&Z().click()},getContainer:j,getPopup:R,getTitle:U,getContent:F,getImage:_,getIcon:N,getIcons:D,getCloseButton:J,getActions:Q,getConfirmButton:K,getCancelButton:Z,getHeader:Y,getFooter:$,getFocusableElements:X,getValidationMessage:W,isLoading:function(){return R().hasAttribute("data-loading")},fire:function(){for(var t=arguments.length,e=new Array(t),n=0;n<t;n++)e[n]=arguments[n];return l(this,e)},mixin:function(n){return function(t){function e(){return o(this,e),d(this,u(e).apply(this,arguments))}return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&c(t,e)}(e,t),a(e,[{key:"_main",value:function(t){return p(u(e.prototype),"_main",this).call(this,s({},n,t))}}]),e}(this)},queue:function(t){var r=this;Vt=t;function a(t,e){Vt=[],document.body.removeAttribute("data-swal2-queue-step"),t(e)}var s=[];return new Promise(function(i){!function e(n,o){n<Vt.length?(document.body.setAttribute("data-swal2-queue-step",n),r.fire(Vt[n]).then(function(t){void 0!==t.value?(s.push(t.value),e(n+1,o)):a(i,{dismiss:t.dismiss})})):a(i,{value:s})}(0)})},getQueueStep:function(){return document.body.getAttribute("data-swal2-queue-step")},insertQueueStep:function(t,e){return e&&e<Vt.length?Vt.splice(e,0,t):Vt.push(t)},deleteQueueStep:function(t){void 0!==Vt[t]&&Vt.splice(t,1)},showLoading:Tt,enableLoading:Tt,getTimerLeft:function(){return Ht.timeout&&Ht.timeout.getTimerLeft()},stopTimer:function(){return Ht.timeout&&Ht.timeout.stop()},resumeTimer:function(){return Ht.timeout&&Ht.timeout.start()},toggleTimer:function(){var t=Ht.timeout;return t&&(t.running?t.stop():t.start())},increaseTimer:function(t){return Ht.timeout&&Ht.timeout.increase(t)},isTimerRunning:function(){return Ht.timeout&&Ht.timeout.isRunning()}});function Nt(){var t=ht.innerParams.get(this),e=ht.domCache.get(this);t.showConfirmButton||(O(e.confirmButton),t.showCancelButton||O(e.actions)),at([e.popup,e.actions],x.loading),e.popup.removeAttribute("aria-busy"),e.popup.removeAttribute("data-loading"),e.confirmButton.disabled=!1,e.cancelButton.disabled=!1}function Ut(){null===P.previousBodyPadding&&document.body.scrollHeight>window.innerHeight&&(P.previousBodyPadding=parseInt(window.getComputedStyle(document.body).getPropertyValue("padding-right")),document.body.style.paddingRight=P.previousBodyPadding+function(){if("ontouchstart"in window||navigator.msMaxTouchPoints)return 0;var t=document.createElement("div");t.style.width="50px",t.style.height="50px",t.style.overflow="scroll",document.body.appendChild(t);var e=t.offsetWidth-t.clientWidth;return document.body.removeChild(t),e}()+"px")}function Ft(){return!!window.MSInputMethodContext&&!!document.documentMode}function _t(){var t=j(),e=R();t.style.removeProperty("align-items"),e.offsetTop<0&&(t.style.alignItems="flex-start")}var zt=function(){var e,n=j();n.ontouchstart=function(t){e=t.target===n||!function(t){return!!(t.scrollHeight>t.clientHeight)}(n)&&"INPUT"!==t.target.tagName},n.ontouchmove=function(t){e&&(t.preventDefault(),t.stopPropagation())}},Wt={swalPromiseResolve:new WeakMap};function Kt(t,e,n,o){n?$t(t,o):(Lt().then(function(){return $t(t,o)}),Ht.keydownTarget.removeEventListener("keydown",Ht.keydownHandler,{capture:Ht.keydownListenerCapture}),Ht.keydownHandlerAdded=!1),e.parentNode&&e.parentNode.removeChild(e),G()&&(null!==P.previousBodyPadding&&(document.body.style.paddingRight=P.previousBodyPadding+"px",P.previousBodyPadding=null),function(){if(b(document.body,x.iosfix)){var t=parseInt(document.body.style.top,10);at(document.body,x.iosfix),document.body.style.top="",document.body.scrollTop=-1*t}}(),"undefined"!=typeof window&&Ft()&&window.removeEventListener("resize",_t),m(document.body.children).forEach(function(t){t.hasAttribute("data-previous-aria-hidden")?(t.setAttribute("aria-hidden",t.getAttribute("data-previous-aria-hidden")),t.removeAttribute("data-previous-aria-hidden")):t.removeAttribute("aria-hidden")})),at([document.documentElement,document.body],[x.shown,x["height-auto"],x["no-backdrop"],x["toast-shown"],x["toast-column"]])}function Zt(t){var e=R();if(e&&!b(e,x.hide)){var n=ht.innerParams.get(this);if(n){var o=Wt.swalPromiseResolve.get(this);at(e,x.show),rt(e,x.hide),function(t,e,n){var o=j(),i=pt&&H(e),r=n.onClose,a=n.onAfterClose;if(r!==null&&typeof r==="function"){r(e)}if(i){Yt(t,e,o,a)}else{Kt(t,o,ut(),a)}}(this,e,n),o(t||{})}}}function Qt(t){for(var e in t)t[e]=new WeakMap}var Yt=function(t,e,n,o){Ht.swalCloseEventFinishedCallback=Kt.bind(null,t,n,ut(),o),e.addEventListener(pt,function(t){t.target===e&&(Ht.swalCloseEventFinishedCallback(),delete Ht.swalCloseEventFinishedCallback)})},$t=function(t,e){setTimeout(function(){null!==e&&"function"==typeof e&&e(),R()||function(t){delete t.params,delete Ht.keydownHandler,delete Ht.keydownTarget,Qt(ht),Qt(Wt)}(t)})};function Jt(t,e,n){var o=ht.domCache.get(t);e.forEach(function(t){o[t].disabled=n})}function Xt(t,e){if(!t)return!1;if("radio"===t.type)for(var n=t.parentNode.parentNode.querySelectorAll("input"),o=0;o<n.length;o++)n[o].disabled=e;else t.disabled=e}var Gt=function(){function n(t,e){o(this,n),this.callback=t,this.remaining=e,this.running=!1,this.start()}return a(n,[{key:"start",value:function(){return this.running||(this.running=!0,this.started=new Date,this.id=setTimeout(this.callback,this.remaining)),this.remaining}},{key:"stop",value:function(){return this.running&&(this.running=!1,clearTimeout(this.id),this.remaining-=new Date-this.started),this.remaining}},{key:"increase",value:function(t){var e=this.running;return e&&this.stop(),this.remaining+=t,e&&this.start(),this.remaining}},{key:"getTimerLeft",value:function(){return this.running&&(this.stop(),this.start()),this.remaining}},{key:"isRunning",value:function(){return this.running}}]),n}(),te={email:function(t,e){return/^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(t)?Promise.resolve():Promise.resolve(e||"Invalid email address")},url:function(t,e){return/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(t)?Promise.resolve():Promise.resolve(e||"Invalid URL")}};function ee(t){!function(e){e.inputValidator||Object.keys(te).forEach(function(t){e.input===t&&(e.inputValidator=te[t])})}(t),t.showLoaderOnConfirm&&!t.preConfirm&&w("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request"),t.animation=C(t.animation),function(t){t.target&&("string"!=typeof t.target||document.querySelector(t.target))&&("string"==typeof t.target||t.target.appendChild)||(w('Target parameter is not valid, defaulting to "body"'),t.target="body")}(t),"string"==typeof t.title&&(t.title=t.title.split("\n").join("<br />")),lt(t)}function ne(t,e){t.removeEventListener(pt,ne),e.style.overflowY="auto"}function oe(t){var e=j(),n=R();"function"==typeof t.onBeforeOpen&&t.onBeforeOpen(n),fe(e,n,t),de(e,n),G()&&pe(e,t.scrollbarPadding),ut()||Ht.previousActiveElement||(Ht.previousActiveElement=document.activeElement),"function"==typeof t.onOpen&&setTimeout(function(){return t.onOpen(n)})}function ie(t,e){"select"===e.input||"radio"===e.input?me(t,e):-1!==["text","email","number","tel","textarea"].indexOf(e.input)&&v(e.inputValue)&&ge(t,e)}function re(t,e){t.disableButtons(),e.input?be(t,e):ye(t,e,!0)}function ae(t,e){t.disableButtons(),e(k.cancel)}function se(t,e){t.closePopup({value:e})}function ue(e,t,n,o){t.keydownTarget&&t.keydownHandlerAdded&&(t.keydownTarget.removeEventListener("keydown",t.keydownHandler,{capture:t.keydownListenerCapture}),t.keydownHandlerAdded=!1),n.toast||(t.keydownHandler=function(t){return Be(e,t,n,o)},t.keydownTarget=n.keydownListenerCapture?window:R(),t.keydownListenerCapture=n.keydownListenerCapture,t.keydownTarget.addEventListener("keydown",t.keydownHandler,{capture:t.keydownListenerCapture}),t.keydownHandlerAdded=!0)}function ce(t,e,n){for(var o=X(t.focusCancel),i=0;i<o.length;i++)return(e+=n)===o.length?e=0:-1===e&&(e=o.length-1),o[e].focus();R().focus()}function le(t,e,n){e.toast?Oe(t,e,n):(Ve(t),He(t),je(t,e,n))}var de=function(t,e){pt&&H(e)?(t.style.overflowY="hidden",e.addEventListener(pt,ne.bind(null,e,t))):t.style.overflowY="auto"},pe=function(t,e){!function(){if(/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream&&!b(document.body,x.iosfix)){var t=document.body.scrollTop;document.body.style.top=-1*t+"px",rt(document.body,x.iosfix),zt()}}(),"undefined"!=typeof window&&Ft()&&(_t(),window.addEventListener("resize",_t)),m(document.body.children).forEach(function(t){t===j()||function(t,e){if("function"==typeof t.contains)return t.contains(e)}(t,j())||(t.hasAttribute("aria-hidden")&&t.setAttribute("data-previous-aria-hidden",t.getAttribute("aria-hidden")),t.setAttribute("aria-hidden","true"))}),e&&Ut(),setTimeout(function(){t.scrollTop=0})},fe=function(t,e,n){n.animation&&(rt(e,x.show),rt(t,x.fade)),L(e),rt([document.documentElement,document.body,t],x.shown),n.heightAuto&&n.backdrop&&!n.toast&&rt([document.documentElement,document.body],x["height-auto"])},me=function(e,n){function o(t){return he[n.input](i,ve(t),n)}var i=F();v(n.inputOptions)?(Tt(),n.inputOptions.then(function(t){e.hideLoading(),o(t)})):"object"===r(n.inputOptions)?o(n.inputOptions):g("Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(r(n.inputOptions)))},ge=function(e,n){var o=e.getInput();O(o),n.inputValue.then(function(t){o.value="number"===n.input?parseFloat(t)||0:t+"",L(o),o.focus(),e.hideLoading()}).catch(function(t){g("Error in inputValue promise: "+t),o.value="",L(o),o.focus(),e.hideLoading()})},he={select:function(t,e,i){var r=st(t,x.select);e.forEach(function(t){var e=t[0],n=t[1],o=document.createElement("option");o.value=e,o.innerHTML=n,i.inputValue.toString()===e.toString()&&(o.selected=!0),r.appendChild(o)}),r.focus()},radio:function(t,e,a){var s=st(t,x.radio);e.forEach(function(t){var e=t[0],n=t[1],o=document.createElement("input"),i=document.createElement("label");o.type="radio",o.name=x.radio,o.value=e,a.inputValue.toString()===e.toString()&&(o.checked=!0);var r=document.createElement("span");r.innerHTML=n,r.className=x.label,i.appendChild(o),i.appendChild(r),s.appendChild(i)});var n=s.querySelectorAll("input");n.length&&n[0].focus()}},ve=function(e){var n=[];return"undefined"!=typeof Map&&e instanceof Map?e.forEach(function(t,e){n.push([e,t])}):Object.keys(e).forEach(function(t){n.push([t,e[t]])}),n},be=function(e,n){var o=we(e,n);n.inputValidator?(e.disableInput(),Promise.resolve().then(function(){return n.inputValidator(o,n.validationMessage)}).then(function(t){e.enableButtons(),e.enableInput(),t?e.showValidationMessage(t):ye(e,n,o)})):e.getInput().checkValidity()?ye(e,n,o):(e.enableButtons(),e.showValidationMessage(n.validationMessage))},ye=function(e,t,n){(t.showLoaderOnConfirm&&Tt(),t.preConfirm)?(e.resetValidationMessage(),Promise.resolve().then(function(){return t.preConfirm(n,t.validationMessage)}).then(function(t){V(W())||!1===t?e.hideLoading():se(e,void 0===t?n:t)})):se(e,n)},we=function(t,e){var n=t.getInput();if(!n)return null;switch(e.input){case"checkbox":return Ce(n);case"radio":return ke(n);case"file":return xe(n);default:return e.inputAutoTrim?n.value.trim():n.value}},Ce=function(t){return t.checked?1:0},ke=function(t){return t.checked?t.value:null},xe=function(t){return t.files.length?t.files[0]:null},Se=["ArrowLeft","ArrowRight","ArrowUp","ArrowDown","Left","Right","Up","Down"],Pe=["Escape","Esc"],Be=function(t,e,n,o){n.stopKeydownPropagation&&e.stopPropagation(),"Enter"===e.key?Ae(t,e,n):"Tab"===e.key?Ee(e,n):-1!==Se.indexOf(e.key)?Te():-1!==Pe.indexOf(e.key)&&Le(e,n,o)},Ae=function(t,e,n){if(!e.isComposing&&e.target&&t.getInput()&&e.target.outerHTML===t.getInput().outerHTML){if(-1!==["textarea","file"].indexOf(n.input))return;Bt(),e.preventDefault()}},Ee=function(t,e){for(var n=t.target,o=X(e.focusCancel),i=-1,r=0;r<o.length;r++)if(n===o[r]){i=r;break}t.shiftKey?ce(e,i,-1):ce(e,i,1),t.stopPropagation(),t.preventDefault()},Te=function(){var t=K(),e=Z();document.activeElement===t&&V(e)?e.focus():document.activeElement===e&&V(t)&&t.focus()},Le=function(t,e,n){C(e.allowEscapeKey)&&(t.preventDefault(),n(k.esc))},Oe=function(t,e,n){t.popup.onclick=function(){e.showConfirmButton||e.showCancelButton||e.showCloseButton||e.input||n(k.close)}},Me=!1,Ve=function(e){e.popup.onmousedown=function(){e.container.onmouseup=function(t){e.container.onmouseup=void 0,t.target===e.container&&(Me=!0)}}},He=function(e){e.container.onmousedown=function(){e.popup.onmouseup=function(t){e.popup.onmouseup=void 0,t.target!==e.popup&&!e.popup.contains(t.target)||(Me=!0)}}},je=function(e,n,o){e.container.onclick=function(t){Me?Me=!1:t.target===e.container&&C(n.allowOutsideClick)&&o(k.backdrop)}};var Ie=function(t,e,n){e.timer&&(t.timeout=new Gt(function(){n("timer"),delete t.timeout},e.timer))},qe=function(t,e){if(!e.toast)return C(e.allowEnterKey)?e.focusCancel&&V(t.cancelButton)?t.cancelButton.focus():e.focusConfirm&&V(t.confirmButton)?t.confirmButton.focus():void ce(e,-1,1):Re()},Re=function(){document.activeElement&&"function"==typeof document.activeElement.blur&&document.activeElement.blur()};var De,Ne=Object.freeze({hideLoading:Nt,disableLoading:Nt,getInput:function(t){var e=ht.innerParams.get(t||this),n=ht.domCache.get(t||this);return n?B(n.content,e.input):null},close:Zt,closePopup:Zt,closeModal:Zt,closeToast:Zt,enableButtons:function(){Jt(this,["confirmButton","cancelButton"],!1)},disableButtons:function(){Jt(this,["confirmButton","cancelButton"],!0)},enableConfirmButton:function(){h("Swal.disableConfirmButton()","Swal.getConfirmButton().removeAttribute('disabled')"),Jt(this,["confirmButton"],!1)},disableConfirmButton:function(){h("Swal.enableConfirmButton()","Swal.getConfirmButton().setAttribute('disabled', '')"),Jt(this,["confirmButton"],!0)},enableInput:function(){return Xt(this.getInput(),!1)},disableInput:function(){return Xt(this.getInput(),!0)},showValidationMessage:function(t){var e=ht.domCache.get(this);e.validationMessage.innerHTML=t;var n=window.getComputedStyle(e.popup);e.validationMessage.style.marginLeft="-".concat(n.getPropertyValue("padding-left")),e.validationMessage.style.marginRight="-".concat(n.getPropertyValue("padding-right")),L(e.validationMessage);var o=this.getInput();o&&(o.setAttribute("aria-invalid",!0),o.setAttribute("aria-describedBy",x["validation-message"]),A(o),rt(o,x.inputerror))},resetValidationMessage:function(){var t=ht.domCache.get(this);t.validationMessage&&O(t.validationMessage);var e=this.getInput();e&&(e.removeAttribute("aria-invalid"),e.removeAttribute("aria-describedBy"),at(e,x.inputerror))},getProgressSteps:function(){return h("Swal.getProgressSteps()","const swalInstance = Swal.fire({progressSteps: ['1', '2', '3']}); const progressSteps = swalInstance.params.progressSteps"),ht.innerParams.get(this).progressSteps},setProgressSteps:function(t){h("Swal.setProgressSteps()","Swal.update()");var e=s({},ht.innerParams.get(this),{progressSteps:t});xt(0,e),ht.innerParams.set(this,e)},showProgressSteps:function(){var t=ht.domCache.get(this);L(t.progressSteps)},hideProgressSteps:function(){var t=ht.domCache.get(this);O(t.progressSteps)},_main:function(t){!function(t){for(var e in t)Ot(i=e)||w('Unknown parameter "'.concat(i,'"')),t.toast&&(o=e,-1!==Rt.indexOf(o)&&w('The parameter "'.concat(o,'" is incompatible with toasts'))),Mt(n=void 0)&&h(n,Mt(n));var n,o,i}(t),R()&&Ht.swalCloseEventFinishedCallback&&(Ht.swalCloseEventFinishedCallback(),delete Ht.swalCloseEventFinishedCallback),Ht.deferDisposalTimer&&(clearTimeout(Ht.deferDisposalTimer),delete Ht.deferDisposalTimer);var e=s({},jt,t);ee(e),Object.freeze(e),Ht.timeout&&(Ht.timeout.stop(),delete Ht.timeout),clearTimeout(Ht.restoreFocusTimeout);var n=function(t){var e={popup:R(),container:j(),content:F(),actions:Q(),confirmButton:K(),cancelButton:Z(),closeButton:J(),validationMessage:W(),progressSteps:z()};return ht.domCache.set(t,e),e}(this);return Pt(this,e),ht.innerParams.set(this,e),function(n,o,i){return new Promise(function(t){var e=function t(e){n.closePopup({dismiss:e})};Wt.swalPromiseResolve.set(n,t);Ie(Ht,i,e);o.confirmButton.onclick=function(){return re(n,i)};o.cancelButton.onclick=function(){return ae(n,e)};o.closeButton.onclick=function(){return e(k.close)};le(o,i,e);ue(n,Ht,i,e);if(i.toast&&(i.input||i.footer||i.showCloseButton)){rt(document.body,x["toast-column"])}else{at(document.body,x["toast-column"])}ie(n,i);oe(i);qe(o,i);o.container.scrollTop=0})}(this,n,e)},update:function(e){var n={};Object.keys(e).forEach(function(t){Fe.isUpdatableParameter(t)?n[t]=e[t]:w('Invalid parameter to update: "'.concat(t,'". Updatable params are listed here: https://github.com/sweetalert2/sweetalert2/blob/master/src/utils/params.js'))});var t=s({},ht.innerParams.get(this),n);Pt(this,t),ht.innerParams.set(this,t),Object.defineProperties(this,{params:{value:s({},this.params,e),writable:!1,enumerable:!0}})}});function Ue(){if("undefined"!=typeof window){"undefined"==typeof Promise&&g("This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/sweetalert2/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)"),De=this;for(var t=arguments.length,e=new Array(t),n=0;n<t;n++)e[n]=arguments[n];var o=Object.freeze(this.constructor.argsToParams(e));Object.defineProperties(this,{params:{value:o,writable:!1,enumerable:!0,configurable:!0}});var i=this._main(this.params);ht.promise.set(this,i)}}Ue.prototype.then=function(t){return ht.promise.get(this).then(t)},Ue.prototype.finally=function(t){return ht.promise.get(this).finally(t)},s(Ue.prototype,Ne),s(Ue,Dt),Object.keys(Ne).forEach(function(e){Ue[e]=function(){var t;if(De)return(t=De)[e].apply(t,arguments)}}),Ue.DismissReason=k,Ue.version="8.16.0";var Fe=Ue;return Fe.default=Fe}),void 0!==this&&this.Sweetalert2&&(this.swal=this.sweetAlert=this.Swal=this.SweetAlert=this.Sweetalert2);"undefined"!=typeof document&&function(e,t){var n=e.createElement("style");if(e.getElementsByTagName("head")[0].appendChild(n),n.styleSheet)n.styleSheet.disabled||(n.styleSheet.cssText=t);else try{n.innerHTML=t}catch(e){n.innerText=t}}(document,"@charset \"UTF-8\";@-webkit-keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@-webkit-keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@-webkit-keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.875em;width:1.5625em}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.875em;width:1.5625em}}@-webkit-keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@-webkit-keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@-webkit-keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@-webkit-keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}body.swal2-toast-shown .swal2-container{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-shown{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}body.swal2-toast-column .swal2-toast{flex-direction:column;align-items:stretch}body.swal2-toast-column .swal2-toast .swal2-actions{flex:1;align-self:stretch;height:2.2em;margin-top:.3125em}body.swal2-toast-column .swal2-toast .swal2-loading{justify-content:center}body.swal2-toast-column .swal2-toast .swal2-input{height:2em;margin:.3125em auto;font-size:1em}body.swal2-toast-column .swal2-toast .swal2-validation-message{font-size:1em}.swal2-popup.swal2-toast{flex-direction:row;align-items:center;width:auto;padding:.625em;overflow-y:hidden;box-shadow:0 0 .625em #d9d9d9}.swal2-popup.swal2-toast .swal2-header{flex-direction:row}.swal2-popup.swal2-toast .swal2-title{flex-grow:1;justify-content:flex-start;margin:0 .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{position:static;width:.8em;height:.8em;line-height:.8}.swal2-popup.swal2-toast .swal2-content{justify-content:flex-start;font-size:1em}.swal2-popup.swal2-toast .swal2-icon{width:2em;min-width:2em;height:2em;margin:0}.swal2-popup.swal2-toast .swal2-icon::before{display:flex;align-items:center;font-size:2em;font-weight:700}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-popup.swal2-toast .swal2-icon::before{font-size:.25em}}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{flex-basis:auto!important;width:auto;height:auto;margin:0 .3125em}.swal2-popup.swal2-toast .swal2-styled{margin:0 .3125em;padding:.3125em .625em;font-size:1em}.swal2-popup.swal2-toast .swal2-styled:focus{box-shadow:0 0 0 .0625em #fff,0 0 0 .125em rgba(50,100,150,.4)}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast.swal2-show{-webkit-animation:swal2-toast-show .5s;animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{-webkit-animation:swal2-toast-hide .1s forwards;animation:swal2-toast-hide .1s forwards}.swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-tip{-webkit-animation:swal2-toast-animate-success-line-tip .75s;animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-long{-webkit-animation:swal2-toast-animate-success-line-long .75s;animation:swal2-toast-animate-success-line-long .75s}@-webkit-keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@-webkit-keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@-webkit-keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@-webkit-keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-shown{top:auto;right:auto;bottom:auto;left:auto;max-width:calc(100% - .625em * 2);background-color:transparent}body.swal2-no-backdrop .swal2-shown>.swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}body.swal2-no-backdrop .swal2-shown.swal2-top{top:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-shown.swal2-top-left,body.swal2-no-backdrop .swal2-shown.swal2-top-start{top:0;left:0}body.swal2-no-backdrop .swal2-shown.swal2-top-end,body.swal2-no-backdrop .swal2-shown.swal2-top-right{top:0;right:0}body.swal2-no-backdrop .swal2-shown.swal2-center{top:50%;left:50%;transform:translate(-50%,-50%)}body.swal2-no-backdrop .swal2-shown.swal2-center-left,body.swal2-no-backdrop .swal2-shown.swal2-center-start{top:50%;left:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-shown.swal2-center-end,body.swal2-no-backdrop .swal2-shown.swal2-center-right{top:50%;right:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-shown.swal2-bottom{bottom:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-shown.swal2-bottom-left,body.swal2-no-backdrop .swal2-shown.swal2-bottom-start{bottom:0;left:0}body.swal2-no-backdrop .swal2-shown.swal2-bottom-end,body.swal2-no-backdrop .swal2-shown.swal2-bottom-right{right:0;bottom:0}.swal2-container{display:flex;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;flex-direction:row;align-items:center;justify-content:center;padding:.625em;overflow-x:hidden;background-color:transparent;-webkit-overflow-scrolling:touch}.swal2-container.swal2-top{align-items:flex-start}.swal2-container.swal2-top-left,.swal2-container.swal2-top-start{align-items:flex-start;justify-content:flex-start}.swal2-container.swal2-top-end,.swal2-container.swal2-top-right{align-items:flex-start;justify-content:flex-end}.swal2-container.swal2-center{align-items:center}.swal2-container.swal2-center-left,.swal2-container.swal2-center-start{align-items:center;justify-content:flex-start}.swal2-container.swal2-center-end,.swal2-container.swal2-center-right{align-items:center;justify-content:flex-end}.swal2-container.swal2-bottom{align-items:flex-end}.swal2-container.swal2-bottom-left,.swal2-container.swal2-bottom-start{align-items:flex-end;justify-content:flex-start}.swal2-container.swal2-bottom-end,.swal2-container.swal2-bottom-right{align-items:flex-end;justify-content:flex-end}.swal2-container.swal2-bottom-end>:first-child,.swal2-container.swal2-bottom-left>:first-child,.swal2-container.swal2-bottom-right>:first-child,.swal2-container.swal2-bottom-start>:first-child,.swal2-container.swal2-bottom>:first-child{margin-top:auto}.swal2-container.swal2-grow-fullscreen>.swal2-modal{display:flex!important;flex:1;align-self:stretch;justify-content:center}.swal2-container.swal2-grow-row>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-grow-column{flex:1;flex-direction:column}.swal2-container.swal2-grow-column.swal2-bottom,.swal2-container.swal2-grow-column.swal2-center,.swal2-container.swal2-grow-column.swal2-top{align-items:center}.swal2-container.swal2-grow-column.swal2-bottom-left,.swal2-container.swal2-grow-column.swal2-bottom-start,.swal2-container.swal2-grow-column.swal2-center-left,.swal2-container.swal2-grow-column.swal2-center-start,.swal2-container.swal2-grow-column.swal2-top-left,.swal2-container.swal2-grow-column.swal2-top-start{align-items:flex-start}.swal2-container.swal2-grow-column.swal2-bottom-end,.swal2-container.swal2-grow-column.swal2-bottom-right,.swal2-container.swal2-grow-column.swal2-center-end,.swal2-container.swal2-grow-column.swal2-center-right,.swal2-container.swal2-grow-column.swal2-top-end,.swal2-container.swal2-grow-column.swal2-top-right{align-items:flex-end}.swal2-container.swal2-grow-column>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{margin:auto}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-container .swal2-modal{margin:0!important}}.swal2-container.swal2-fade{transition:background-color .1s}.swal2-container.swal2-shown{background-color:rgba(0,0,0,.4)}.swal2-popup{display:none;position:relative;box-sizing:border-box;flex-direction:column;justify-content:center;width:32em;max-width:100%;padding:1.25em;border:none;border-radius:.3125em;background:#fff;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-header{display:flex;flex-direction:column;align-items:center}.swal2-title{position:relative;max-width:100%;margin:0 0 .4em;padding:0;color:#595959;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;flex-wrap:wrap;align-items:center;justify-content:center;width:100%;margin:1.25em auto 0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-actions.swal2-loading .swal2-styled.swal2-confirm{box-sizing:border-box;width:2.5em;height:2.5em;margin:.46875em;padding:0;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:.25em solid transparent;border-radius:100%;border-color:transparent;background-color:transparent!important;color:transparent;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-actions.swal2-loading .swal2-styled.swal2-cancel{margin-right:30px;margin-left:30px}.swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after{content:\"\";display:inline-block;width:15px;height:15px;margin-left:5px;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:3px solid #999;border-radius:50%;border-right-color:transparent;box-shadow:1px 1px 1px #fff}.swal2-styled{margin:.3125em;padding:.625em 2em;box-shadow:none;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#28a745;color:#fff;font-size:1.0625em}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#aaa;color:#fff;font-size:1.0625em}.swal2-styled:focus{outline:0;box-shadow:0 0 0 2px #fff,0 0 0 4px rgba(50,100,150,.4)}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1.25em 0 0;padding:1em 0 0;border-top:1px solid #eee;color:#545454;font-size:1em}.swal2-image{max-width:100%;margin:1.25em auto}.swal2-close{position:absolute;z-index:2;top:0;right:0;justify-content:center;width:1.2em;height:1.2em;padding:0;overflow:hidden;transition:color .1s ease-out;border:none;border-radius:0;outline:initial;background:0 0;color:#ccc;font-family:serif;font-size:2.5em;line-height:1.2;cursor:pointer}.swal2-close:hover{transform:none;background:0 0;color:#f27474}.swal2-content{z-index:1;justify-content:center;margin:0;padding:0;color:#545454;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em auto}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:100%;transition:border-color .3s,box-shadow .3s;border:1px solid #d9d9d9;border-radius:.1875em;background:inherit;box-shadow:inset 0 1px 1px rgba(0,0,0,.06);color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:0 0 3px #c4e6f5}.swal2-file::-webkit-input-placeholder,.swal2-input::-webkit-input-placeholder,.swal2-textarea::-webkit-input-placeholder{color:#ccc}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file:-ms-input-placeholder,.swal2-input:-ms-input-placeholder,.swal2-textarea:-ms-input-placeholder{color:#ccc}.swal2-file::-ms-input-placeholder,.swal2-input::-ms-input-placeholder,.swal2-textarea::-ms-input-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em auto;background:inherit}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-input[type=number]{max-width:10em}.swal2-file{background:inherit;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:inherit;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{align-items:center;justify-content:center;background:inherit;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{margin:0 .4em}.swal2-validation-message{display:none;align-items:center;justify-content:center;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:\"!\";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;zoom:normal;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}@supports (-ms-accelerator:true){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@-moz-document url-prefix(){.swal2-close:focus{outline:2px solid rgba(50,100,150,.4)}}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:1.25em auto 1.875em;zoom:normal;border:.25em solid transparent;border-radius:50%;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-icon::before{display:flex;align-items:center;height:92%;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-warning::before{content:\"!\"}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-info::before{content:\"i\"}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-question::before{content:\"?\"}.swal2-icon.swal2-question.swal2-arabic-question-mark::before{content:\"؟\"}.swal2-icon.swal2-success{border-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.875em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-progress-steps{align-items:center;margin:0 0 1.25em;padding:0;background:inherit;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;width:2em;height:2em;border-radius:2em;background:#28a745;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#28a745}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;width:2.5em;height:.4em;margin:0 -1px;background:#28a745}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{-webkit-animation:swal2-show .3s;animation:swal2-show .3s}.swal2-show.swal2-noanimation{-webkit-animation:none;animation:none}.swal2-hide{-webkit-animation:swal2-hide .15s forwards;animation:swal2-hide .15s forwards}.swal2-hide.swal2-noanimation{-webkit-animation:none;animation:none}.swal2-rtl .swal2-close{right:auto;left:0}.swal2-animate-success-icon .swal2-success-line-tip{-webkit-animation:swal2-animate-success-line-tip .75s;animation:swal2-animate-success-line-tip .75s}.swal2-animate-success-icon .swal2-success-line-long{-webkit-animation:swal2-animate-success-line-long .75s;animation:swal2-animate-success-line-long .75s}.swal2-animate-success-icon .swal2-success-circular-line-right{-webkit-animation:swal2-rotate-success-circular-line 4.25s ease-in;animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-animate-error-icon{-webkit-animation:swal2-animate-error-icon .5s;animation:swal2-animate-error-icon .5s}.swal2-animate-error-icon .swal2-x-mark{-webkit-animation:swal2-animate-error-x-mark .5s;animation:swal2-animate-error-x-mark .5s}@-webkit-keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}");

/**************************
*** CEP Autopreenchido ****
***************************/
cep    = $('input[name="nCEP"');
rua    = $('input[name="nEndereco"]');
bairro = $('input[name="nBairro"]');
cidade = $('input[name="nCidade"');
uf     = $('input[name="nUF"]');
function limpa_formulário_cep() {
  // Limpa valores do formulário de cep.
  cep.val("");
  rua.val("");
  bairro.val("");
  cidade.val("");
  uf.val("");
}
//Quando o campo cep perde o foco.
$(cep).blur(function() {
  //Nova variável "cep" somente com dígitos.
  var cep = $(this).val().replace(/\D/g, '');

  //Verifica se campo cep possui valor informado.
  if (cep != "") {
    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if(validacep.test(cep)) {

      //Preenche os campos com "..." enquanto consulta webservice.
      $(rua).val("Carregando...").next('label').addClass('fixed');
      $(bairro).val("Carregando...").next('label').addClass('fixed');
      $(cidade).val("Carregando...").next('label').addClass('fixed');
      $(uf).val("Carregando...").next('label').addClass('fixed');

      //Consulta o webservice viacep.com.br/
      $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        if (!("erro" in dados)) {
          //Atualiza os campos com os valores da consulta.
          $(rua).val(dados.logradouro);
          $(bairro).val(dados.bairro);
          $(cidade).val(dados.localidade);
          $(uf).val(dados.uf);
          $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+ cep +"&key=AIzaSyAIiF13uozqAFs__S2CwY8I2ukcEDDe5bo", function(dados) {
            latitude = dados['results'][0]['geometry']['location']['lat'];
            longitude = dados['results'][0]['geometry']['location']['lng'];
            $('input[name="latitude"]').val(latitude);
            $('input[name="longitude"]').val(longitude);
          });
        } //end if.
        else {
          //CEP pesquisado não foi encontrado.
          limpa_formulário_cep();
          Swal.fire({
            type: 'error',
            title: 'Atenção',
            text: 'CEP não encontrado.'
          });
        }
      });
    } //end if.
    else {
      //cep é inválido.
      limpa_formulário_cep();
      Swal.fire({
        type: 'error',
        title: 'Erro',
        text: 'CEP Inválido.'
      });
    }
  } //end if.
});