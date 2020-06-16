// https://javascriptobfuscator.com/Javascript-Obfuscator.aspx
/* Hora */

/* OBJETO ENVIO DA MENSAGEM */
var conversation = document.querySelector('.conversation-container');
/* ************************ */

var messageTime = document.querySelectorAll('.message .time');

setInterval(function () {

    /* https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js */
    messageTime.innerHTML = moment().format('HH:mm');

}, 1000);

for (var k = 0; k < messageTime.length; k++) {
    messageTime[k].innerHTML = moment().format('HH:mm');
}

// VARIÁVEIS GLOBAIS

var nomepesquisado = '';              // UTILIZADA PARA INFORMAR AO SISTEMA QUE O OPERADOR UTILIZOU UMA PESQUISA COM BASE
// NO NOME OU PARTE DO NOME EXISTENTE NA VARIÁVEL LIKE
var hoje = "";
var ontem = "";

var nome_arquivo_enviado = "";       // NOME DO ARQUIVO ENVIADO PARA SER UTILIZADO NA ROTINA DE ENVIO

var extensao = "";                   // EXTENSÃO DO ARQUIVO ENVIADO PARA SER UTILIZADO NA ROTINA DE ENVIO

// *****************

var statusconexao = 0;               // Variável que orienta o intervalo para verificação do status da conexão


function StartApp() {

    // $("#myAlert .modal-body").text('Entrando na janela principal');
    // $('#myAlert').modal('show');

    // 30/01/2019
    // Biblioteca Javascript para manipulação de data e hora
    // http://momentjs.com/
    // http://www.matera.com/blog/post/primeiros-passos-com-moment-js
    // moment.locale('pt-BR');

    hoje = moment().format("DD/MM/YYYY");
    ontem = moment().subtract(1, 'days').startOf('day').toString();
    ontem = moment(ontem).format("DD/MM/YYYY");
    // alert(hoje);
    // alert(ontem);
    // ************************

    // Esconde o label de enviar arquivo
    $("#lbl-enviar-arquivo").hide();


    //Desabilita os botões
    $('#btnAcessarTransferencia').prop('disabled', true);
    $('#btnAcessarAlterarTelefone').prop('disabled', true);
    $('#btnAcessarTransferirTContatos').prop('disabled', true);
    $('#btnAcessarExclusaoContato').prop('disabled', true);
    //****************************************************


    NotifyMe();

    Pesquisa_Contatos('');

    verifica_status(); 	//21/02/2020
}

function formatDate(data, formato) {

    // ROTINA DE FORMATAÇÃO DE DATA PADRÃO DD/MM/YYYY

    if (formato == 'pt-br') {
        return (data.substr(0, 10).split('-').reverse().join('/'));
    } else {
        return (data.substr(0, 10).split('/').reverse().join('-'));
    }
}


function TheMenu() {

    document.getElementById("myDropdown").classList.toggle("show");
}

//Fecha o dropdown (Menu) se o usuário clicar fora dele
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
// *****************************************************


$(document).ready(function () {

    //Início do MENU 


    $(".dropdown-content a").click(function () {

        var opcao = $(this).text();             // Texto
        var selText = $(this).attr('href');     // Atributo de href


        // Menu de Notificação
        if (selText === '#notificacao') {

            if (opcao == 'Ativar Alerta Sonoro') {
                if (Altera_Alerta_Sonoro("-1")) {
                }
            } else {
                if (Altera_Alerta_Sonoro("0")) {
                }
            }

        }
        // **************************************


        if (selText === '#logout') {

            var modalConfirm = function (callback) {

                $("#myConfirm .modal-body").text('Confirma a saída ?');
                $("#myConfirm").modal('show');

                $("#modal-btn-si").on("click", function () {
                    callback(true);
                    $("#myConfirm").modal('hide');
                });

                $("#modal-btn-no").on("click", function () {
                    callback(false);
                    $("#myConfirm").modal('hide');
                });
            };

            modalConfirm(function (confirm) {
                if (confirm) {

                    $(location).attr('href', 'logout.php');
                } else {

                }
            });

        }


    });
    //Fim do MENU

    // Início Excluir
    $(".dropdown-excluir-content a").click(function () {
        // var selText = $(this).text();        // Texto
        var selText = $(this).attr('href');     // Atributo de href
        // alert(selText);
        // alert('Fazer rotina de ' + selText);
    });
    // Fim de Excluir


    $('#txtPesquisa').on('keypress', function (e) {
        //Caixa de texto da Pesquisa de Contato
        var code = e.keyCode || e.which;
        // if(e.which == 13){
        if (code == 13) {
            //

            e.preventDefault;

            var nome = $("#txtPesquisa").val();
            // alert(nome);

            Pesquisa_Contatos(nome);

        }
    });
    // Fim da rotina de pesquisa de contato

    // Click no contato
    // $("#contacts ul").click(function(){
    // $("ul#myContacts").click(function(){
    $("ul#myContacts").on('click', function () {
        // $("li").click(function(){
        $("li").on('click', function () {
            var telefone = this.id;
            var texto = $(this).text();

            //31/05/2019		
            var botao = 0;

            $('li').mousedown(function (event) {

                switch (event.which) {
                    case 1:
                        //Botão esquerdo
                        botao = 1;
                        this.preventDefault;
                        break;

                    case 3:
                        //Botão direito
                        botao = 3;
                        this.preventDefault;
                        Carrega_Modal_Alteracao_Nome(telefone);
                        break;
                }
            })


            if (botao == 0 || botao == 1) {
                if (telefone != $('#txtTelefoneAtivo').val()) //Se o Contato escolhido for diferente do ativo
                {


                    Atualiza_Status_Contato(telefone);


                    //Limpa todas possíveis linhas ativas
                    $('ul li').removeClass('active');
                    //Marca a linha clicada como ativa
                    $(this).addClass('active');

                    // Ativando select tags
                    $('#tag').removeAttr('disabled');

                    var contato_ativo = texto.replace(telefone, "");

                    $('#contact-profile span').text(contato_ativo.trim());

                    // Informa em campos escondidos o Contato ativo e respectivo telefone
                    $('#txtContatoAtivo').val(contato_ativo.trim());
                    $('#txtTelefoneAtivo').val(telefone);
                    //*******************************************************************

                    // Remove todas as mensagens na lista de mensagem
                    // var qtdmsg = $('#bulk .message').length // Quantidade de mensagens
                    // alert(qtdmsg);

                    // TESTE PARA VERIFICAR SE NÃO TRAVA- 11/01/2020
                    $('body').css({height: '0px'});
                    $(".message").load('');
                    // *********************************************

                    $(".message").remove();

                    //
                    //****************************************

                    // Dá um refresh nos botões de selecionar e enviar arquivos pois o usuário pode não ter enviado o arquivo
                    $("#lbl-selecao-arquivo").show();         // Mostra o Label e o botão de selecionar arquivo ??????????
                    $("#lbl-enviar-arquivo").hide();          // Esconde o Label de enviar arquivo
                    // ************************************************

                    //Habilita o botão de upload
                    $('#selecao-arquivo').prop('disabled', false);


                    Carrega_Mensagens();

                    if (nomepesquisado != '') {
                        // Se a variável nome pesquisado estiver diferente de '' significa que o contato que o operador
                        // está clicando foi objeto de pesquisa
                        // Assim que o contato for clicado deverá preencher com o restante dos contatos
                        // alert(nomepesquisado);
                        nomepesquisado = $('#txtTelefoneAtivo').val(); //setando o telefone como valor de busca padrão
                        Complementa_Lista_Contatos();
                        nomepesquisado = "";

                    }

                }
            }


            this.preventDefault;
            //30/01/2019
            $(this).off(event);

            //Envia o foco para a caixa de nova mensagem
            $("#txtNewMessage").focus();
        });

    });

    //*************************************

    //Acesso à transferência
    //Carrega os operadores
    $('#btnAcessarTransferencia').click(function () {
        /* Bootstrap tem poucas funções que podem ser chamadas manualmente em modals:
            https://getbootstrap.com/docs/3.4/javascript/
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
            $('#myModal').modal('hide');
        */

        Carrega_Atendentes();
    });

    // Fim do acesso à transferência

    //Transfere cliente para outro operador
    //Botão Transferir do modal
    $('#btnTransfereClientes').click(function () {
        //id anterior = btnTransfereMSG
        Transfere_Contato(); 	                    //17/07/2019 - Alterado o nome da função
    });

    // Fim da transferência de cliente


    // 31/05/2019
    // Altera nome do contato

    $('#btnAlteraNome').click(function () {
        // Botão de alterar nome
        Altera_Nome_Contato();
    });

    //Digitando na caixa de texto com novo nome
    $('#txtNovoNome').on('keypress', function (e) {

        // 31/05/2019-B 
        // No campo nome da Troca de Nome do Contato, somento permite letra, número, espaço, nada,ponto e ()
        var inputValue = event.charCode;
        if (!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)
            || (inputValue == 32) || (inputValue == 0 || inputValue == 40 || inputValue == 41 || inputValue == 46 ||
                (inputValue > 47 && inputValue < 58)))) {
            event.preventDefault();
        }
        //***************************************************************************************************

        $('#spanAlteraNome').html('&nbsp');

    })

    // Fim da alteração do nome do contato


    // 31/05/2019-B
    // Botão Adicionar contato

    $('#btnAddContact').click(function () {
        Carrega_Modal_Adicionar_Contato();
    });

    //Digitando na caixa de texto com o telefone do novo contato
    $('#txtAdicionarContatoTelefone').on('keypress', function (e) {

        // No campo nome da Adição de Contato, somento permite letra, número, espaço, nada,ponto e ()
        var inputValue = event.charCode;
        if (!((inputValue > 47 && inputValue < 58))) {
            event.preventDefault();
        }
        //***************************************************************************************************

        $('#spanAdicionarContato').html('&nbsp');

    })

    //Digitando na caixa de texto com o nome do novo contato
    $('#txtAdicionarContatoNome').on('keypress', function (e) {

        // No campo nome da Adição de Contato, somento permite letra, número, espaço, nada,ponto e ()
        var inputValue = event.charCode;
        if (!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)
            || (inputValue == 32) || (inputValue == 0 || inputValue == 40 || inputValue == 41 || inputValue == 46 ||
                (inputValue > 47 && inputValue < 58)))) {
            event.preventDefault();
        }
        //***************************************************************************************************

        $('#spanAdicionarContato').html('&nbsp');

    })

    //Digitando na caixa de texto mensagem para o  novo contato
    $('#txtAdicionarContatoMsg').on('keypress', function (e) {

        // No campo mensagem da Adição de Contato, somento permite letra, número, espaço, nada,ponto e ()
        var inputValue = event.charCode;
        if (!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)
            || (inputValue == 32) || (inputValue == 0 || inputValue == 40 || inputValue == 41 || inputValue == 46 ||
                inputValue == 58 || inputValue == 63 || inputValue == 93 || (inputValue > 47 && inputValue < 58) || (inputValue > 191 && inputValue < 256) ||
                (inputValue > 31 && inputValue < 34) || (inputValue > 43 && inputValue < 47)))) {
            event.preventDefault();
        }
        //***************************************************************************************************


        $('#spanAdicionarContato').html('&nbsp');

    })

    $('#btnAdicionaContato').bind('click', function () {


        $('#spanAdicionarContato').text('Por favor, aguarde verificação no WhatsApp');
        // FOI UTILIZADO SETTIMEOUT ( 2 SEGUNDOS ) PARA PODER TROCAR A MENSAGEM DO SPAN
        setTimeout(function () {

            // $('#spanAdicionarContato').text('Por favor, aguarde verificação no WhatsApp');


            Verifica_WhatsApp();


        }, 2000);


    });

    // Fim das rotinas de adicionar contato

    // Rotina Alterar Telefone Contato

    $('#btnAcessarAlterarTelefone').click(function () {
        Carrega_Modal_Alterar_Telefone();
    })

    $('#txtNovoTelefone').on('keypress', function (e) {
        //Permite somente números
        var inputValue = event.charCode;
        if (!((
            (inputValue > 47 && inputValue < 58)))) {
            event.preventDefault();
        }
        //***************************************************************************************************
        $('#spanAlteraTelefone').html('&nbsp');
    })

    $('#btnAlteraTelefone').click(function () {
        Altera_Telefone_Contato();
    })

    // Fim da Rotina Alterar Telefone Contato


    //Rotina Excluir Contato 

    $('#btnAcessarExclusaoContato').click(function () {
        Carrega_Modal_Excluir_Contato();

    })

    $('#btnConfirmaExclusao').click(function () {
        Exclui_Contato();
    })

    // Fim da rotina excluir contato

    //17/07/2019
    //Acesso à transferência de todos os contatos
    //Carrega os operadores
    $('#btnAcessarTransferirTContatos').click(function () {
        /* Bootstrap tem poucas funções que podem ser chamadas manualmente em modals:
            https://getbootstrap.com/docs/3.4/javascript/
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
            $('#myModal').modal('hide');
        */

        Carrega_Modal_TransferirTodos_Contatos();
    });

    $('#btnTransfereTodosContatos').click(function () {
        Transfere_Todos_Contatos();
    });

    //Fim do acesso à transferência de todos os contatos


    //Click na imagem da mensagem
    // Rotina para mostrar imagem quando há várias no mesmo html
    $('#myModalImg').on('show.bs.modal', function (e) {
        var image = $(e.relatedTarget).attr('src');
        $(".img-responsive").attr("src", image);
    });

    //Fim do Click na imagem da mensagem


    $('#txtNewMessage').on('keypress', function (e) {
        // TEXTAREA DA MENSAGEM EM CASO DE PRESSIONAR A TECLA --> ENTER
        var code = e.keyCode || e.which;

        if (code == 13) {
            // SE PRESSIONAR A TECLA ENTER, ENVIA UM CLICK PARA O BOTÃO DE ENVIO
            e.preventDefault;
            $('.send').click();
            // *****************************************************************

            // TEM QUE INFORMAR ESSA LINHA PARA QUE A CAIXA DE MENSAGEM RESETE CORRETAMENTE
            // CONCOMITANTEMENTE COM A FUNÇÃO --> BLUR NA LINHA $("#txtNewMessage").val('').blur();
            // DA FUNÇÃO ENVIAR_MENSAGEM
            return false;
            // ************************************************************************************
        }

    });


    // UPLOAD DE ARQUIVOS
    extensao = "";

    $('input[type="file"]').change(function () {
        if ($(this).val()) {
            // VERIFICA SE HÁ ARQUIVO INFORMADO
            // O BOTÃO FICA DESABILITADO ATÉ QUE HAJA UM CONTATO ATIVO

            // SOMENTE SÃO PERMITIDOS UPLOADS DE ARQUIVOS QUE NÃO POSSAM GERAR
            // INSTABILIDADE NO SISTEMA E/OU NOS DESTINATÁRIOS
            extensao = this.value.match(/\.(.+)$/)[1];                    // VARIÁVEL GLOBAL

            switch (extensao) {
                case 'jpg':
                case 'jpeg':
                // case 'bmp':
                case 'png':
                // case 'gif':
                case 'pdf':
                case 'txt':
                // case 'zip':
                // case 'rar':
                // case 'rtf':
                case 'doc':
                // case 'docx':
                case 'xls':
                // case 'xlsx':
                case 'mp3':
                    //case 'mp4':
                    //case 'ogg':
                    //case 'oga':
                    //case 'avi':
                    var filename = $(this).val();

                    $("#lbl-selecao-arquivo").hide();            // Esconde o label de selecionar arquivo
                    $("#selecao-arquivo").hide();                // Esconde o botão de selecionar arquivo

                    $("#lbl-enviar-arquivo").show();

                    break;
                default:

                    $("#myAlert .modal-body").text('O envio desse tipo de arquivo não é permitido.');
                    $('#myAlert').modal('show');
                    this.value = '';
                    Limpa_Arquivos_Selecionados();

            }
        }
    });

    // ENVIO DO ARQUIVO
    $('#lbl-enviar-arquivo').on('click', function (e) {
        // O LABEL  FICA INVISÍVEL ATÉ QUE HAJA UM ARQUIVO PARA SER ENVIADO
    });


    $('#lbl-enviar-arquivo').mousedown(function (event) {

        switch (event.which) {
            case 1:            // BOTÃO ESQUERDO DO MOUSE // ENVIA ARQUIVO
                Processa_Upload();
                event.preventDefault
                break;
            case 3:           // BOTÃO DIREITO DO MOUSE
                // CASO O USUÁRIO DESISTIR DE ENVIAR O ARQUIVO SELECIONADO
                // DEVE PRESSIONAR O BOTÃO DIREITO DO MOUSE PARA LIMPAR A SELEÇÃO E RETORNAR AO NORMAL
                Limpa_Arquivos_Selecionados();
                break;
            default:

        }
    });

    // FIM DE UPLOAD DE ARQUIVO  ***********************************************


    // E O USUÁRIO FECHAR ONAVEGADOR OU A ABA ONDE O SISTEMA ESTÁ NAVEGANDO
    // FAZ LOGOUT
    // O USUÁRIO TEM QUE AGUARDAR 1 MINUTO PARA ACESSAR NOVAMENTE

    window.addEventListener("beforeunload", function (e) {
        $.ajax({
            type: "POST",
            url: 'logout.php',
            async: false
        });

    });

    // ********************************************************************


    $('#divCopiar').click(function () {
        alert("Clicou no botão");

    })


    //***************************************************** 

    // PROCURA POR NOVAS MENSAGENS A CADA 10 SEGUNDOS
    setInterval(chat_api, 10000); //10000 MS == 10 segundos
    // ****************************************************

    // VERIFICA SE O TELEFONE ESTÁ CONECTADO	
    // setInterval(verifica_status, 120000); //120000 MS == 2 minutos ASSÍNCRONO
    // **********************************************************************

});


function verifica_status() {


    $.ajax({
        type: 'POST',
        url: 'status_verification.php',
        dataType: 'json',
        async: true,
        success: function (response) {

            if (response.success == true) {
                $("#divStatus").css('background-color', "#1DDB5F");
                $('#divStatus').text("TELEFONE CONECTADO");
                $("#divStatus").css('color', "#FFFFFF");
                $('#txtNewMessage').prop('disabled', false);
                $('.send').prop('disabled', false);
                $('#selecao-arquivo').prop('disabled', false);
                $('#lbl-selecao-arquivo').prop('disabled', false);
                $("#lbl-enviar-arquivo").prop('disabled', false);
            } else {

                $("#divStatus").css('background-color', "#FF1A2D");
                $('#divStatus').text("TELEFONE DESCONECTADO");
                $("#divStatus").css('color', "#FFFFFF");
                $("#txtNewMessage").val('').blur();                // LIMPA A CAIXA DA NOVA MENSAGEM E RESETA O PLACEHOLDER
                $('#txtNewMessage').prop('disabled', true);        // DESABILITA A CAIXA DE MENSAGENS
                $('.send').prop('disabled', true);                 // BOTÃO DE ENVIAR FICA DESABILITADO
                $('#selecao-arquivo').prop('disabled', true);      // BOTÃO DE ESCOLHER ARQUIVO FICA DESABILITADO
                $('#lbl-selecao-arquivo').prop('disabled', true);  // LABEL DO ÍCONE ANEXAR
                $("#lbl-enviar-arquivo").prop('disabled', true);   // LABEL DO ÍCONE ENVIAR

            }
        }
    })

}


function chat_api() {


    var telefone = $('#txtTelefoneAtivo').val();
    telefone = telefone.trim();

    if (telefone != '') {
        // SE HOUVER TELEFONE ATIVO OU SEJA, SE O CONTATO ESTIVER ATIVO
        // CAPTURA AS NOVAS MENSAGENS DO CONTATO ATIVO GRAVADAS PELO WEBHOOK NO BANCO MYSQL
        // E ASSIM COMO SUAS MENSAGENS QUE FORAM ENVIADAS E AINDA NÃO FORAM DISPONIBILIZADAS NA TELA
        // A PARTIR DO ÚLTIMO ID INDICADO

        Verifica_Novas_Mensagens_Contato_Ativo();
        //**************************************************************************************************

        // DEPOIS, VAI VERIFICAR SE EXISTEM NOVAS MENSAGENS PARA MODIFICAR O POSICIONAMENTO DA COLUNA DE CONTATOS
        Verifica_Nova_Msg_Recebida_Contato_Geral();
        //***************************************************************************************************
    } else {
        // SE NÃO HOUVER TELEFONE ATIVO OU SEJA, SE O CONTATO NÃO ESTIVER ATIVO
        // VAI VERIFICAR SE EXISTEM NOVAS MENSAGENS PARA MODIFICAR O POSICIONAMENTO DA COLUNA DE CONTATOS
        Verifica_Nova_Msg_Recebida_Contato_Geral();
        //***************************************************************************************************
    }

    verifica_status();            //25/02/2020

}


function Verifica_Novas_Mensagens_Contato_Ativo() {

    // ESSA FUNÇÃO VERIFICA AS MENSAGENS ENVIADAS E RECEBIDAS
    // PELO TELEFONE DO CONTATO ATIVO  APÓS A MENSAGEM TER SIDO ENVIADA


    var telefone = $('#txtTelefoneAtivo').val();  // TELEFONE DO CONTATO ATIVO
    telefone = telefone.trim();                   // LIMPA OS ESPAÇOS EM BRANCO

    var ultimoid = $('#txtUltimoId').val();      // ÚLTIMO ID NO MOMENTO DO CONTATO ATIVO

    ultimoid = ultimoid.trim();

    if (telefone != '' && ultimoid != '') {


        $.ajax({
            type: 'POST',
            url: 'search_newmsg.php',
            data: {telefone: telefone, ultimoid: ultimoid},
            dataType: 'json',
            async: true,
            success: function (response) {

                // if (response.length > 0 ) {

                if (response) {


                    Informa_Nova_Msg_Recebida();

                    var qtdanteriormsg = $('#txtQtdMsg').val();
                    var qtdachadas = response.length;
                    var qtdmensagens = parseInt(qtdanteriormsg) + parseInt(qtdachadas);


                    $('#txtQtdMsg').val(qtdmensagens);

                    // Se o contato tiver mensagens, habilita o botão de Acessar Transferência
                    $('#btnAcessarTransferencia').prop('disabled', false);
                    //19/02/2020
                    // Se o contato tiver mensagens, habilita o botão de Transferência de Todos os contatos
                    $('#btnAcessarTransferirTContatos').prop('disabled', false);
                    //***********************************************************************

                    // Selecionando a tag corrente
                    ws_tag_selected(response[response.length - 1].tag_id);
                    
                    for (var i = 0; response.length > i; i++) {

                        // Guarda o último id da mensagem registrado no mySQL quando se clica no contato
                        $('#txtUltimoId').val(response[i].id);
                        // *****************************************************************************


                        if (response[i].entrada_saida === "1") {
                            // ENVIADA

                            var msg_enviada = utf8_decode(response[i].mensagem);
                            var hora_enviada = response[i].hora_msg;
                            var tipo_enviada = response[i].tipo_mensagem;
                            var id_enviada = response[i].id;                   // Verdadeiro ID da mensagem enviada

                            var nome_arquivo = utf8_decode(response[i].arquivo);
                            var referencia = utf8_decode(response[i].referencia);
                            // MONTA A CAIXA DE MENSAGEM
                            var message = buildMessageSentRecorded(msg_enviada, hora_enviada, tipo_enviada, id_enviada, nome_arquivo, referencia);
                            // *************************

                            // APRESENTA A MENSAGEM NA TELA
                            conversation.appendChild(message);
                            // ****************************

                        } else {
                            // RECEBIDA

                            var msg_recebida = utf8_decode(response[i].mensagem);
                            var hora_recebida = response[i].hora_msg;
                            var tipo_recebida = response[i].tipo_mensagem;
                            var id_recebida = response[i].id;

                            var nome_arquivo = utf8_decode(response[i].arquivo);
                            var referencia = utf8_decode(response[i].referencia);

                            var message = buildMessageReceivedRecorded(msg_recebida, hora_recebida, tipo_recebida, id_recebida, nome_arquivo, referencia);

                            conversation.appendChild(message);

                            // 18/02/2020
                            // Como a mensagem recebida é do contato ativo que está enviando
                            // e recebendo mensagens, atualiza o status = 1
                            Atualiza_Status_Contato(telefone)
                            //**************************************************************

                            // Não existe animação nessa função porque buildMessageReceivedRecorded mostra somente um tick sem transição
                            // animateMessage(message);
                            // *********************************************************************************************************
                        }


                    }  // Fim do loop

                    $("#txtNewMessage").focus();

                    conversation.scrollTop = conversation.scrollHeight;

                }


            }
        })


    } //Fim do if inicial de Ajax


}

function Verifica_Nova_Msg_Recebida_Contato_Geral() {

    // ESSA FUNÇÃO TEM POR OBJETIVO VERIFICAR SE EXISTEM NOVAS MENSAGENS PARA MODIFICAR
    // O POSICIONAMENTO DA COLUNA DE CONTATOS

    var achounovaposicao = 0;

    var telefoneativo = $('#txtTelefoneAtivo').val();
    telefoneativo = telefoneativo.trim();


    $.ajax({
        type: 'POST',
        url: 'search_status.php',
        data: '',
        dataType: 'json',
        async: true,
        success: function (response) {


            if (response) {

                $('#btnAcessarTransferencia').prop('disabled', false);
                // Se o contato tiver mensagens, habilita o botão de Transferência de Todos os contatos
                $('#btnAcessarTransferirTContatos').prop('disabled', false);
                //***********************************************************************
                //***********************************************************************

                for (var i = 0; response.length > i; i++) {
                    // alert("Telefone : " + response[i].numero + "  Status : " + response[i].status);

                    if (response[i].status === '0') {
                        // HÁ UMA NOVA MENSAGEM PARA O CONTATO
                        var span = "#SPAN" + response[i].numero;

                        // alert(span);

                        if ($(span).length) {
                            // SE O SPAN EXISTE, SIGNIFICA QUE EXISTE MENSAGEM(NS) NÃO LIDA(S) E ESTÁ CORRETAMENTE INFORMADA
                            // alert("O <SPAN> existe. Então a informação com a bolinha está correta") ;
                        } else {

                            if (telefoneativo != response[i].numero) {
                                //HÁ UMA NOVA MENSAGEM E O CONTATO DA COLUNA ESTÁ COMO SEM MENSAGENS NÃO lidas
                                //A COLUNA DEVERÁ SER REESTRUTURADA SE A NOVA MENSAGEM FOR PARA UM TELEFONE NÃO ATIVO
                                //ou NÃO HOUVER TELEFONE ATIVO

                                achounovaposicao = 1;
                                break;               // Sai logo do loop
                            }
                        }
                    }


                }  //for(var ...

                if (achounovaposicao === 1) {
                    // alert("Deverá ser reestruturada a coluna de contatos");

                    // REMOVE QUALQUER LINHA DA COLUNA DE CONTATOS QUE INIDCA QUE O CONTATO ESTÁ ATIVO
                    // NUMA CONVERSA
                    $('ul li').removeClass('active');
                    // ********************************************************************************

                    Refaz_Lista_Contatos();

                } else {
                    // alert("Nada a fazer");
                }
            }

        }

    })


}


function NotifyMe() {

    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        $("#myAlert .modal-body").text('Esse navegador não suporta notificação desktop');
        $('#myAlert').modal('show');
    }

    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification


    }

        // Otherwise, we need to ask the user for permission
        // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {

            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }

            // If the user is okay, let's create a notification
            if (permission === "granted") {


            }
        });
    }

    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother him any more.
}

function Informa_Nova_Msg_Recebida() {

    // https://w3c.github.io/page-visibility/
    // hidden = The Document is not visible at all on any screen.
    // prerender = The Document is loaded in the prerender mode and is not yet visible.
    // visible = The Document is at least partially visible on at least one screen. 
    //           This is the same condition under which the hidden attribute is set to false.

    if (document.visibilityState == "hidden") {
        // Somente aparece o popup e o som de nova notificação se o usuário estiver
        // com o browser minimizado OU em outra página

        var notification = new Notification("WhatsCompany", {
            icon: 'images/notificacao.png',
            body: "Nova mensagem recebida 1 ."
        });

        if ($('#txtNotificacao').val() == "-1") {
            var x = document.getElementById("alertSound");
            x.play();
        }

    }

}


function Pesquisa_Contatos(nome) {

    // https://pt.stackoverflow.com/questions/174680/busca-via-ajax-durante-digita%C3%A7%C3%A3o-em-input-text-autocomplete
    // https://stackoverflow.com/questions/21303955/how-to-give-and-get-data-back-with-jquery-ajax
    // http://clubedosgeeks.com.br/programacao/listando-registro-de-banco-de-dados-mysql-com-ajax-json-e-php


    nome = nome.trim();

    // Guarda para saber que nome ou parte do nome o operador digitou
    // e se for diferente de 'vazio', poder completar com os outros contatos ao clicar no contado escolhido
    nomepesquisado = nome;
    // alert(nomepesquisado);
    // *****************************************************************************************************

    // Remove TODOS contatos da lista
    $('#contacts ul li').remove();
    // *****************************


    //Remove o nome do contato ativo
    $('#contact-profile span').text('');
    //*********************************************


    // Remove todas as mensagens na lista de mensagem
    //var qtdmsg = $('#bulk .message').length // Quantidade de mensagens

    //TESTE - 29/01/2019
    //DESCOMENTAR ANTES DE COPIAR PARA A PRODUÇÃO
    $(".message").remove();
    //
    //****************************************	


    // Limpa os campos escondidos de Contato ativo e respectivo telefone
    $('#txtContatoAtivo').val('');
    $('#txtTelefoneAtivo').val('');
    //*******************************************************************

    //DESABILITA OS BOTÕES DE TRANSFERÊNCIA DE CLIENTE, ALTERAÇÃO NO NÚMERO DE TELEFONE E TRANSFERÊNCIA DE TODOS OS CONTATOS
    $('#btnAcessarTransferencia').prop('disabled', true);
    $('#btnAcessarAlterarTelefone').prop('disabled', true);
    $('#btnAcessarTransferirTContatos').prop('disabled', true);
    // *********************************************************
    // $(location).attr('href', 'chat.php#');                            //RETIRADO


    var nome = nome;


    $.ajax({
        type: 'POST',
        url: 'search_contacts.php',
        data: {contato: nome},
        dataType: 'json',
        async: false,                   // O Navegador, primeiramente, completa a requisição   29/01/2019
        success: function (response) {

            if (response) {


                // HABILITA BOTÃO DE TRANSFERÊNCIA DE TODOS OS CONTATOS
                $('#btnAcessarTransferirTContatos').prop('disabled', false);
                //***************************************************************************

                for (var i = 0; response.length > i; i++) {
                    // ACRESCENTA OS CONTATOS PESQUISADOS

                    if (response[i].status == '1') {

                        $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '" >\
						<div class="wrap">\
							<img src="images/contact.png" alt="" />\
							<div class="meta">\
								<p class="name">' + utf8_decode(response[i].nome) + '</p>\
								<p class="preview">' + response[i].numero + '</p>\
							</div>\
						</div>\
					   </li>');
                    } else {
                        // Quando o status do contato é 0 (ZERO) é incluído um span que indica uma bolinha
                        // Para que esse span possa ser removido quando o status do contato é 1, é necessário
                        // informar um id que é composto do prefixo SPAN+TELEFONE DO CONTATO
                        $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '" >\
						<div class="wrap">\
						    <span id="SPAN' + response[i].numero + '" class="contact-status novamensagem"></span>\
							<img src="images/contact.png" alt="" />\
							<div class="meta">\
								<p class="name">' + utf8_decode(response[i].nome) + '</p>\
								<p class="preview">' + response[i].numero + '</p>\
							</div>\
						</div>\
					   </li>');

                    }


                }

            }

        }
    })


}

function Refaz_Lista_Contatos() {

    // REMOVE TODOS CONTATOS DA LISTA
    $('#contacts ul li').remove();
    // *****************************

    var telefone_ativo = $('#txtTelefoneAtivo').val();
    telefone_ativo = telefone_ativo.trim();

    var nome = '';


    $.ajax({
        type: 'POST',
        url: 'search_contacts.php',
        data: {contato: nome},
        dataType: 'json',
        async: false,                   // O NAVEGADOR, PRIMEIRAMENTE, COMPLETA A REQUISIÇÃO
        success: function (response) {

            if (response) {


                for (var i = 0; response.length > i; i++) {
                    // ACRESCENTA OS CONTATOS PESQUISADOS

                    if (response[i].status == '1') {

                        if (telefone_ativo != response[i].numero) {
                            //NÃO É TELEFONE ATIVO
                            $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '" >\
							<div class="wrap">\
								<img src="images/contact.png" alt="" />\
								<div class="meta">\
									<p class="name">' + utf8_decode(response[i].nome) + '</p>\
									<p class="preview">' + response[i].numero + '</p>\
								</div>\
							</div>\
						   </li>');
                        } else {
                            // TELEFONE ATIVO
                            $("#contacts ul").append('<li class="contact active" id="' + response[i].numero + '" >\
								<div class="wrap">\
									<img src="images/contact.png" alt="" />\
									<div class="meta">\
										<p class="name">' + utf8_decode(response[i].nome) + '</p>\
										<p class="preview">' + response[i].numero + '</p>\
									</div>\
								</div>\
							   </li>');

                        }

                    } else {
                        // QUANDO O STATUS DO CONTATO É 0 (ZERO) É INCLUÍDO UM SPAN QUE INDICA UMA BOLINHA
                        // PARA QUE ESSE SPAN POSSA SER REMOVIDO QUANDO O STATUS DO CONTATO É 1, É NECESSÁRIO
                        // INFORMAR UM ID QUE É COMPOSTO DO PREFIXO SPAN+TELEFONE DO CONTATO
                        $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '" >\
						<div class="wrap">\
						    <span id="SPAN' + response[i].numero + '" class="contact-status novamensagem"></span>\
							<img src="images/contact.png" alt="" />\
							<div class="meta">\
								<p class="name">' + utf8_decode(response[i].nome) + '</p>\
								<p class="preview">' + response[i].numero + '</p>\
							</div>\
						</div>\
					   </li>');

                    }


                }

            }

        }
    })

    if (document.visibilityState == "hidden") {
        // SOMENTE APARECE O POPUP E O SOM DE NOVA NOTIFICAÇÃO SE O USUÁRIO ESTIVER
        // COM O BROWSER MINIMIZADO OU EM OUTRA PÁGINA

        var notification = new Notification("WhatsCompany", {
            icon: 'images/notificacao.png',
            body: "Nova mensagem recebida 1 ."
        });
    }

    var x = document.getElementById("beepSound");
    x.play();

}

function Complementa_Lista_Contatos() {

    // alert(nomepesquisado);
    // alert("Fazer rotina de complemento de contatos");


    $.ajax({
        type: 'POST',
        url: 'complete_contacts.php',
        data: {contato: nomepesquisado},
        dataType: 'json',
        async: false,                   // O NAVEGADOR, PRIMEIRAMENTE, COMPLETA A REQUISIÇÃO
        success: function (response) {

            if (response) {


                for (var i = 0; response.length > i; i++) {
                    // Acrescenta os contatos pesquisados

                    if (response[i].status == '1') {

                        $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '">\
						<div class="wrap">\
							<img src="images/contact.png" alt="" />\
							<div class="meta">\
								<p class="name">' + utf8_decode(response[i].nome) + '</p>\
								<p class="preview">' + response[i].numero + '</p>\
							</div>\
						</div>\
					   </li>');
                    } else {
                        // Quando o status do contato é 0 (ZERO) é incluído um span que indica uma bolinha
                        // Para que esse span possa ser removido quando o status do contato é 1, é necessário
                        // informar um id que é composto do prefixo SPAN+TELEFONE DO CONTATO
                        $("#contacts ul").append('<li class="contact" id="' + response[i].numero + '" >\
						<div class="wrap">\
						    <span id="SPAN' + response[i].numero + '" class="contact-status novamensagem"></span>\
							<img src="images/contact.png" alt="" />\
							<div class="meta">\
								<p class="name">' + utf8_decode(response[i].nome) + '</p>\
								<p class="preview">' + response[i].numero + '</p>\
							</div>\
						</div>\
					   </li>');

                    }


                }

            }

        }
    })


}


function Atualiza_Status_Contato(telefone) {

    // Esta função tem por objetivo informar na coluna de contatos os contatos que possuem novas mensagens
    // A informação de nova mensagem é indicada por uma bolinha ao lado da imagem do contato

    $.ajax({
        type: 'POST',
        url: 'update_status.php',
        data: {telefone: telefone},
        dataType: 'json',
        async: true,
        success: function (response) {

            if (response.success == true) {

                var span = "#SPAN" + telefone;

                if ($(span).length) {
                    //Se o span existe significa que existe mensagem(ns) não lida(s)
                    //Então ele é removido porque o status foi alterado para 1
                    $(span).remove();

                }

            } else {
            }
            // Para possível uso futuro
        }
    })


}

function Altera_Alerta_Sonoro(opcao) {


    var opcao = opcao;

    $.ajax({
        type: 'POST',
        url: 'alerta_sonoro.php',
        data: {opcao: opcao},
        dataType: 'json',
        async: false,                     // Para haver uma relativa pausa
        success: function (response) {

            if (response.success == true) {
                if (opcao == 0) {
                    //Usuário optou por desativar alerta sonoro
                    //Então o sub-Menu é Ativar
                    $(".dropdown-content a#notificacao").text('Ativar Alerta Sonoro');
                    $("#txtNotificacao").val('0')
                } else {
                    //Usuário optou por ativar alerta sonoro
                    //Então o sub-Menu é  Desativar
                    $(".dropdown-content a#notificacao").text('Desativar Alerta Sonoro');
                    $("#txtNotificacao").val('-1')
                }
            } else {

                $("#myAlert .modal-body").text('Problema na solicitação!\nPor favor,contate o suporte...');
                $('#myAlert').modal('show');

            }
        }
    })

}


function Carrega_Atendentes() {

    $.ajax({
        type: 'POST',
        url: 'search_assistants.php',
        data: '',
        dataType: 'json',
        async: true,                     // 19/01/2019
        success: function (response) {

            // if (response.length > 0 ) {
            if (response) {

                $('#myModal').modal('show');

                //Remove toda e qualquer opção anterior que possa existir
                $('#cmbUserCli')
                    .find('option')
                    .remove()
                    .end();
                //

                // Carrega os ítens da pesquisa bem sucedida
                for (var i = 0; response.length > i; i++) {

                    // Método 1
                    $('#cmbUserCli').append($('<option>', {
                        value: response[i].user_cli,
                        text: utf8_decode(response[i].nome_cli)
                    }));

                    // Método 2
                    // $('#cmbUserCli').append('<option value="'+ response[i].user_cli + '">'+ response[i].nome_cli+'</option>');


                }

            } else {
                // Alterado por Julio 19/07/2019
                $("#myAlert .modal-body").text('Não temos nenhum atendente disponível no momento!');
                $('#myAlert').modal('show');

            }


        }
    })


}

function Transfere_Contato() {

    // ESSA FUNÇÃO UTILIZA API DE ENVIO DE MENSAGENS NO ARQUIVO transfer_customers.php

    var novo_user_cli = $('#cmbUserCli').val(); // Novo operador escolhido
    // alert(novo_user_cli);

    var telefoneativo = $('#txtTelefoneAtivo').val();
    // alert(telefoneativo);

    var posicao = parseInt($("#txtProximaSequencia").val()) + 5;
    // alert(posicao);


    $.ajax({
        type: 'POST',
        url: 'transfer_customers.php',
        data: {user_cli: novo_user_cli, telefone: telefoneativo, posicao: posicao},
        dataType: 'json',
        async: false,                     // Para aguardar
        success: function (response) {

            if (response.success == true) {

                //Métodos de fechamento de modal
                // $('#myModal').modal().hide();  // Esconde
                // $("#myModal .close").click()   // Fecha, indiretamente, através do botão fechar

                $('#myModal').modal('toggle');  //Fecha o Modal

                //Remove todo e qualquer ítem do select que possa existir
                $('#cmbUserCli')
                    .find('option')
                    .remove()
                    .end();

                //Exclui as mensagens ativas e procura os contatos restantes

                // Pesquisa_Contatos(''); 

                StartApp(); // Reinicializa 01/06/2019

                $("#myAlert .modal-body").text('Transferência efetuada com sucesso...');
                $('#myAlert').modal('show');

            } else {

                $("#myAlert .modal-body").text('Não foi possível transferir cliente!\nPor favor,contate o suporte...');
                $('#myAlert').modal('show');

            }
        }
    })

}

//31/05/2019
function Carrega_Modal_Alteracao_Nome(telefone) {

    $('#myModalAlterarNome').modal('show');
    $('#txtTelefoneNomeAlterado').val(telefone);
    $('#txtNovoNome').val('');
    $('#spanAlteraNome').html('&nbsp');

    $('#myModalAlterarNome').on('shown.bs.modal', function () {
        //Foco no campo nome
        $('#txtNovoNome').focus();
    })

}

//*********


//31/05/2019
function Altera_Nome_Contato() {

    var nome = $("#txtNovoNome").val();
    var telefone = $('#txtTelefoneNomeAlterado').val();

    if ($.trim(nome) != '') {

        $.ajax({
            type: 'POST',
            url: 'chgcontact_name.php',
            data: {nome: nome, telefone: telefone},
            dataType: 'json',
            async: false,                     // Para aguardar
            success: function (response) {

                if (response.success == true) {

                    //Métodos de fechamento de modal
                    // $('#myModalAlterarNome').modal().hide();  // Esconde
                    // $("#myModalAlterarNome .close").click()   // Fecha, indiretamente, através do botão fechar

                    $('#myModalAlterarNome').modal('toggle');  //Fecha o Modal


                    // Pesquisa_Contatos('');

                    StartApp(); // Reinicializa   01/06/2019

                    $("#myAlert .modal-body").text('Nome alterado com sucesso...');
                    $('#myAlert').modal('show');

                } else {
                    $('#myModalAlterarNome').modal('toggle');  //Fecha o Modal
                    $("#myAlert .modal-body").text('Não foi possível alterar nome do contato!\nPor favor,contate o suporte...');
                    $('#myAlert').modal('show');

                }
            }
        })

    } else {
        $('#spanAlteraNome').text('O nome deve ser informado ...');

    }

    $("#txtNovoNome").val('');
}

//**********


function Carrega_Modal_Adicionar_Contato() {

    $('#myModalAdicionarContato').modal('show');
    $('#txtAdicionarContatoTelefone').val('');
    $('#txtAdicionarContatoNome').val('');
    $('#txtAdicionarContatoMsg').val('');

    $('#spanAdicionarContato').html('&nbsp');

    $('#myModalAdicionarContato').on('shown.bs.modal', function () {
        //Foco no primeiro campo ( campo do telefone)
        $('#txtAdicionarContatoTelefone').focus();
    })

}

//*******************************************

function Verifica_WhatsApp() {


    var telefone = $('#txtAdicionarContatoTelefone').val();

    if ($('#txtAdicionarContatoTelefone').val().trim() == '') {
        $('#spanAdicionarContato').text('O telefone deve ser informado !!!');
        return false;
    }

    var pais = telefone.substring(0, 2);

    pais = pais.trim();

    var n = telefone.length;

    if (pais == '55' && n < 12) {
        $('#spanAdicionarContato').text('Telefone inválido !!!');
        return false;
    }

    if ($('#txtAdicionarContatoNome').val().trim() == '') {
        $('#spanAdicionarContato').text('O nome do contato deve ser informado !!!');
        return false;
    }

    if ($('#txtAdicionarContatoMsg').val().trim() == '') {
        $('#spanAdicionarContato').text('Uma mensagem suscinta deve ser informada !!!');
        return false;
    }


    $('#spanAdicionarContato').text('Por favor, aguarde verificação no WhatsApp');


    $('#txtAdicionarContatoTelefone').prop('disabled', true);
    $('#txtAdicionarContatoNome').prop('disabled', true);
    $('#txtAdicionarContatoMsg').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: 'whatsapp_verification.php',
        data: {telefone: telefone},
        dataType: 'json',
        async: false,
        success: function (response) {

            if (response.success == '1') {
                $('#spanAdicionarContato').text('Celular cadastrado no WhatsApp');
                Adiciona_Novo_Contato();
            } else {

                switch (response.success) {
                    case '0':
                        $('#spanAdicionarContato').text('Celular não cadastrado no WhatsApp');
                        break;
                    case '3':
                        var mensagem = 'O QRCODE do Whatsapp que está enviando mensagens está desconectado<br>';
                        mensagem = mensagem + 'Favor conectar ...';

                        $('#spanAdicionarContato').html(mensagem);
                        break;

                    default:
                        $('#spanAdicionarContato').text('Não foi possível verificar o cadastramento do celular no WhatsApp');
                        break;
                }

            }
        }

    })


    $('#txtAdicionarContatoTelefone').prop('disabled', false);
    $('#txtAdicionarContatoNome').prop('disabled', false);
    $('#txtAdicionarContatoMsg').prop('disabled', false);


}


function Adiciona_Novo_Contato() {

    var telefone = $('#txtAdicionarContatoTelefone').val();
    var nome = $("#txtAdicionarContatoNome").val();
    var mensagem = $("#txtAdicionarContatoMsg").val();

    if (telefone.length < 10) {
        $('#spanAdicionarContato').html('Nº de telefone inválido.<br> No Brasil deve ser 55 + DDD + número telefone com ou sem 9º dígito.');
    } else {
        if ($.trim(nome) != '' && $.trim(telefone) != '' && $.trim(mensagem) != '') {


            $.ajax({
                type: 'POST',
                url: 'add_newcontact.php',
                data: {nome: nome, telefone: telefone, mensagem: mensagem},
                dataType: 'json',
                async: false,                     // PARA AGUARDAR O PROCESSAMENTO
                success: function (response) {


                    if (parseInt(response.success) == '-1') {
                        $('#spanAdicionarContato').text('Contato vinculado ao atendente ' + response.nome_cli);
                    } else {

                        if (parseInt(response.success) == '1') {

                            //Métodos de fechamento de modal
                            // $('#myModalAdicionarContato').modal().hide();  // Esconde
                            // $("#myModalAdicionarContato .close").click()   // Fecha, indiretamente, através do botão fechar

                            $('#myModalAdicionarContato').modal('toggle');    // FECHA O MODAL


                            StartApp();                                       // REINICIALIZA

                            $("#myAlert .modal-body").text('Contato adicionado com sucesso...');
                            $('#myAlert').modal('show');

                        } else if (parseInt(response.success) == '2') {

                            $('#myModalAdicionarContato').modal('toggle'); // FECHA O MODAL

                            StartApp();                                    // REINICIALIZA

                            mensagem = 'Contato adicionado com sucesso...<br>';
                            mensagem = mensagem + 'O QRCODE do Whatsapp que está enviando mensagens está desconectado<br>';
                            mensagem = mensagem + 'Favor conectar ...';

                            $("#myAlert .modal-body").html(mensagem);
                            $('#myAlert').modal('show');

                        } else if (parseInt(response.success) == '0') {

                            $('#myModalAdicionarContato').modal('toggle');
                            $("#myAlert .modal-body").html('Não foi possível adicionar novo contato!<br>Posição ZERO(0)<br>Por favor, contate o suporte...');
                            $('#myAlert').modal('show');

                        } else if (parseInt(response.success) == '-2') {

                            $('#myModalAdicionarContato').modal('toggle');
                            $("#myAlert .modal-body").html('Não foi possível adicionar novo contato!<br>Erro no INSERT<br>Por favor, contate o suporte...');
                            $('#myAlert').modal('show');

                        } else if (parseInt(response.success) == '-3') {

                            $('#myModalAdicionarContato').modal('toggle');

                            mensagem = 'Não foi possível adicionar novo contato<br>';
                            mensagem = mensagem + 'Erro : <br>' + response.nome_cli;

                            $("#myAlert .modal-body").html(mensagem);
                            $('#myAlert').modal('show');

                        }


                    }

                }


            })

        } else {
            $('#spanAdicionarContato').text('O nome e telefone devem ser informados');
        }
    }
}

//*******************************************

function Carrega_Modal_Alterar_Telefone() {

    $('#myModalAlterarTelefone').modal('show');
    $('#txtTelefoneAnterior').val($('#txtTelefoneAtivo').val());
    $('#txtNovoTelefone').val('');

    $('#spanAlteraTelefone').html('&nbsp');
}

function Altera_Telefone_Contato() {


    var novotelefone = $('#txtNovoTelefone').val();
    novotelefone = novotelefone.trim();

    if (novotelefone.length < 10) {
        $('#spanAlteraTelefone').html('O telefone deve ser no formato dddtelefone' + '<br>' + 'Ex.:21988670000');
        return false;
    }

    var telefoneanterior = $('#txtTelefoneAnterior').val();


    $.ajax({
        type: 'POST',
        url: 'change_phone.php',
        data: {novotelefone: novotelefone, telefoneanterior: telefoneanterior},
        dataType: 'json',
        async: false,                     // Para aguardar
        success: function (response) {


            if (parseInt(response.success) == '-1') {

                $('#spanAlteraTelefone').text('Telefone em duplicidade, vinculado ao usuário ' + response.nome_cli);
            } else {

                if (parseInt(response.success) == '1') {


                    $('#myModalAlterarTelefone').modal('toggle');  //Fecha o Modal

                    StartApp(); // Reinicializa

                    $("#myAlert .modal-body").text('Telefone alterado com sucesso...');
                    $('#myAlert').modal('show');

                } else {

                    $('#myModalAlterarTelefone').modal('toggle');
                    $("#myAlert .modal-body").text('Não foi possível alterar o telefone!\n Por favor, contate o suporte...');
                    $('#myAlert').modal('show');

                }

            }

        }


    })


}

function Carrega_Modal_Excluir_Contato() {

    $('#myModalExcluirContato').modal('show');
    $('#txtTelefoneExcluir').val($('#txtTelefoneAtivo').val());
    $('#txtNomeExcluir').val($('#txtContatoAtivo').val());
    $('#spanExcluirContato').html('&nbsp');


}

function Exclui_Contato() {

    var telefone = $('#txtTelefoneExcluir').val();

    $.ajax({
        type: 'POST',
        url: 'delete_contact.php',
        data: {telefone: telefone},
        dataType: 'json',
        async: true,                     // 19/01/2019
        success: function (response) {

            if (response.success == true) {

                $('#myModalExcluirContato').modal('toggle');  //Fecha o Modal

                StartApp(); // Reinicializa  01/06/2019

                $("#myAlert .modal-body").text('Contato excluído com sucesso...');
                $('#myAlert').modal('show');

            } else {


            }

        }
    })


}

function Carrega_Modal_TransferirTodos_Contatos() {
    //17/07/2019 - TODA A ROTINA

    $('#spanTransferirTContatos').html('&nbsp');

    $.ajax({
        type: 'POST',
        url: 'search_assistants.php',
        data: '',
        dataType: 'json',
        async: true,                     // 19/01/2019
        success: function (response) {

            // if (response.length > 0 ) {
            if (response) {

                $('#myModalTransfereTContatos').modal('show');

                //Remove toda e qualquer opção anterior que possa existir
                $('#cmbUsuarios')
                    .find('option')
                    .remove()
                    .end();
                //

                // Carrega os ítens da pesquisa bem sucedida
                for (var i = 0; response.length > i; i++) {

                    // Método 1
                    $('#cmbUsuarios').append($('<option>', {
                        value: response[i].user_cli,
                        text: utf8_decode(response[i].nome_cli)
                    }));

                    // Método 2
                    // $('#cmbUsuarios').append('<option value="'+ response[i].user_cli + '">'+ response[i].nome_cli+'</option>');


                }

            } else {
                // Alterado por Julio 19/07/2019
                $("#myAlert .modal-body").text('Não temos nenhum atendente disponível no momento!');
                $('#myAlert').modal('show');

            }


        }
    })


}

function Transfere_Todos_Contatos() {

    //17/07/2019 - TODA A ROTINA

    var novo_user_cli = $('#cmbUsuarios').val(); // Novo operador escolhido

    $('#spanTransferirTContatos').html('Por favor, aguarde');


    $.ajax({
        type: 'POST',
        url: 'transfer_all_customers.php',
        data: {user_cli: novo_user_cli},
        dataType: 'json',
        async: false,                     // Para aguardar
        success: function (response) {

            if (response.success == true) {

                //Métodos de fechamento de modal
                // $('#myModalTransfereTContatos').modal().hide();  // Esconde
                // $("#myModalTransfereTContatos .close").click()   // Fecha, indiretamente, através do botão fechar

                $('#myModalTransfereTContatos').modal('toggle');    //Fecha o Modal


                //Remove todo e qualquer ítem do select que possa existir
                $('#cmbUsuarios')
                    .find('option')
                    .remove()
                    .end();


                StartApp(); // Reinicializa 01/06/2019

                $("#myAlert .modal-body").text('Transferência efetuada com sucesso...');
                $('#myAlert').modal('show');

            } else {

                $("#myAlert .modal-body").text('Não foi possível transferir contatos! Por favor,contate o suporte...');
                $('#myAlert').modal('show');

            }
        }
    })

}

function Carrega_Mensagens() {

    //Essa função carrega as mensagens após o click no contato da lista

    // Se o contato tiver mensagens OU NÃO , habilita os botões de Acessar Alteração e Exclusão do Contato
    //24/06/2019
    $('#btnAcessarAlterarTelefone').prop('disabled', false);
    $('#btnAcessarExclusaoContato').prop('disabled', false);
    // *****************************************************************************************

    var telefone = $('#txtTelefoneAtivo').val();

    $.ajax({
        type: 'POST',
        url: 'search_messages.php',
        data: {telefone: telefone},
        dataType: 'json',
        async: false,                     // 19/01/2019 Para aguardar a carregar todas as mensagens
        success: function (response) {


            if (response) {
                // Se o contato tiver mensagens, habilita o botão de Acessar Transferência

                $('#txtQtdMsg').val(response.length); // Informa a quantidade de mensagens do contato na caixa txtQtdMsg type=hidden

                $('#btnAcessarTransferencia').prop('disabled', false);
                //***********************************************************************

                // SE O CONTATO TIVER MENSAGENS HABILITA BOTÃO DE TRANSFERÊNCIA DE TODOS OS CONTATOS
                $('#btnAcessarTransferirTContatos').prop('disabled', false);
                //***************************************************************************

                var sGuardaData = "99991231";

                // Selecionando a tag corrent
                ws_tag_selected(response[response.length - 1].tag_id);

                for (var i = 0; response.length > i; i++) {

                    // Guarda o último id da mensagem registrado no mySQL quando se clica no contato
                    $('#txtUltimoId').val(response[i].id);
                    // *****************************************************************************


                    //29/01/2019
                    // A função formatDate está no top do formulário
                    var sData = formatDate(response[i].data_msg, 'pt-br');

                    if (sGuardaData != sData) {
                        sGuardaData = sData;
                        // alert ('sData = ' + sData);

                        if (sData != hoje && sData != ontem) {
                            var message = buildDataMessage(sData);
                        } else {
                            if (sData === hoje) {
                                var message = buildDataMessage("HOJE");
                            } else {
                                var message = buildDataMessage("ONTEM");
                            }

                        }

                        conversation.appendChild(message);
                    }
                    //**********


                    // 04/06/2019-B
                    // if ( response[i].entrada_saida === '1' ) {
                    if (parseInt(response[i].entrada_saida) === 1) {
                        // Enviada

                        var msg_enviada = utf8_decode(response[i].mensagem);
                        //05/06/2019-C
                        //Tranforma o salto de linha existente no banco para formato <br>
                        msg_enviada = msg_enviada.replace(/\r\n/g, '<br />').replace(/[\r\n]/g, '<br />');
                        //************
                        var hora_enviada = response[i].hora_msg;
                        var tipo_enviada = response[i].tipo_mensagem;
                        var id_enviada = response[i].id;
                        //05/07/2019 incluído o campo arquivo
                        var nome_arquivo = utf8_decode(response[i].arquivo);
                        var referencia = utf8_decode(response[i].referencia);
                        var message = buildMessageSentRecorded(msg_enviada, hora_enviada, tipo_enviada, id_enviada, nome_arquivo, referencia);
                        // *******************************

                        conversation.appendChild(message);
                        // Não existe animação nessa função porque buildMessageSentRecorded mostra somente um tick sem transição
                        // animateMessage(message);
                        // *********************************************************************************************************
                    } else {
                        // Recebida

                        var msg_recebida = utf8_decode(response[i].mensagem);
                        //05/06/2019-C
                        //Tranforma o salto de linha existente no banco para formato <br>
                        msg_recebida = msg_recebida.replace(/\r\n/g, '<br />').replace(/[\r\n]/g, '<br />');
                        //************

                        var hora_recebida = response[i].hora_msg;
                        var tipo_recebida = response[i].tipo_mensagem;
                        var id_recebida = response[i].id;
                        //05/07/2019 incluído o campo arquivo
                        var nome_arquivo = utf8_decode(response[i].arquivo);
                        var referencia = utf8_decode(response[i].referencia);
                        var message = buildMessageReceivedRecorded(msg_recebida, hora_recebida, tipo_recebida, id_recebida, nome_arquivo, referencia);
                        //************************************
                        conversation.appendChild(message);
                        // Não existe animação nessa função porque buildMessageReceivedRecorded mostra somente um tick sem transição
                        // animateMessage(message);
                        // *********************************************************************************************************
                    }


                }  // Fim do loop


                $("#txtNewMessage").focus();

                conversation.scrollTop = conversation.scrollHeight;

                // e.preventDefault();

            } else {
                // Se o contato não tiver mensagens, desabilita o botão de Acessar Transferência
                $('#txtQtdMsg').val('0');
                $('#btnAcessarTransferencia').prop('disabled', true);

                // 13/01/2020 - HENRIQUE AYRES - RETIRADO
                // SE O USUÁRIO NÃO POSSUI QUALQUER MENSAGEM, O ÚLTIMO ID DELE É O CAMPO PRÓXIMA SEQUÊNCIA
                // PARA EVITAR QUE SE CARREGUE DO FIREBASE QUALQUER COISA DO FIREBASE
                // var proximasequenciallocal = $('#txtProximaSequencia').val();
                // $('#txtUltimoId').val(proximasequenciallocal);
                $('#txtUltimoId').val('0');
                // *****************************************************************************

            }

        }
    })

}

// https://github.com/OneSignal/emoji-picker
// Função abaixo não está sendo utilizada
function unicodeToChar(text) {
    return text.replace(/\\u[\dA-F]{4}/gi, function (match) {
        return String.fromCharCode(parseInt(match.replace(/\\u/g, ''), 16));
    });
}


function utf8_decode(str_data) {

    // http://kevin.vanzonneveld.net
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +	  input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *	 example 1: utf8_decode('Kevin van Zonneveld');
    // *	 returns 1: 'Kevin van Zonneveld'

    // CONVERSÃO DE DADOS GRAVADOS EM  UTF-8 CAPTURADOS ATRAVÉS DO AJAX


    var tmp_arr = [], i = ac = c = c1 = c2 = 0;

    while (i < str_data.length) {
        c = str_data.charCodeAt(i);
        if (c < 128) {
            tmp_arr[ac++] = String.fromCharCode(c);
            i++;
        } else if ((c > 191) && (c < 224)) {
            c2 = str_data.charCodeAt(i + 1);
            tmp_arr[ac++] = String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            tmp_arr[ac++] = String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }

    return tmp_arr.join('');
}

function utf8Encode(unicodeString) {

    // https://gist.github.com/chrisveness/bcb00eb717e6382c5608
    // Author : Chris Veness

    if (typeof unicodeString != 'string') throw new TypeError('parâmetro ‘unicodeString’ não é uma string');
    const utf8String = unicodeString.replace(
        /[\u0080-\u07ff]/g,  // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
        function (c) {
            var cc = c.charCodeAt(0);
            return String.fromCharCode(0xc0 | cc >> 6, 0x80 | cc & 0x3f);
        }
    ).replace(
        /[\u0800-\uffff]/g,  // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
        function (c) {
            var cc = c.charCodeAt(0);
            return String.fromCharCode(0xe0 | cc >> 12, 0x80 | cc >> 6 & 0x3F, 0x80 | cc & 0x3f);
        }
    );
    return utf8String;
}


$('.send').click(function () {

    // CLIQUE NO BOTÃO DE ENVIAR MENSAGENS OU PRESSIONAMENTO DA TECLA ENTER NO CAMPO DE MENSAGEM A SER ENVIADA

    var telefone = $('#txtTelefoneAtivo').val();

    if ($.trim(telefone) != '') {

        var snd = new Audio("sound/send.mp3"); // buffers automatically when created
        snd.play();

        // SE EXISTE TELEFONE DE CONTATO ATIVO, ENVIA A MENSAGEM
        Enviar_Mensagem();


    }


});


function Enviar_Mensagem() {

    // ESSA ROTINA É A QUE ENVIA MENSAGEM

    var mensagem = $("textarea#txtNewMessage").val();
    var telefone = $("#txtTelefoneAtivo").val();

    var tag_id = $('#tag').val();


    if ($.trim(mensagem) != '') {

        $.ajax({
            type: 'POST',
            url: 'send_message.php',
            //      CAMPO     VARIÁVEL CAMPO    VARIÁVEL
            data: {mensagem: mensagem, telefone: telefone, tag_id: tag_id},
            dataType: 'json',
            async: true,
            success: function (response) {


                if (response.proximasequencia > '0') {

                    // O MAIS CORRETO AO ENVIAR UMA MENSAGEM É NÃO CRIAR LOGO A MENSAGEM MAIS
                    // SIM PROCURAR AS MENSAGENS A PARTIR DO ÚLTIMO ID POIS PODERÁ HAVER MENSAGENS
                    // RECEBIDAS ANTES DE SER ENVIADA A MENSAGEM
                    // A ROTINA ABAIXO NÃO É NECESSÁRIA PORQUE JÁ ESTÁ NA PESQUISA DA FUNÇÃO chat_api
                    // Verifica_Novas_Mensagens_Contato_Ativo();
                    //
                } else {

                    if (response.proximasequencia == '-1') {
                        $("#myAlert .modal-body").html('Problema no envio da mensagem.<br>Mensagem,Whatsapp ou Próxima Seguência vazios');
                    } else if (response.proximasequencia == '-3') {
                        // ESSE ERRO É INFORMADO PELA SOLUTEK
                        $("#myAlert .modal-body").html('Problema no envio da mensagem.<br>Erro: ' + response.status);
                        // **********************************
                    } else if (response.proximasequencia == '-4') {
                        $("#myAlert .modal-body").html('Problema no envio da mensagem.<br>Erro: ' + "Mensagem enviada MAS não foi possível atualizar posiçao do contato");
                    } else if (response.proximasequencia == '-5') {
                        $("#myAlert .modal-body").html('Problema no envio da mensagem.<br>Erro: ' + "Não foi possível gravar a mensagem");
                    }
                    $('#myAlert').modal('show');
                }
            }
        })


    }


    $("#txtNewMessage").val('').blur();               //LIMPA A CAIXA DA NOVA MENSAGEM E RESETA O PLACEHOLDER

    $("#txtNewMessage").focus();

    conversation.scrollTop = conversation.scrollHeight;


    // ESSE BEEP FOI RETIRADO
    // ROTINA DEIXADA PARA POSSÍVEL APROVEITAMENTO FUTURO
    /*
    if(document.getElementById('sentbeep').checked) {
       var x = document.getElementById("alertSound");
       x.play();
    }
    */

}


function buildMessageSentRecorded(text, hora, tipo, id, nome_arquivo, referencia) {


    // ESSA FUNÇÃO CONSTRÓI AS MENSAGENS ENVIADAS QUE ESTÃO GRAVADAS NA BASE DE DADOS

    // TIPO = chat   = MENSAGEM DE TEXTO
    //        ptt    ou audio = MENSAGEM DE AUDIO
    //        image  = MENSAGEM IMAGEM

    hora = hora.substring(0, 5);                // TRANSFORMA A HORA DA MENSAGEM NO FORMATO HH:MM:SS em SOMENTE HH:MM
    hora = hora.trim();

    var element = document.createElement('div');

    element.classList.add('message', 'sent');
    element.id = id;                             // CRIA O ID DA DIV

    // alert(tipo);
    // alert(nome_arquivo);

    if (tipo == 'chat') {
        element.innerHTML = text +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '<span class="">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck" x="2047" y="2061"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#92a58c"/></svg>' +
            //'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg>' +

            '</span>' +
            '</span>';
    } else if (tipo == 'ptt' || tipo == 'audio') {
        element.innerHTML = '<audio controls controlsList="nodownload" id="' + id + '">' +
            '<source src="' + nome_arquivo + '" type="audio/ogg" />' +
            '</audio>' +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '</span>';
    } else if (tipo == 'image') {
        element.innerHTML = '<img height="100px" width="150px" id="' + id + '" data-toggle="modal" ' +
            'data-target="#myModalImg" src="' + nome_arquivo + '" alt="" />'
        '<span class="metadata">' +
        '<span class="time2">' + hora + '</span>' +
        '</span>'


    } else if (tipo == 'video') {
        element.innerHTML = '<video width="400" height="350" controls controlsList="nodownload" id="' + id + '">' +
            '<source src="' + nome_arquivo + '" type="video/mp4" />' +
            '</video>' +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '</span>';

    } else if (tipo == 'document') {

        /*
        // ORIGINAL
    element.innerHTML = '<a href="'+ text + '" download="'+ nome_arquivo + '"> Arquivo : ' + nome_arquivo + '</a>' +
        '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
        '</span>';
    */
        /*
        element.innerHTML = '<a href="'+ "" + '" download="'+ nome_arquivo + '"> Arquivo : ' + referencia + '</a>' +
            '<span class="metadata">' +
                '<span class="time2">' + hora + '</span>' +
            '</span>';

         */


        // NESSE MODELO A SESSÃO É PERDIDA SE O PROJETO ESTIVER EM LOCALHOST MAS O HREF ESTIVER FORA DO LOCALHOST
        /*
        element.innerHTML = '<a href="'+ nome_arquivo + '" download="'+ referencia + '"> Arquivo : ' + referencia + '</a>' +
            '<span class="metadata">' +
                '<span class="time2">' + hora + '</span>' +
            '</span>';
        */

        element.innerHTML = '<div class="" >' +
            '<div class="_1fnMt _2CORf" >' +

            // '<a class="_1vKRe" href="file_upload/' + referencia +'" title="Baixar : '+ referencia.trim() +'">' +
            '<a class="_1vKRe" href="#" title="Baixar : ' + referencia.trim() + '">' +
            '<div class="_12xX7">' +
            '<div class="nxILt" style="margin-top:0px;">' +

            '<span dir="auto" class="message-filename">' + referencia.trim() + '</span>' +

            '</div>' +
            '<div class="_17viz" id="' + referencia.trim() + '" onclick="_download(this.id);" >' +
            '<span data-icon="audio-download" class="message-file-download">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" width="34" height="34">' +
            '<path fill="#263238" fill-opacity=".5" d="M17 2c8.3 0 15 6.7 15 15s-6.7 15-15 15S2 25.3 2 17 8.7 2 17 2m0-1C8.2 1 1 8.2 1 17s7.2 16 16 16 16-7.2 16-16S25.8 1 17 1z"></path>' +
            '<path fill="#263238" fill-opacity=".5" d="M22.4 17.5h-3.2v-6.8c0-.4-.3-.7-.7-.7h-3.2c-.4 0-.7.3-.7.7v6.8h-3.2c-.6 0-.8.4-.4.8l5 5.3c.5.7 1 .5 1.5 0l5-5.3c.7-.5.5-.8-.1-.8z"></path>' +
            '</svg>' +
            '</span>' +
            '<div class="_3SUnz message-file-load" style="display:none">' +
            '<svg class="_1UDDE" width="32" height="32" viewBox="0 0 43 43">' +
            '<circle class="_3GbTq _37WZ9" cx="21.5" cy="21.5" r="20" fill="none" stroke-width="3"></circle>' +
            '</svg>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</a>' +


            '<div class="_3Lj_s" >' +
            '<div class="_1DZAH" role="button">' +
            '<span class="message-time">' + hora + '</span>' +
            '</div>' +
            ' </div>' +


            '</div>' +
            '</div>';

    }

    return element;

    // https://medium.com/octopus-labs-london/downloading-a-base-64-pdf-from-an-api-request-in-javascript-6b4c603515eb
    // <a href="data:application/pdf;base64,[base64]" download="file.pdf">

}

function buildMessageReceivedRecorded(text, hora, tipo, id, nome_arquivo, referencia) {

    // ESSA FUNÇÃO CONSTRÓI AS MENSAGENS RECEBIDAS QUE ESTÃO GRAVADAS NA BASE DE DADOS

    // tipo = chat   = mensagem texto
    //        ptt    ou audio = mensagem audio
    //        image  = mensagem imagem

    hora = hora.substring(0, 5);                // TRANSFORMA A HORA DA MENSAGEM NO FORMATO HH:MM:SS em SOMENTE HH:MM

    var element = document.createElement('div');

    element.classList.add('message', 'received');
    element.id = id;

    if (tipo == 'chat') {
        element.innerHTML = text +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '</span>';
    } else if (tipo == 'ptt' || tipo == 'audio') {
        element.innerHTML = '<audio controls controlsList="nodownload" id="' + id + '">' +
            '<source src="' + nome_arquivo + '" type="audio/ogg" />' +
            '</audio>' +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '</span>';
    } else if (tipo == 'image') {
        // https://stackoverflow.com/questions/33838977/how-to-use-bootstrap-modal-on-multiple-images-on-same-page-on-image-click

        element.innerHTML = '<img height="100px" width="150px" id="' + id + '" data-toggle="modal" ' +
            'data-target="#myModalImg" src="' + nome_arquivo + '" alt="" />'
        '<span class="metadata">' +
        '<span class="time2">' + hora + '</span>' +
        '</span>'


    } else if (tipo == 'video') {
        element.innerHTML = '<video width="400" height="350" controls controlsList="nodownload" id="' + id + '">' +
            '<source src="' + nome_arquivo + '" type="video/mp4" />' +
            '</video>' +
            '<span class="metadata">' +
            '<span class="time2">' + hora + '</span>' +
            '</span>';

    } else if (tipo == 'document') {

        /*
        element.innerHTML =    '<a href="file_upload/' + referencia + '" download="' + referencia.trim() + '"> Baixar : ' + referencia + '</a>' +
             '<span class="metadata">' +
                 '<span class="time2">' + hora + '</span>' +
             '</span>';
         */


        element.innerHTML = '<div class="" >' +
            '<div class="_1fnMt _2CORf" >' +

            // '<a class="_1vKRe" href="file_upload/' + referencia +'" title="Baixar : '+ referencia.trim() +'">' +
            '<a class="_1vKRe" href="#" title="Baixar : ' + referencia.trim() + '">' +
            '<div class="_12xX7">' +
            '<div class="nxILt" style="margin-top:0px;">' +

            '<span dir="auto" class="message-filename">' + referencia.trim() + '</span>' +

            '</div>' +
            '<div class="_17viz" id="' + referencia.trim() + '" onclick="_download(this.id);" >' +
            '<span data-icon="audio-download" class="message-file-download">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" width="34" height="34">' +
            '<path fill="#263238" fill-opacity=".5" d="M17 2c8.3 0 15 6.7 15 15s-6.7 15-15 15S2 25.3 2 17 8.7 2 17 2m0-1C8.2 1 1 8.2 1 17s7.2 16 16 16 16-7.2 16-16S25.8 1 17 1z"></path>' +
            '<path fill="#263238" fill-opacity=".5" d="M22.4 17.5h-3.2v-6.8c0-.4-.3-.7-.7-.7h-3.2c-.4 0-.7.3-.7.7v6.8h-3.2c-.6 0-.8.4-.4.8l5 5.3c.5.7 1 .5 1.5 0l5-5.3c.7-.5.5-.8-.1-.8z"></path>' +
            '</svg>' +
            '</span>' +
            '<div class="_3SUnz message-file-load" style="display:none">' +
            '<svg class="_1UDDE" width="32" height="32" viewBox="0 0 43 43">' +
            '<circle class="_3GbTq _37WZ9" cx="21.5" cy="21.5" r="20" fill="none" stroke-width="3"></circle>' +
            '</svg>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</a>' +


            '<div class="_3Lj_s" >' +
            '<div class="_1DZAH" role="button">' +
            '<span class="message-time">' + hora + '</span>' +
            '</div>' +
            ' </div>' +


            '</div>' +
            '</div>';


    } else if (tipo == 'vcard') {

        element.innerHTML = '<div class="_3_7SH kNKwo tail">' +
            '<span class="tail-container"></span>' +
            '<span class="tail-container highlight"></span>' +
            '<div class="_1YNgi copyable-text">' +
            '<div class="_3DZ69" role="button">' +
            '<div class="_20hTB">' +
            '<div class="_1WliW" style="height: 49px; width: 49px;">' +
            '<img src="#" class="Qgzj8 gqwaM photo-contact-sended" style="display:none">' +
            '<div class="_3ZW2E">' +
            '<span data-icon="default-user">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 212 212" width="212" height="212">' +
            '<path fill="#DFE5E7" d="M106.251.5C164.653.5 212 47.846 212 106.25S164.653 212 106.25 212C47.846 212 .5 164.654.5 106.25S47.846.5 106.251.5z"></path>' +
            '<g fill="#FFF">' +
            '<path d="M173.561 171.615a62.767 62.767 0 0 0-2.065-2.955 67.7 67.7 0 0 0-2.608-3.299 70.112 70.112 0 0 0-3.184-3.527 71.097 71.097 0 0 0-5.924-5.47 72.458 72.458 0 0 0-10.204-7.026 75.2 75.2 0 0 0-5.98-3.055c-.062-.028-.118-.059-.18-.087-9.792-4.44-22.106-7.529-37.416-7.529s-27.624 3.089-37.416 7.529c-.338.153-.653.318-.985.474a75.37 75.37 0 0 0-6.229 3.298 72.589 72.589 0 0 0-9.15 6.395 71.243 71.243 0 0 0-5.924 5.47 70.064 70.064 0 0 0-3.184 3.527 67.142 67.142 0 0 0-2.609 3.299 63.292 63.292 0 0 0-2.065 2.955 56.33 56.33 0 0 0-1.447 2.324c-.033.056-.073.119-.104.174a47.92 47.92 0 0 0-1.07 1.926c-.559 1.068-.818 1.678-.818 1.678v.398c18.285 17.927 43.322 28.985 70.945 28.985 27.678 0 52.761-11.103 71.055-29.095v-.289s-.619-1.45-1.992-3.778a58.346 58.346 0 0 0-1.446-2.322zM106.002 125.5c2.645 0 5.212-.253 7.68-.737a38.272 38.272 0 0 0 3.624-.896 37.124 37.124 0 0 0 5.12-1.958 36.307 36.307 0 0 0 6.15-3.67 35.923 35.923 0 0 0 9.489-10.48 36.558 36.558 0 0 0 2.422-4.84 37.051 37.051 0 0 0 1.716-5.25c.299-1.208.542-2.443.725-3.701.275-1.887.417-3.827.417-5.811s-.142-3.925-.417-5.811a38.734 38.734 0 0 0-1.215-5.494 36.68 36.68 0 0 0-3.648-8.298 35.923 35.923 0 0 0-9.489-10.48 36.347 36.347 0 0 0-6.15-3.67 37.124 37.124 0 0 0-5.12-1.958 37.67 37.67 0 0 0-3.624-.896 39.875 39.875 0 0 0-7.68-.737c-21.162 0-37.345 16.183-37.345 37.345 0 21.159 16.183 37.342 37.345 37.342z"></path>' +
            '</g>' +
            '</svg>' +
            '</span>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="_1lC8v">' +
            '<div dir="ltr" class="_3gkvk selectable-text invisible-space copyable-text">' + text + '</div>' +

            '<div class="_3a5-b">' +
            '<div class="_1DZAH" role="button">' +
            '<span class="message-time">' + hora + '</span>' +
            '</div>' +
            '</div>' +


            '</div>' +

            /*
            '<div class="_3a5-b">' +
                '<div class="_1DZAH" role="button">' +
                    '<span class="message-time">' + hora + '</span>' +
                '</div>' +
            '</div>' +
            */
            '</div>' +

            '<div dir="rtl"  class="_6qEXM">' +
            '<div  id="' + id + '"  class="btn-message-send" role="button" onclick="click_handler(this.id)" >' + referencia + '</div>' +


            // '<div class="btn-message-send" >' + '5524992599250' + '</div>' +
            '</div>' +


            '</div>' +
            '</div>';


    }


    return element;

    // https://medium.com/octopus-labs-london/downloading-a-base-64-pdf-from-an-api-request-in-javascript-6b4c603515eb
    // <a href="data:application/pdf;base64,[base64]" download="file.pdf">

}


function animateMessage(message) {
    setTimeout(function () {
        var tick = message.querySelector('.tick');
        tick.classList.remove('tick-animation');

    }, 500);
}

function buildDataMessage(sData) {

    // MONTA A INDICAÇÃO DA DATA ( HOJE, ONTEM, DATA)
    var element = document.createElement('div');

    element.classList.add('message', 'datamsg');

    element.innerHTML = '<p>' + sData + '</p>';

    return element;

}

// **********************************

/* FIM DO ENVIO DAS MENSAGENS */

/* UPLOAD DE ARQUIVOS */

function Processa_Upload() {

    // $("#txtExtensao").val('');
    // $("#txtExtensao").val(extensao);

    // PARA PASSAR POST DE ARQUIVO ESCOLHIDO JUNTO COM VARIÁVEIS, TEM QUE SER FEITO NO MODELO ABAIXO
    var form_data = new FormData();
    form_data.append('file', $('#selecao-arquivo').prop('files')[0]);            // ARQUIVO ESCOLHIDO
    form_data.append('telefone', $("#txtTelefoneAtivo").val());                  // TELEFONE DESTINATÁRIO
    // form_data.append('proximasequencia', $("#txtProximaSequencia").val());    // PRÓXIMA SEQUÊNCIA
    form_data.append('extensao', extensao);                                      // EXTENSÃO DO ARQUIVO
    // **************************************************************************************


    // VERIFICAÇÃO DO TAMANHO DO ARQUIVO
    var file_size = $("#selecao-arquivo")[0].files[0].size;                      // TAMANHO DO ARQUIVO

    if (file_size > 2048000) {
        $("#myAlert .modal-body").text('O tamanho máximo permitido para upload é 3 MB ou 2048000 kb');
        $('#myAlert').modal('show');
        return false;
    }
    // *************************************************************************************************

    var host = window.location.hostname;

    // DESCOMENTAR A LINHA ABAIXO ANTES DE COLOCAR EM PRODUÇÃO
    if (host == "127.0.0.1" || host == "localhost") {
        $("#myAlert .modal-body").text('Para enviar arquivo,o site não pode estar hospedado em LOCALHOST');
        $('#myAlert').modal('show');
        Limpa_Arquivos_Selecionados();
        return false;
    }
    // *******************************************************


    var ultimoid_anterior = $('#txtUltimoId').val();     // Ultimo id no momento do contato ativo
    ultimoid_anterior = ultimoid_anterior.trim();         // Limpa o campo

    $("#myModalWait .modal-body").text('Por favor, aguarde o carregamento do arquivo para o servidor');	 //23/08/2019
    $('#myModalWait').modal('show');                     // JANELA DE AGUARDE

    $.ajax({
        url: 'file_upload.php',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        async: false,                   // O NAVEGADOR, PRIMEIRAMENTE, COMPLETA A REQUISIÇÃO
        success: function (response) {


            if (response.proximasequencia > '0') {


                $("#txtProximaSequencia").val(response.proximasequencia);

                // FECHA O MODAL ANTERIOR DE AGUARDE ...
                $('#myModalWait').modal('toggle');
                // *************************************

                // RETIRADA A MENSAGEM QUE O ARQUIVO FOI ENVIADO COM SUCESSO
                // $("#myAlert .modal-body").html('Arquivo enviado com sucesso.\nPor favor, aguarde replicação na tela');
                // $('#myAlert').modal('show');
                // **********************************************************


                setTimeout(function () {
                    //RETARDA UM POUCO ( 5 SEGUNDOS ) ANTES DE CAPTURAR O LINK NO MYSQL
                    Verifica_Novas_Mensagens_Contato_Ativo();
                }, 5000);


            } else {

                var resultado = parseInt(response.proximasequencia);

                switch (resultado) {
                    case -1:
                        var erro = '-1: Telefone em branco';
                        break;
                    case -2:
                        var erro = '-2: Arquivo não pode carregado pelo upload';
                        break;
                    case -3:
                        var erro = '-3: Problema no servidor de envio';
                        break;
                    default:
                        var erro = 'Não identificado';
                        break;
                }

                $('#myModalWait').modal('toggle');  //FECHA O MODAL

                $("#myAlert .modal-body").text('Problema no envio do arquivo. Erro: ' + erro);
                $('#myAlert').modal('show');

            }

            // LIMPA ARQUIVOS SELECIONADOS
            Limpa_Arquivos_Selecionados();

        }
    });

}

function Limpa_Arquivos_Selecionados() {

    var control = $("#selecao-arquivo");
    control.val("");
    // ********************************


    $("#lbl-selecao-arquivo").show();         // MOSTRA O LABEL E O BOTÃO DE SELECIONAR ARQUIVO ??????????
    $("#lbl-enviar-arquivo").hide();          // ESCONDE O LABEL DE ENVIAR ARQUIVO


}

/* FIM DE UPLOAD DE ARQUIVOS */

function click_handler(id) {


    var element = document.getElementById(id);
    // var searchThis = element.textContent

    // alert(searchThis);

    var searchThis2 = element.innerText;

    // alert(searchThis2);

    $('#txtAdicionarContatoTelefone').val('');
    $('#txtAdicionarContatoNome').val('');

    var res = searchThis2.split("\n");

    // alert(res[0]);     // NOME
    // alert(res[1]);     // HORAS
    // alert(res[2]);     // TELEFONE

    //Carrega_Modal_Adicionar_Contato ();

    $('#myModalAdicionarContato').modal('show');
    $('#txtAdicionarContatoTelefone').val(res[2]);
    $('#txtAdicionarContatoNome').val(res[0]);
    $('#spanAdicionarContato').html('&nbsp');

    $('#myModalAdicionarContato').on('shown.bs.modal', function () {
        //Foco no primeiro campo ( campo do telefone)
        $('#txtAdicionarContatoTelefone').focus();
    })

}

function _download(id) {

    // https://codepen.io/chrisdpratt/pen/RKxJNo

    var file = id;

    // var url = 'http://127.0.0.1:8080/chat2n/file_upload/' +  id;

    var url = 'file_upload/' + id;

    $.ajax({
        // url: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/172905/test.pdf',
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = id;
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        }
    });


}

function ws_tag_selected(tag_id) {
    if(tag_id == '' || tag_id == undefined || tag_id == null){
        $('#tag option[value="1"]').prop('selected', 'selected');
    }else{
        $('#tag option[value="' + tag_id + '"]').prop('selected', 'selected');
    }
}