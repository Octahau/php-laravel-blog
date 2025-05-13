/*==============================
CAPTURAR RUTA CMS
===============================*/
var ruta = $("#ruta").val();
console.log("ruta", ruta + "/ajax/upload.php");
/*==============================
SUMMERNOTE
===============================*/
$(".summernote-sm").summernote({
    height: 300,
    callbacks: {
        onImageUpload: function(files) {
            for (var i = 0; i < files.length; i++) 
                {
                upload_sm(files[i]);
            }
        }
    }
});
$(".summernote-smc").summernote({
    height: 300,
    callbacks: {
        onImageUpload: function(files) {
            for (var i = 0; i < files.length; i++) 
                {
                upload_smc(files[i]);
            }
        }
    }
});
/*==============================
SUBIR IMAGEN AL SERVIDOR
===============================*/
function upload_sm(file) 
{
    var datos = new FormData();
    datos.append('file', file, file.name);
    datos.append('ruta', ruta);
    $.ajax({
        url: ruta + "/ajax/upload.php",
        type: "POST",
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        success: function(respuesta) 
        {
            $(".summernote-sm").summernote("insertImage", respuesta);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la subida de la imagen: ", textStatus, errorThrown);
        }
    });
}
function upload_smc(file) 
{
    var datos = new FormData();
    datos.append('file', file, file.name);
    datos.append('ruta', ruta);
    $.ajax({
        url: ruta + "/ajax/upload.php",
        type: "POST",
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        success: function(respuesta) 
        {
            $(".summernote-smc").summernote("insertImage", respuesta);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la subida de la imagen: ", textStatus, errorThrown);
        }
    });
}
/*==============================
AGREGAR RED SOCIAL
===============================*/
$(document).on("click", ".agregarRed", function()
{
    var url = $("#url_red").val().trim();
    var icono = $("#icono_red").val().split(",")[0];
    var color = $("#icono_red").val().split(",")[1];

    if (url === "") {
        alert("La URL no puede estar vacía");
        return;
    }
     // Obtener el JSON actual
    var listaRed = $("#listaRed").val();
    listaRed = listaRed ? JSON.parse(listaRed) : [];

     // Agregar la nueva red social
    listaRed.push({
        "url": url, 
        "icono": icono, 
        "background": color
    });

     // Guardar el JSON corregido en el campo hidden
    $("#listaRed").val(JSON.stringify(listaRed));
    
    $(".listadoRed").append(
        `<div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="background:${color};">
                        <i class="${icono}"></i>
                    </div>
                </div>
                <input type="text" class="form-control" value="${url}">
                <div class="input-group-append">
                    <div class="input-group-text" style="cursor:pointer; background:#313847;">
                        <span class="bg-danger px-2 rounded-circle text-white eliminarRed red="${$value["icono"]}" url="${$value["url"]}">&times;</span>
                    </div>
                </div>
            </div>
        </div>`);
});
/*==============================
ELIMINAR RED SOCIAL
===============================*/
$(document).on("click", ".eliminarRed", function()
{
    var listaRed = JSON.parse($("#listaRed").val());
    var red = $(this).attr("red");
    var url = $(this).attr("url");

    for (var i = 0; i < listaRed.length; i++) {
        if (listaRed[i]["icono"] === red && listaRed[i]["url"] === url) 
            {
                listaRed.splice(i, 1);
                $(this).parent().parent().parent().parent().remove();
                $("#listaRed").val(JSON.stringify(listaRed));

                break;
            }
    }
});

/*==============================
Previsualizar imagenes temporales
===============================*/
$("input[type='file']").change(function()
{
    var imagen = this.files[0];
    var tipo = $(this).attr("name");

    //Validar formato
    if (imagen["type"] !== "image/jpeg" && imagen["type"] !== "image/png") 
    {
        $("input[type='file']").val("");
        notie.alert({
            type: 3,
            text: 'La imagen debe estar en formato JPG o PNG',
            time: 7
        });
    }
    //Validar tamaño
    else if(imagen["size"] > 2000000)
    {
        $("input[type='file']").val("");
        notie.alert({
            type: 3,
            text: 'La imagen no debe pesar más de 2MB',
            time: 7
        });
    }
    //Previsualizar imagen
    else
    {
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event)
        {
            var rutaImagen = event.target.result;
            $(`.previsualizarImg_${tipo}`).attr("src", rutaImagen);
        }); 
    }
});
/*==============================
Confirmar eliminacion registro
===============================*/
$(document).on("click", ".eliminarRegistro", function()
{
    var action = $(this).data("action");
    var method = $(this).data("method");
    var token = $(this).data("token");
    var pagina = $(this).data("pagina");

    swal({
        title: "¿Está seguro de eliminar este registro?",
        text: "¡Si no lo está, puede cancelar la acción!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, eliminar",
    }).then(function(result)
    {
        if (result.value) 
        {
            var datos = new FormData();
            datos.append("_method", method);
            datos.append("_token", token);

            $.ajax({
                url: action,
                type: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta)
                {
                    if (respuesta === "ok") 
                    {
                        swal({
                            title: "¡Eliminado!",
                            text: "El registro ha sido eliminado.",
                            type: "success",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result)
                        {
                            if (result.value) 
                            {
                                window.location = ruta + "/" + pagina;
                            }
                        });
                    }
                    else 
                    {
                        notie.alert({
                            type: 2,
                            text: 'No se pudo eliminar el administrador',
                            time: 10
                        }).then(function(result)
                        {
                            if (result.value) 
                            {
                                window.location = ruta + "/" + pagina;
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la eliminación del registro: ", textStatus, errorThrown);
                    swal({
                        title: "Error",
                        text: "No se pudo eliminar el registro.",
                        type: "error",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    });
                }
            });
        }
    });
});

/*==============================
Datatable servidor de contenido
===============================*/
$.ajax({
    url: ruta + "/administradores",
    success: function(respuesta) 
    {
        console.log("respuesta", respuesta);
    },
    error: function(jqXHR, textStatus, errorThrown) 
    { console.error("Error en la carga de datos: ", textStatus, errorThrown);
        notie.alert({
            type: 3,
            text: 'Error al cargar los datos',
            time: 7
        });
    }
});

/*==============================
Tabala de contenido
===============================*/
$("#tablaAdministradores").DataTable({
    
    processing: true,
    serverSide: true,
    ajax: {
        url: ruta + "/administradores"},
    columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'foto', name: 'foto', orderable: false, searchable: false, render: function(data, type, full, meta) {
            if (data === null || data === "") {
                return `<img src="${ruta}/img/Administradores/default.jpg" class="img-fluid rounded-circle">`;
            } else {
                return `<img src="${ruta}/${data}" class="img-fluid rounded-circle">`;
            }
        }
        },
        {data: 'rol', name: 'rol', render: function(data, type, full, meta) {
            if (data === null || data === "") {
                return 'administrador';
            }
            else {    
                return data;
            }},
            orderable: true
        },
        {data: 'id', name: 'id'}
    ],
    
    "language": {
	    "sProcessing": "Procesando...",
	    "sLengthMenu": "Mostrar _MENU_ registros",
	    "sZeroRecords": "No se encontraron resultados",
	    "sEmptyTable": "Ningún dato disponible en esta tabla",
	    "sInfo": "Mostrando registros del _START_ al _END_",
	    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
	    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix": "",
	    "sSearch": "Buscar:",
	    "sUrl": "",
	    "sInfoThousands": ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
	    "oAria": 
        {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }

}
});