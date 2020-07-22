jQuery(function($){

    var CONTROLID = window.LOAD || {};


    CONTROLID.form_send = function(){

        $('body').on('submit', '.form-submit', function(e){

            e.preventDefault();

            var dados = new FormData($(this)[0]); 

            var button = $(this).find('.send');
            var button_text = $(this).find('.send').text();
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: $(this)[0].method,
                url: $(this)[0].action,
                data: dados,
                contentType: false,
                processData: false,

                beforeSend: function(data){
                    button.text(button.data('button-action'));
                },

                success: function(data) {

                    //success
                    var retorno = JSON.parse(data);
                    console.log(retorno.codigo);

                    if (retorno.codigo == undefined) {
                        console.log("Ocorreu um erro interno, informe o administrador.");
                    }

                    if (retorno.redirect != undefined) {
                        window.location.href = retorno.redirect;
                        return false;
                    }

                    if (retorno.response != undefined) {
                        $('.form-submit input').val('');
                        $('.response').html(retorno.response);
                        button.text(button_text);
                        return false;
                    }

                    if(retorno.hideDiv) {
                        $('#form_online').hide();
                        $('#form_sair').show();
                    }else {
                        $('#form_online').show();
                        $('#form_sair').hide();
                    }

                }, 

                complete: function(data) {

                    button.text(button_text);

                },

            });

            return false;

        });

    }

    /* ==================================================
    Init
    ================================================== */

    $(document).ready(function(){

        CONTROLID.form_send();
        
    });   
});