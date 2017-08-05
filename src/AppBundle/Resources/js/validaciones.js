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
        var rut = this.value;
        var noSpaces = rut.replace(/\s/g, "");
        if(noSpaces.length==0){
            var parent = $(this).parent();
            parent.attr('class','input-group');
            this.setCustomValidity("");
        }else if(validarRut(rut)){
            var parent = $(this).parent();
            parent.attr('class','input-group has-success');
            this.setCustomValidity("");
        }else{
            var parent = $(this).parent();
            parent.attr('class','input-group has-error');
            this.setCustomValidity("RUT no válido");
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
    return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8}$/i.test(password);
}
function validarEmail(email){
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}
function validarRut(rut){
        if(rut){
            //eliminar el guion
            rut = rut.replace('-','');
            //eliminar puntos
            rut = rut.replace(/\./g,'');
            //cuerpo del rut
            var cuerpo = rut.slice(0,-1);
            //digito verificador
            var digitoVerificador = rut.slice(-1).toUpperCase();
            //si el cuerpo no cumple con el largo mínimo (7), retorna false
            if(cuerpo.length<7){
                return false;
            }
            //verificación del digito

            var suma = 0;
            var multiplo = 2;

            //Se recorre cada digito del cuerpo, de atrás hacia adelantema
            for(var i=0;i<cuerpo.length;i++){
                //y se multiplica cada uno por el multiplo, para agregarse después a la suma
                var productoActual = multiplo * cuerpo.charAt(cuerpo.length-i-1);
                suma = suma + productoActual;
                //se aumenta el valor del multiplo
                multiplo++;
                if(multiplo==8){
                    multiplo = 2;
                }
            }
            //se divide el valor obtenido de la suma por 11, para obtener el resto
            var resto = suma % 11;
            //por ultimo se calcula la diferencia entre 11 y el resto
            var diferencia = 11- resto;
            var digitoVerificadorReal = "";
            // si la diferencia es 11, el digito verificador debería ser 0
            if(diferencia == 11){
                digitoVerificadorReal = "0";
            }
            // si la diferencia es 10, el digito verificador debería ser k
            else if(diferencia == 10){
                digitoVerificadorReal = "K";
            }
            // si la diferencia es 10, el digito verificador debería ser k
            else{
                digitoVerificadorReal = diferencia;
            }

            return (digitoVerificadorReal==digitoVerificador);
        }else{
            return false;
        }
}