$( document ).ready(function() {
    $(".btnEdit").click(function(){
        var tempid = this.id;
        var id = tempid.split("_")[1];
        var estadoEdicion = $(this).attr('data-editing');
        var nombre = ("nombre_"+id);
        var estado = ("estado_"+id);
        var span = "#spnEdit_"+id;

        if(estadoEdicion == 0){

            var nombreText = $("#"+nombre).text();
            var estadoText = $("#"+estado).text();

            var input = $("<input>", { val: nombreText,
                type: "text", id: "nombre_"+id });
            var arr = [
                {val : "BORRADOR", text: 'BORRADOR'},
                {val : "PUBLICADO", text: 'PUBLICADO'}

            ];
            var sel = $('<select>', {id:"estado_"+id
            });

            $(arr).each(function() {
                sel.append($("<option>").attr('value',this.val).text(this.text));
            });
            sel.val(estadoText);
            $("#"+nombre).replaceWith(input);
            $("#"+estado).replaceWith(sel);

            $(span).attr('class','glyphicon glyphicon-ok text-success');
            $(this).attr('data-editing', '1');


        }else{
            var nombreText = $("#"+nombre).val();
            var estadoText = $("#"+estado).val();


            var textNombre = $("<span>", { val: nombreText,
                id: "nombre_"+id});
            textNombre.text(nombreText);

            var textEstado = $("<span>", { val: estadoText,
                id: "estado_"+id});
            textEstado.text(estadoText);

            $("#"+nombre).replaceWith(textNombre);
            $("#"+estado).replaceWith(textEstado);

            $(span).attr('class','glyphicon glyphicon-pencil text-warning');
            $(this).attr('data-editing', '0');

            editarArchivo(id, nombreText, estadoText);
        }


    });

    $(".btnDelete").click(function(){
        var tempid = this.id;
        var id = tempid.split("_")[1];
        $("#"+id).remove();
        eliminarArchivo(id);
    });
});

function editarArchivo(id_archivo, nombreArchivo, estadoArchivo){
    $.ajax({
        type: "POST",
        url: "/archivo/editar/",
        dataType: "json",
        data: {id: id_archivo, nombre: nombreArchivo, estado: estadoArchivo},
        success :  console.log("Cambios hechos")
    });
}

function eliminarArchivo(id_archivo){

    $.ajax({
        type: "POST",
        url: "/archivo/eliminar/",
        dataType: "json",
        data: {id: id_archivo},
        success :  console.log("Archivo eliminado")
    });

}