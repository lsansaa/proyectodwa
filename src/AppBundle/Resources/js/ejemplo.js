$( document ).ready(function() {

});

function editarArchivo(id_archivo, nombreArchivo, estadoArchivo, path){
    $.ajax({
        type: "POST",
        url: path,
        dataType: "json",
        data: {id: id_archivo, nombre: nombreArchivo, estado: estadoArchivo},
        success :  console.log("Cambios hechos")
    });
}
