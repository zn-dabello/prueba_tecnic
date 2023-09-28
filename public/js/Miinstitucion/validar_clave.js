$(function(){

    var mayuscula   = new RegExp("^(?=.*[A-Z])");
    var minuscula   = new RegExp("^(?=.*[a-z])");
    var digito    = new RegExp("^(?=.*[0-9])");
    var longitud  =   new RegExp("^(?=.{8,})");
    var check = 0;
  
    var regExp    = [mayuscula,minuscula,digito,longitud]; 
    var elementos   = ['item-campo-mayuscula', 'item-campo-minuscula', 'item-campo-digito', 'item-campo-length']
  
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('keyup', '.campoPass', function(){
  
      var valor_insert  = $(this).val();
      check = 0;
  
      for (var i = 0; i < 4; i++) {
        let elemento_seleccionado = $('.' + elementos[i]);
        console.log($('.' + elementos[i]), $("."+ elementos[i] + "-bien"));
  
        if ( regExp[i].test(valor_insert) ){
            
            $("."+elementos[i]+"-bien").show();
            $("."+elementos[i]+"-mal").hide();
          check ++;
          $('#formatoValidoPassword').val(check);
  
        }
        else{
  
            $("."+elementos[i]+"-bien").hide();
            $("."+elementos[i]+"-mal").show();
  
        }
      }
  
      if ( check >= 0 && check <= 3){
        $(this).addClass('border !border-red-500');
        $(this).removeClass('border !border-green-500');
      }
      else if ( check == 4) {
        $(this).removeClass('border !border-red-500');
        $(this).addClass('border !border-green-500');
      }
  
  
    });
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('keyup', '#password_confirmation', function(){
  
      var confirmacion  = $(this).val();
      var clave  = $("#password").val();
      if ( confirmacion != clave){
        $(this).addClass('border !border-red-500');
        $(this).removeClass('border !border-green-500');
        $("#confirmado").val(0);
      }
      else{
        $(this).removeClass('border !border-red-500');
        $(this).addClass('border !border-green-500');
        $("#confirmado").val(1);
      }
  
  
    });
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('blur', '.campoPass', function(){
        if ( $("#formatoValidoPassword").val() == 4 ) {
            $(this).removeClass('border !border-green-500');
        }
 
  
    });
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('blur', '#password_confirmation', function(){
        if ( $("#confirmado").val() == 1 ) {
            $(this).removeClass('border !border-green-500');
        }
    });
  
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('click', '.btn-password', function(){
        $(this).data('ver')
        if ($(this).data('ver') == 0) {
            $(this).data('ver', 1);
            $(".pass-no-ver").show();
            $(".pass-ver").hide();
            $("#password").attr('type', 'text');
        } else {
            $(this).data('ver', 0);
            $(".pass-no-ver").hide();
            $(".pass-ver").show();
            $("#password").attr('type', 'password');
            
        }
    });
  
    /** Comparacion del valor ingresado, con las reglas establecidas*/
    $('body').on('click', '.btn-confirmation', function(){
        $(this).data('ver')
        if ($(this).data('ver') == 0) {
            $(this).data('ver', 1);
            $(".confirm-no-ver").show();
            $(".confirm-ver").hide();
            $("#password_confirmation").attr('type', 'text');
        } else {
            $(this).data('ver', 0);
            $(".confirm-no-ver").hide();
            $(".confirm-ver").show();
            $("#password_confirmation").attr('type', 'password');
            
        }
    });

    $('#form-usuario').submit(function(event) {
        if ( $("#confirmado").val() == 1 && $("#formatoValidoPassword").val() == 4 ) {
            gestionar_nube();
            $(this).unbind('submit').submit();
        } else {
            gestionar_nube(false);
            modales.alert(3, mensaje_response_warning.default, 'Ok');
            event.preventDefault();
        }
    });
  });