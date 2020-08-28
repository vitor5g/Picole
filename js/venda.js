//required("./jquery.validate");

var table;
var edit = false;
var editing_id;
var total;

$().ready(async function () {
    
    table = $('#my_table').DataTable({

        "columnDefs": [
            { "targets": [3], "className": "details-control", "orderable": false, "data": null, "defaultContent": '' },
            { "targets": [0, 1, 2, 5, 6], "visible": false },
            { "targets": [0, 1, 2, 3, 5, 6], "ordenable": false },
            { "targets": [0, 1, 2, 3], "searchable": false },
            { "targets": 11, "responsivePriority": 1 },
            { "targets": 4, "responsivePriority": 2 },
            { "targets": 5, "responsivePriority": 3 },
            { "targets": 10, "responsivePriority": 4 },
            { "targets": 9, "responsivePriority": 5 },
            { "targets": 8, "responsivePriority": 6 },
            { "targets": 7, "responsivePriority": 7 },
            { "targets": 5, "responsivePriority": 8 },
            { "targets": [3, 4, 6, 7, 8, 9, 10], "className": "text-center" },
            { "targets": [11], "className": "text-center text-nowrap " },
            { "targets": [10], "type": "data-eu" }
        ],
        "oLanguage": {
            "sZeroRecords": "Não foram encontrados resultados",
            "sProcessing": "Processando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoFiltered": "",
            "sUrl": "",
            "sSearch": "Buscar:",
            "sInfoPostFix": "",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sNext": "Seguinte",
                "sLast": "Último"
            }
        },
        responsive: true,
        searching: true,
        paging: true,
        "order": [[8, "asc"]],

    });

    //table.order([[ 8, 'desc']]).draw();
    $("#pagamento").maskMoney({
        allowNegative: true,
        thousands: '.',
        decimal: ',',
        prefix: 'R$ '
    });

    $("#modalFormVenda").validate({
        rules: {
            nome_cliente: {
                required: true,
                number: true
            },
            sabor_picole: {
                required: true,
                number: true
            },
            quantidade: {
                min: 1,
                number: true,
                required: true
            },
            total: {
                disabled: true
            },
            data_venda: {
                disabled: true
            }
        },
        messages: {
            nome_cliente: {
                required: "<span style='color:red;'>Preencha este campo</span>",
                number: "<span style='color:red;'>Preencha este campo</span>"
            },
            sabor_picole: {
                required: "<span style='color:red;'>Preencha este campo</span>",
                number: "<span style='color:red;'>Preencha este campo</span>",
            },
            quantidade: {
                min: "<span style='color:red;'>A quantidade mínima é 1</span>",
                number: "<span style='color:red;'>Somente valores númericos são aceitos</span>",
                required: "<span style='color:red;'>Preencha este campo</span>",
                max: "<span style='color:red;'>Quantidade indisponível </span>"
            },
            total: {
                disabled: "<span style='color:red;'>Este campo esta desabilitado</span>"
            },
            data_venda: {
                disabled: "<span style='color:red;'>Este campo esta desabilitado</span>"
            }
        },
        submitHandler: function (form) {
            save_it();
        }
    });

    // Add event listener for opening and closing details
    $('#my_table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    read();
    CarregarSelectCliente();
    CarregarSelectPicole();

});


function format(d) {
    //`d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; font-family: Roboto, Helvetica, sans-serif;color: black; font-size: 14px;">' +
        '<tr>' +
        '<td>Apelido:</td>' +
        '<td>' + d[5] + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Setor:</td>' +
        '<td>' + d[6] + '</td>' +
        '</tr>' +
        // '<tr>' +
        // '<td>Extra info:</td>' +
        // '<td>And any further details here (images etc)...</td>' +
        // '</tr>' +
        '</table>';
}

function calculaTotal(quantidade) {
    let total = document.getElementById('total');
    let picole = document.getElementById('sabor_picole');

    $.ajax({
        type: "POST",
        url: "./classes/services/readPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);

            dados.forEach(function (object, key) {
                if (picole.value == object.id) {
                    total.value = 'R$ ' + parseFloat(object.preco * quantidade.value).toFixed(2);

                }
            });

        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            removeAlertas();
        }
    });
}
function mostraPreco() {
    let preco = document.getElementById('preco');
    let picole = document.getElementById('sabor_picole');

    $.ajax({
        type: "POST",
        url: "./classes/services/readPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);

            dados.forEach(function (object, key) {
                if (picole.value == object.id) {
                    preco.value = 'R$ ' + parseFloat(object.preco).toFixed(2);
                    document.getElementById('quantidade').value = '';
                    document.getElementById('quantidade').setAttribute('max', object.quantidade);

                }
            });
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            removeAlertas();
        }
    });
}

function dataAtualFormatada() {
    let data = new Date(),
        dia = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0' + dia : dia,
        mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0' + mes : mes,
        anoF = data.getFullYear();
    return anoF + "-" + mesF + "-" + diaF;
}
function formataData(data) {
    data = new Date(data),
        dia = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0' + dia : dia,
        mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0' + mes : mes,
        anoF = data.getFullYear();
    return diaF + "/" + mesF + "/" + anoF;
}
function formataDataEUA(data) {
    data = new Date(),
        dia = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0' + dia : dia,
        mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0' + mes : mes,
        anoF = data.getFullYear();
    return anoF + "-" + mesF + "-" + diaF;
}

function add() {
    $("#modalFormVenda").validate().resetForm();//limpa os erros dos campos
    document.getElementById('data_venda').value = dataAtualFormatada();
    edit = false; // seta o flag para criação
    limpaModal(); //limpa o modal
    removeAlertas(); //remove os alertas
    $('#modal').modal(); //mostra o modal
    $('#data_venda').val(dataAtualFormatada);

}

function limpaModal() {
    document.getElementById('nome_cliente').value = 'Selecione'; //seta o valor do campo nome para ''
    document.getElementById('sabor_picole').value = 'Selecione'; //seta o valor do campo matricula para ''
    document.getElementById('quantidade').value = ''; // ...
    document.getElementById('total').value = ''; // ...
    document.getElementById('data_venda').value = ''; // ...

    document.getElementById('nome_cliente_pagamento').value = ''; // ...
    document.getElementById('sabor_picole_pagamento').value = ''; // ...
    document.getElementById('total_pagamento').value = ''; // ...
    document.getElementById('data_pagamento').value = ''; // ...
    document.getElementById('pagamento').value = ''; // ...



}

function removeAlertas() {
    window.setTimeout(function () { //seta um timer para rodar depois de 3 segundos
        $('#alerta_erro').removeClass('show'); //esconde alerta de erro
        $('#alerta_sucesso').removeClass('show'); //esconde alerta de sucesso
        $('#alerta_wait').removeClass('show'); //esconde alerta de aguarde
    }, 3000) //os 3 segundos configura aqui
}

function save_it() {

    if (edit) { //verificar flag. se editando chama update, se nao, chama o create
        update();
    } else {
        create();
    }
}
function payment_it(caller) {
    let data = table.row($(caller).closest('tr')).data();
    limpaModal();
    document.getElementById('nome_cliente_pagamento').value = data[1];
    document.getElementById('sabor_picole_pagamento').value = data[2];
    document.getElementById('total_pagamento').value = data[9];
    document.getElementById('data_pagamento').value = dataAtualFormatada();
    $('#total_pagamento').attr('disabled', 'disabled');
    $('#nome_cliente_pagamento').attr('disabled', 'disabled');
    $('#sabor_picole_pagamento').attr('disabled', 'disabled');
    editing_id = data[0];
    $('#modalPagamento').modal();
    $("#modalFormPagamento").validate({
        rules: {

            total_pagamento: {
                required: true
            },
            pagamento: {
                required: true
            },
            nome_cliente_pagamento: {
                required: true,
                disabled: true
            },
            sabor_picole_pagamento: {
                required: true,
                disabled: true
            },
        },

        messages: {
            total_pagamento: {
                required: "<span style='color:red;'>Preencha este campo</span>"
            },
            pagamento: {
                required: "<span style='color:red;'>Preencha este campo</span>"
            },
        },
        submitHandler: function (form) {
            payment();
        }
    });

}
function detail_it(caller) {
    let data = table.row($(caller).closest('tr')).data();
    let obj = {};
    obj.id_venda = data[0];
    document.getElementById('nome_cliente_detalhe').innerHTML = data[4];
    $('#modalDetalhe').modal();
    removeAlertas();

    $.ajax({
        type: "POST",
        url: "./classes/services/readPagamento.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function (response) {
            //vai rodar aqui se der certo
            let dados = JSON.parse(response);

            modal_bodyElement = document.querySelector('div.modal-body-detalhe');

            //criando div da row
            divElement = document.createElement('div');
            divElement.setAttribute('class', 'row ');
            divElement.setAttribute('id', 'fake');

            if (dados.length == 0 || dados == null) {

                divDataElement = document.createElement('label');
                divDataElement.setAttribute("style", "margin-left:10%;float:left; text-align:center; line-height:50px;color: red; font-family: Roboto, Helvetica, sans-serif;font-size: 24px;");
                divDataElement.innerHTML = 'Não há infomações de pagamento para o usuario selecionado';
                divElement.appendChild(divDataElement);
                modal_bodyElement.appendChild(divElement);

            }


            dados.forEach(function (object, key) {




                //criando div da data do pagamento col-sm-5
                divDataElement = document.createElement('div');
                divDataElement.setAttribute("style", "margin-left: 0;");
                labelDataElement = document.createElement('label');
                labelDataElementInput = document.createElement('input');
                labelDataElementText = document.createTextNode('Data do pagamento');
                labelDataElement.setAttribute('for', 'data_historico2');
                labelDataElement.setAttribute("style", "font-family: Roboto, Helvetica, sans-serif;color: black;font-size: 14px; color: black;");
                labelDataElementInput.setAttribute("style", "text-align: center; align-items: center; margin: 0 auto;");
                labelDataElementInput.setAttribute("type", "text");
                labelDataElementInput.setAttribute("id", "data_historico2");
                labelDataElementInput.setAttribute("name", "data_historico2");
                labelDataElementInput.setAttribute("class", "form-control");
                labelDataElementInput.setAttribute("disabled", "disabled");
                labelDataElement.appendChild(labelDataElementText);
                divDataElement.setAttribute('class', 'col-sm-3');
                divDataElement.innerHTML = '<br>';
                divDataElement.appendChild(labelDataElement);
                divDataElement.appendChild(labelDataElementInput);



                //criando div do valor do pagamento col-sm-4
                divPagamentoElement = document.createElement('div');
                labelPagamentoElement = document.createElement('label');
                labelPagamentoElementInput = document.createElement('input');
                labelPagamentoElementText = document.createTextNode('Valor Pago (R$)');
                labelPagamentoElement.setAttribute('for', 'pagamento_historico2');
                labelPagamentoElement.setAttribute("style", "font-family: Roboto, Helvetica, sans-serif;color: black;font-size: 14px;");
                labelPagamentoElementInput.setAttribute("style", "text-align: center; align-items: center; margin: 0 auto; color: green;");
                labelPagamentoElementInput.setAttribute("type", "text");
                labelPagamentoElementInput.setAttribute("id", "pagamento_historico2");
                labelPagamentoElementInput.setAttribute("name", "pagamento_historico2");
                labelPagamentoElementInput.setAttribute("class", "form-control");
                labelPagamentoElementInput.setAttribute("disabled", "disabled");
                labelPagamentoElement.appendChild(labelPagamentoElementText);
                divPagamentoElement.setAttribute('class', 'col-sm-3');
                divPagamentoElement.innerHTML = '<br>';
                divPagamentoElement.appendChild(labelPagamentoElement);
                divPagamentoElement.appendChild(labelPagamentoElementInput);

                //criando div do valor do total col-sm-3
                divTotalElement = document.createElement('div');
                labelTotalElement = document.createElement('label');
                labelTotalElementInput = document.createElement('input');
                labelTotalElementText = document.createTextNode('Total da Venda (R$)');
                labelTotalElement.setAttribute('for', 'total_venda2');
                labelTotalElement.setAttribute("style", "font-family: Roboto, Helvetica, sans-serif;color: black;font-size: 14px;");
                labelTotalElementInput.setAttribute("style", "text-align: center; align-items: center; margin: 0 auto; color: black;");
                labelTotalElementInput.setAttribute("type", "text");
                labelTotalElementInput.setAttribute("id", "total_venda2");
                labelTotalElementInput.setAttribute("name", "total_venda2");
                labelTotalElementInput.setAttribute("class", "form-control");
                labelTotalElementInput.setAttribute("disabled", "disabled");
                labelTotalElement.appendChild(labelTotalElementText);
                divTotalElement.setAttribute('class', 'col-sm-3');
                divTotalElement.innerHTML = '<br>';
                divTotalElement.appendChild(labelTotalElement);
                divTotalElement.appendChild(labelTotalElementInput);

                //criando div do valor do total restante col-sm-3
                divRestanteElement = document.createElement('div');
                labelRestanteElement = document.createElement('label');
                labelRestanteElementInput = document.createElement('input');
                labelRestanteElementText = document.createTextNode('Total Restante (R$)');
                labelRestanteElement.setAttribute('for', 'total_restante2');
                labelRestanteElement.setAttribute("style", "font-family: Roboto, Helvetica, sans-serif;color: black;font-size: 14px;");
                labelRestanteElementInput.setAttribute("style", "text-align: center; align-items: center; margin: 0 auto; color: red;");
                labelRestanteElementInput.setAttribute("type", "text");
                labelRestanteElementInput.setAttribute("id", "total_restante2");
                labelRestanteElementInput.setAttribute("name", "total_restante2");
                labelRestanteElementInput.setAttribute("class", "form-control");
                labelRestanteElementInput.setAttribute("disabled", "disabled");
                labelRestanteElement.appendChild(labelRestanteElementText);
                divRestanteElement.setAttribute('class', 'col-sm-3');
                divRestanteElement.innerHTML = '<br>';
                divRestanteElement.appendChild(labelRestanteElement);
                divRestanteElement.appendChild(labelRestanteElementInput);

                //setando os valores
                labelDataElementInput.setAttribute("value", formataData(object.data_pagamento));
                labelPagamentoElementInput.setAttribute("value", "R$ " + object.valor_pagamento);
                labelTotalElementInput.setAttribute("value", "R$ " + object.total_venda);
                labelRestanteElementInput.setAttribute("value", "R$ " + parseFloat(object.total_venda - object.valor_pagamento).toFixed(2));

                //inserindo na div row
                divElement.appendChild(divDataElement);
                divElement.appendChild(divPagamentoElement);
                divElement.appendChild(divTotalElement);
                divElement.appendChild(divRestanteElement);





                modal_bodyElement.appendChild(divElement);
            });

        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
            removerDiv();
        },
        complete: function () {
            $('#modalDetalhe').modal('hide');
            removeAlertas();
        }

    });


}

$('#modalDetalhe').focusout(function () {
    removerDiv();
});


function removerDiv() {

    //alert('saiu porra');
    document.getElementById("fake").remove();
    $('#modalDetalhe').modal('hide');


}

function payment() {
    let obj = {};
    obj.valor_pagamento = document.getElementById('pagamento').value.replace("R$", "").replace(",", ".");
    obj.total_venda = document.getElementById('total_pagamento').value.replace("R$", "");
    obj.id_venda = editing_id;
   
    removeAlertas();

    $.ajax({
        type: "POST",
        url: "./classes/services/createPagamento.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function (response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            $('#modalPagamento').modal('hide');
            removeAlertas();
        }
    });
}

function edit_it(caller) {
    edit = true;
    let data = table.row($(caller).closest('tr')).data();
    limpaModal();
    console.log(data);
    document.getElementById('nome_cliente').value = data[1];
    document.getElementById('sabor_picole').value = data[2];
    document.getElementById('quantidade').value = data[6];
    document.getElementById('total').value = data[9];
    document.getElementById('data_venda').value = formataDataEUA(data[8]);
    $('#data_venda').attr('disabled', 'disabled');
    $('#total').attr('disabled', 'disabled');
    $('#preco').attr('disabled', 'disabled');
    editing_id = data[0];
    $('#modal').modal();
    mostraPreco();
}

function delete_it(caller) {
    //cria variavel data e armazena nela o conteudo pega naquela tr(linha) vetor de elementos
    let data = table.row($(caller).closest('tr')).data();
    //a variavel recebe o elemento que esta na posição 0 que é o id 
    editing_id = data[0];
    //chama bootbox
    bootbox.confirm({
        title: "Excluir?",
        message: "Deseja realmente excluir essa Venda?",
        className: 'bounceIn animated',
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-danger'
            },
            cancel: {
                label: 'Não',
                className: 'btn-secondary'
            }

        },

        callback: function (result) {
            //console.log('O valor selecionado foi : ' + result);
            //se o usuario clicar sim entra aqui
            if (result) {
                //chama a função deleta
                deleta();
            }

        }

    });
    //pega elemento pela classe
    let remover = document.body.getElementsByClassName("modal-backdrop fade show")[0];
    //remove o elemento pego
    document.body.removeChild(remover);
    //pega a div com problema
    let muda = document.body.children[3];
    //remove o nome na tag que estava dando problema
    muda.classList.remove("fade");
}


//create
function create() {
    let obj = {};
    obj.id_cliente = document.getElementById('nome_cliente').value;
    obj.id_picole = document.getElementById('sabor_picole').value;
    obj.quantidade = document.getElementById('quantidade').value;
    obj.preco = document.getElementById('preco').value.replace("R$", "");
    removeAlertas();
    $.ajax({

        type: "POST",
        url: "./classes/services/createVenda.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            $('#modal').modal('hide');
            removeAlertas();
        }
    });
}

//update
function update() {
    let obj = {};
    obj.id_cliente = document.getElementById('nome_cliente').value;
    obj.id_picole = document.getElementById('sabor_picole').value;
    obj.quantidade = document.getElementById('quantidade').value;
    obj.preco = document.getElementById('preco').value.replace("R$", "");
    obj.id = editing_id;
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/updateVenda.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function (response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            $('#modal').modal('hide');
            removeAlertas();
        }
    });
}

//delete
function deleta() {
    let obj = {};
    obj.id = editing_id;
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/deleteVenda.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function (response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            $('#modal').modal('hide');
            removeAlertas();
        }
    });
}

//read
function read() {

    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/readVenda.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            let dados = JSON.parse(response);

            parseData(dados);
        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            removeAlertas();
        }
    });
}

function CarregarSelectCliente() {
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/readComboBoxVendaCliente.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);
            let selectboxCliente = $('#nome_cliente');
            let selectboxCliente_pagamento = $('#nome_cliente_pagamento');
            
            dados.forEach(function (object, key) {
                $('<option>').val(object.id_cliente).text(object.nome_cliente + " " + object.sobrenome_cliente + " - " + object.apelido).appendTo(selectboxCliente);
                $('<option>').val(object.id_cliente).text(object.nome_cliente + " " + object.sobrenome_cliente + " - " + object.apelido).appendTo(selectboxCliente_pagamento);
            });

        },
        error: function (error) {

            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            removeAlertas();
        }
    });
}

function CarregarSelectPicole() {
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/readComboBoxVendaPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);
            let selectboxPicole = $('#sabor_picole');
            let selectboxPicole_pagamento = $('#sabor_picole_pagamento');
            dados.forEach(function (object, key) {
                $('<option>').val(object.id_picole).text(object.sabor_picole).appendTo(selectboxPicole);
                $('<option>').val(object.id_picole).text(object.sabor_picole).appendTo(selectboxPicole_pagamento);
            });

        },
        error: function (error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function () {
            removeAlertas();
        }
    });
}

//parse
function parseData(dados) {
    table.clear().draw();
    var lines = Array();
    dados.forEach(function (object, key) {
        lines[key] = [object.id, object.id_cliente, object.id_picole, '', object.nome_cliente + " " + object.sobrenome_cliente, object.apelido_cliente, object.setor, object.sabor_picole, object.quantidade, 'R$ ' + parseFloat(object.total_venda).toFixed(2), formataData(object.data_venda), ' <img title="pagar" src="./img/payment.png" onclick="payment_it(this)" class="img_table"> &nbsp; <img title="detalhes" src="./img/detail.png" onclick="detail_it(this)" class="img_table"> &nbsp;  <img title="editar" src="./img/edit.png" onclick="edit_it(this)" class="img_table"> &nbsp; <img title="remover" src="./img/remove.png" onclick="delete_it(this)" class="img_table">'];
    });
    table.rows.add(lines).draw(false);
    table.columns.adjust().responsive.recalc();
}

//<img title="expandir" src="./img/details_open.png" class="details-control" onclick="expandir(this)" >