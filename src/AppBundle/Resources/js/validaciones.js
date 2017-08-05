$( document ).ready(function() {
    $(".soloTexto").bind('blur',function(){
        var value = this.value
        var noSpaces = value.replace(/\s/g, "");
        if (/^[ a-záéíóúüñ]*$/i.test(value)&&noSpaces.length>0) {
                var parent = $(this).parent();
                parent.attr('class','input-group has-success');
                this.setCustomValidity("");

        }else if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("Campo no válido");
        }
        if (!this.checkValidity()){
            //console.log('Error handling');
            //document.getElementById("demo").innerHTML = this.validationMessage;
        }
    });
    $(".soloRut").bind('blur',function(){
        var rut = this.value
        var noSpaces = rut.replace(/\s/g, "");
        if(validarRut(rut)){
            var parent = $(this).parent();
            parent.attr('class','input-group has-success');
            this.setCustomValidity("");
        }
        else if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("RUT no valido");
        }
        if (!this.checkValidity()){
            //console.log('Error handling');
            //document.getElementById("demo").innerHTML = this.validationMessage;
        }
    });
    $(".soloPassword").bind('blur',function(){
        var password = this.value
        var noSpaces = password.replace(/\s/g, "");
        if(validarPassword(password)){
            var parent = $(this).parent();
            parent.attr('class','input-group has-success');
            this.setCustomValidity("");
        }
        else if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("Contraseña no válida");
        }
        if (!this.checkValidity()){
            //console.log('Error handling');
            //document.getElementById("demo").innerHTML = this.validationMessage;
        }
    });
    $(".soloPasswordRepetido").bind('blur',function(){
        var password = document.getElementsByClassName('soloPassword')[0].value;
        var passwordRepetido = this.value
        var noSpaces = passwordRepetido.replace(/\s/g, "");
        if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group');
            this.setCustomValidity("");
        }else if(password==passwordRepetido){
            var parent = $(this).parent();
            parent.attr('class','input-group has-success');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("Las contraseñas no coinciden");
        }
        if (!this.checkValidity()){
            //console.log('Error handling');
            //document.getElementById("demo").innerHTML = this.validationMessage;
        }
    });
    $(".soloEmail").bind('blur',function(){
        var email = this.value;
        var noSpaces = email.replace(/\s/g, "");
        if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("");
        }else if(validarEmail(email)){
            var parent = $(this).parent();
            parent.attr('class','input-group has-success');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("Correo no válido");
        }
        if (!this.checkValidity()){
            //console.log('Error handling');
            //document.getElementById("demo").innerHTML = this.validationMessage;
        }

    });
});
function validarPassword(password){
    //return true;
    return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/i.test(password)
}
function validarEmail(password){
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(password)
}
function validarRut(b){
    if(b.match(/^([0-9])+\-([kK0-9])+$/)){b=b.split("-");var a=b[0].split(""),c=2,d=0;for(i=a.length-1;0<=i;i--)c=7<c?2:c,d+=parseInt(a[i])*parseInt(c++);a=11-d%11;return(11==a?0:10==a?"k":a)==b[1].toLowerCase()}return!1
}