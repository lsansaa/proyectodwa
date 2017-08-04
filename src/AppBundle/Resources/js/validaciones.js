$( document ).ready(function() {
    $(".soloTexto").bind('blur',function(){
        var span = $(this).siblings("div[class=input-group-addon]").find('span');
        var value = this.value
        var noSpaces = value.replace(/\s/g, "");
        if (/^[ a-záéíóúüñ]*$/i.test(value)&&noSpaces.length>0) {
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-success');
            span.attr('class','glyphicon glyphicon-ok');
            this.setCustomValidity("");

        }else if(noSpaces.length==0){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group')
            span.attr('class','');
            this.setCustomValidity("Campo vacío");
        }else{
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','glyphicon glyphicon-remove');
            this.setCustomValidity("Campo no válido");
            $(' button[type=submit]').trigger('click');
        }
    });
    $(".soloRut").bind('blur',function(){
        var span = $(this).siblings("div[class=input-group-addon]").find('span');
        var rut = this.value
        var noSpaces = rut.replace(/\s/g, "");
        if(validarRut(rut)){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-success');
            span.attr('class','glyphicon glyphicon-ok');
            this.setCustomValidity("");
        }
        else if(noSpaces.length==0){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group')
            span.attr('class','');
            this.setCustomValidity("Campo vacío");
        }else{
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','glyphicon glyphicon-remove');
            this.setCustomValidity("RUT no valido");
            $(' button[type=submit]').trigger('click');
        }
    });
    $(".soloPassword").bind('blur',function(){
        var span = $(this).siblings("div[class=input-group-addon]").find('span');
        var password = this.value
        var noSpaces = password.replace(/\s/g, "");
        if(validarPassword(password)){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-success');
            span.attr('class','glyphicon glyphicon-ok');
            this.setCustomValidity("");
        }
        else if(noSpaces.length==0){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group')
            span.attr('class','');
            this.setCustomValidity("Campo vacío");
        }else{
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','glyphicon glyphicon-remove');
            this.setCustomValidity("Contraseña no válida");
            $(' button[type=submit]').trigger('click');
        }
    });
    $(".soloPasswordRepetido").bind('blur',function(){
        var span = $(this).siblings("div[class=input-group-addon]").find('span');
        var password = document.getElementsByClassName('soloPassword')[0].value;
        var passwordRepetido = this.value
        var noSpaces = passwordRepetido.replace(/\s/g, "");
        if(noSpaces.length==0){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group')
            span.attr('class','');
            this.setCustomValidity("Campo vacío");
        }else if(password==passwordRepetido){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-success');
            span.attr('class','glyphicon glyphicon-ok');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','glyphicon glyphicon-remove');
            this.setCustomValidity("Las contraseñas no coinciden");
            $(' button[type=submit]').trigger('click');
        }
    });
    $(".soloEmail").bind('blur',function(){
        var span = $(this).siblings("div[class=input-group-addon]").find('span');
        var email = this.value
        var noSpaces = email.replace(/\s/g, "");
        if(noSpaces.length==0){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','');
            this.setCustomValidity("Campo vacío");
        }else if(validarEmail(email)){
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-success');
            span.attr('class','glyphicon glyphicon-ok');
        }else{
            var parent = $(this).parent().parent();
            parent.attr('class','form-group has-error')
            span.attr('class','glyphicon glyphicon-remove');
            this.setCustomValidity("Correo no válido");
            $(' button[type=submit]').trigger('click');
        }
    });
});
function validarPassword(password){
    return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/i.test(password)
}
function validarEmail(password){
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(password)
}
function validarRut(rut){
    if ( rut.length < 8 ){ return false; }

    rut = rut.replace('-','')
    rut = rut.replace(/\./g,'')

    var suma = 0;
    var caracteres = "1234567890kK";
    var contador = 0;
    for (var i=0; i < rut.length; i++){

        u = rut.substring(i, i + 1);
        if (caracteres.indexOf(u) != -1)
            contador ++;
    }
    if ( contador==0 ) { return false }

    var rut = rut.substring(0,rut.length-1)
    var drut = rut.substring( rut.length-1 )
    var dvr = '0';
    var mul = 2;

    for (i= rut.length -1 ; i >= 0; i--) {
        suma = suma + rut.charAt(i) * mul
        if (mul == 7) 	mul = 2
        else	mul++
    }
    res = suma % 11
    if (res==1)		dvr = 'k'
    else if (res==0) dvr = '0'
    else {
        dvi = 11-res
        dvr = dvi + ""
    }
    if ( dvr != drut.toLowerCase() ) { return false; }
    else { return true; }
}