$( document ).ready(function() {
    $(".btnEditarRol").click(function(){

        var rut = $(this).attr('data-rut');
        var estadoEdicion = $(this).attr('data-editing');
        var buttonSpan = $(this).find('span');


        if(estadoEdicion == 0){
            var rolSpanId = "spanEditRol_"+rut;
            var rolSpanText = $("#"+rolSpanId).text();
            console.log(rolSpanText);
            var roles = [
                {val : "ROLE_USER", text: 'User'},
                {val : "ROLE_ADMIN", text: 'Admin'}

            ];
            var selectRol = $('<select>', {id: rolSpanId });

            $(roles).each(function() {
                selectRol.append($("<option>").attr('value',this.val).text(this.text));
            });
            selectRol.val(rolSpanText);

            $("#"+rolSpanId).replaceWith(selectRol);

            $(buttonSpan).attr('class','glyphicon glyphicon-ok');
            $(buttonSpan).text(' Guardar');
            $(this).attr('data-editing', '1');
            $(this).attr('class', 'btnEditarRol btn-sm btn-primary');


        }else{
            var rolSpanId = "spanEditRol_"+rut;
            var rolSpanText = $("#"+rolSpanId).val();

            var spanRol = $("<span>", { val: rolSpanText,
                id: rolSpanId});
            spanRol.text(rolSpanText);

            $("#"+rolSpanId).replaceWith(spanRol);

            $(buttonSpan).attr('class','glyphicon glyphicon-pencil');
            $(buttonSpan).text(' Editar Rol');
            $(this).attr('data-editing', '0');
            $(this).attr('class', '\'btnEditarRol btn-sm btn-link');

            editarRol(rut, rolSpanText);
        }


    });
    $(".busquedaNombreRut").bind('keyup',function(){

            input = this;
            idTabla = $(this).attr('data-table-id');
            filter = input.value.toUpperCase();
            table = document.getElementById(idTabla);
            filaTrabajador = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < filaTrabajador.length; i++) {

                var rut = filaTrabajador[i].getElementsByTagName("td")[0];
                var nombre = filaTrabajador[i].getElementsByTagName("td")[1];
                if (rut || nombre) {
                    if (rut.innerHTML.toUpperCase().indexOf(filter) <= -1 && nombre.innerHTML.toUpperCase().indexOf(filter) <= -1) {

                        filaTrabajador[i].style.display = "none";

                    } else {
                        filaTrabajador[i].style.display = "";
                    }


                }

            }
    });
});
function editarRol(rut, rol){
    $.ajax({
        type: "POST",
        url: "/usuarios/editarrol",
        dataType: "json",
        data: {id: rut, rol: rol},
        success :  console.log("Cambios hechos")
    });
}