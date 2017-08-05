$( document ).ready(function() {
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
