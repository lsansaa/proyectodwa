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
    return true;
    //return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/i.test(password)
}
function validarEmail(password){
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(password)
}
function validarRut(b){
    if(b.match(/^([0-9])+\-([kK0-9])+$/)){b=b.split("-");var a=b[0].split(""),c=2,d=0;for(i=a.length-1;0<=i;i--)c=7<c?2:c,d+=parseInt(a[i])*parseInt(c++);a=11-d%11;return(11==a?0:10==a?"k":a)==b[1].toLowerCase()}return!1
}