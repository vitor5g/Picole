//inicia ao carregar o arquivo chamado no inicio da pagina
$().ready(async function () {
    $('#data_fim').attr("max", new Date().toJSON().split('T')[0]);
    //para validar o modal
    $("#modalFormRelatorio").validate({
        //regras
        rules: {
            data_inicio: {
                //regra que o campo data_inicio é requerido ou seja não pode ser vazio
                required: true
            },
            data_fim: {
                //campo data_fim não pode ser vazio
                required: true
            },
            radiobtn: {
                required: true
            },
            nome_cliente: {
                required: true

            },
            sabor_picole: {
                required: true,

            }

        },
        //personaliza as mensagens das regras
        messages: {
            data_inicio: {
                //se o erro for o campo em branco envia essa mensagem 
                required: "<span style='color:red;'>Por favor selecione uma data</span>"
            },
            data_fim: {
                //se o erro for o campo em branco envia essa mensagem
                required: "<span style='color:red;'>Por favor selecione uma data</span>"
            },
            radiobtn: {
                required: "<span style='color:red;'>Por favor selecione um modelo</span>"
            },
            sabor_picole: {
                required: "<span style='color:red;'>Por favor selecione um Picolé2</span>",
            },
            nome_cliente: {
                required: "<span style='color:red;'>Por favor selecione um Cliente2</span>",
            }

        },

    });

    CarregarSelectCliente();
    CarregarSelectPicole();
});

function mostraSelect(radiobtn) {
    if (radiobtn.value == 'cliente') {

        document.getElementById('divsabor_picole').style.display = 'none';
        document.getElementById('divnome_cliente').style.display = 'block';
        document.getElementById('sabor_picole').value = 'Selecione';

    } else if (radiobtn.value == 'picole') {
        document.getElementById('divnome_cliente').style.display = 'none';
        document.getElementById('divsabor_picole').style.display = 'block';
        document.getElementById('nome_cliente').value = 'Selecione';

    } else {
        document.getElementById('divnome_cliente').style.display = 'none';
        document.getElementById('divsabor_picole').style.display = 'none';
        document.getElementById('nome_cliente').value = 'Selecione';
        document.getElementById('sabor_picole').value = 'Selecione';
    }

}

function CarregarSelectPicole() {
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/readComboBoxRelatorioPicole.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);
            let selectboxPicole = $('#sabor_picole');
            dados.forEach(function (object, key) {
                $('<option>').val(object.sabor_picole).text(object.sabor_picole).appendTo(selectboxPicole);
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

function CarregarSelectCliente() {
    removeAlertas();
    $.ajax({
        type: "POST",
        url: "./classes/services/readComboBoxRelatorioCliente.php",
        dataType: "html",
        async: true,
        timeout: 30000,
        data: {},
        success: function (response) {
            //vai rodar aqui se der certo
            //console.log(response);
            let dados = JSON.parse(response);
            let selectboxCliente = $('#nome_cliente');
            dados.forEach(function (object, key) {
                $('<option>').val(object.nome_cliente).text(object.nome_cliente + "-" + object.apelido_cliente).appendTo(selectboxCliente);
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

function validaData() {
    let data_inicio = document.getElementById('data_inicio').value.split('-');
    data_inicio = new Date(data_inicio[0], data_inicio[1] - 1, data_inicio[2]);
    let data_fim = document.getElementById('data_fim').value.split('-');
    data_fim = new Date(data_fim[0], data_fim[1] - 1, data_fim[2]);

    if (data_inicio > data_fim) {

        bootbox.alert({
            title: "Erro",
            message: "<span style='font-family: Roboto, Helvetica, sans-serif;color: red; font-weight: bold; font-size: 14px;'>A data de início não pode ser maior do que a data fim!</span>",
            className: 'tada animated'

        });
        



    //pega elemento pela classe
    let remover = document.body.getElementsByClassName("modal-backdrop fade show")[0];
    //remove o elemento pego
    document.body.removeChild(remover);
    //pega a div com problema
    let muda = document.body.children[3];
    //remove o nome na tag que estava dando problema
    muda.classList.remove("fade");
    
    }else{
        document.modalFormRelatorio.submit();
    }


}


//função para remover alertas da pagina
function removeAlertas() {
    window.setTimeout(function () { //seta um timer para rodar depois de 3 segundos
        $('#alerta_erro').removeClass('show'); //esconde alerta de erro
        $('#alerta_sucesso').removeClass('show'); //esconde alerta de sucesso
        $('#alerta_wait').removeClass('show'); //esconde alerta de aguarde
        $("#modalFormRelatorio").validate().resetForm();//limpa o formulario dos erros do validate
    }, 5000) //os 5 segundos configura aqui
}