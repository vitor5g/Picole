//required("./jquery.validate");

var table;
var edit = false;
var editing_id;

$().ready(async function() {

    table = $('#my_table').DataTable({
        "columnDefs": [
            { "targets": [0], "visible": false },
            { "targets": [0], "ordenable": false },
            { "targets": [0], "searchable": false },
            { "targets": 4, "responsivePriority": 1 },
            { "targets": 1, "responsivePriority": 2 },
            { "targets": [1, 2, 3], "className": "text-center" },
            { "targets": [4], "className": "text-center text-nowrap" },
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
        "order": [[1, "asc"]]
    });
    $("#preco").maskMoney({
        allowNegative: true,
        thousands: '.',
        decimal: ',',
        prefix: 'R$ '
      });
    $("#modalFormPicole").validate({
        rules: {
            sabor: {
                required: true
            },
            preco: {
                required: true
            },
            quantidade: {
                min: 1,
                number: true,
                required: true
            }
        },
        messages: {
            sabor: {
                required: "<span style='color:red;'>Preencha este campo</span>"
            },
            preco: {
                required: "<span style='color:red;'>Preencha este campo</span>"
            },
            quantidade: {
                min: "<span style='color:red;'>Somente valores entre 1 e 10 são aceitos</span>",
                number: "<span style='color:red;'>Somente valores númericos são aceitos</span>",
                required: "<span style='color:red;'>Preencha este campo</span>"
            }
        },
        submitHandler: function(form) {
            save_it();
        }
    });
    read();

});



function add() {
    $("#modalFormPicole").validate().resetForm();
    edit = false; // seta o flag para criação
    limpaModal(); //limpa o modal
    removeAlertas(); //remove os alertas
    $('#modal').modal(); //mostra o modal
}

function limpaModal() {
    document.getElementById('sabor').value = ''; //seta o valor do campo nome para ''
    document.getElementById('preco').value = ''; //seta o valor do campo matricula para ''
    document.getElementById('quantidade').value = ''; // ...
}

function removeAlertas() {
    window.setTimeout(function() { //seta um timer para rodar depois de 3 segundos
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

function edit_it(caller) {
    edit = true;
    let data = table.row($(caller).closest('tr')).data();
    limpaModal();
    //console.log(data);
    document.getElementById('sabor').value = data[1];
    document.getElementById('preco').value = data[2];
    document.getElementById('quantidade').value = data[3];
    editing_id = data[0];
    $('#modal').modal();
}

function delete_it(caller) {
     //cria variavel data e armazena nela o conteudo pega naquela tr(linha) vetor de elementos
     let data = table.row($(caller).closest('tr')).data();
     //a variavel recebe o elemento que esta na posição 0 que é o id 
     editing_id = data[0];
     //chama bootbox
     bootbox.confirm({
         title: "Excluir?",
         message: "A exclusão desse picolé excluirá <span style='font-weight: bold;'>todas as vendas relacionadas a ele</span>. Deseja realmente excluir esse picolé?",
         className: 'bounceIn animated',
         buttons:{
             confirm:{
                 label:'Sim',
                 className: 'btn-danger'
             },
             cancel:{
                 label: 'Não',
                 className: 'btn-secondary'
             }
             
         },
 
         callback: function (result){
             //console.log('O valor selecionado foi : ' + result);
             //se o usuario clicar sim entra aqui
             if(result){
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
    obj.sabor = document.getElementById('sabor').value;
    obj.preco = document.getElementById('preco').value;
    obj.quantidade = document.getElementById('quantidade').value;

    removeAlertas();
    $.ajax({

        type: "POST",
        url: "./classes/services/createPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function(response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function(error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function() {
            $('#modal').modal('hide');
            removeAlertas();
        }
    });
}

//update
function update() {
    let obj = {};
    obj.sabor = document.getElementById('sabor').value;
    obj.preco = document.getElementById('preco').value;
    obj.quantidade = document.getElementById('quantidade').value;
    obj.id = editing_id;
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/updatePicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function(response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function(error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function() {
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
        url: "./classes/services/deletePicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: { data: JSON.stringify(obj) },
        success: function(response) {
            //vai rodar aqui se der certo
            console.log(response);
            $('#alerta_sucesso').addClass('show');
            read();
        },
        error: function(error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function() {
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
        url: "./classes/services/readPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function(response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);
            parseData(dados);
        },
        error: function(error) {
            //roda aqui se der errado
            console.log(error);
            document.getElementById('alerta_erro').innerHTML = error.responseText;
            $('#alerta_erro').addClass('show');
        },
        complete: function() {
            removeAlertas();
        }
    });
}



//parse
function parseData(dados) {
    table.clear().draw();
    var lines = Array();
    dados.forEach(function(object, key) {
        lines[key] = [object.id, object.sabor, 'R$ '+object.preco.replace(".",","), object.quantidade, '<img title="editar" src="./img/edit.png" onclick="edit_it(this)" class="img_table"> &nbsp; <img title="remover" src="./img/remove.png" onclick="delete_it(this)" class="img_table">'];
    });
    table.columns.adjust().responsive.recalc();
    table.rows.add(lines).draw(false);
}