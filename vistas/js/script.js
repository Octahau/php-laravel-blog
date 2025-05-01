
/*=============================================
BANNER
=============================================*/

$(".fade-slider").jdSlider({

	isSliding: false,
	isAuto: true,
	isLoop: true,
	isDrag: false,
	interval:5000,
	isCursor: false,
	speed:3000

});

var alturaBanner = $(".fade-slider").height();

$(".bannerEstatico").css({"height":alturaBanner+"px"})


/*=============================================
ANIMACIONES SCROLL
=============================================*/

$(window).scroll(function(){

	var posY = window.pageYOffset;
	
	if(posY > alturaBanner){

		$("header").css({"background":"white"})

		$("header .logotipo").css({"filter":"invert(100%)"})

		$(".fa-search, .fa-bars").css({"color":"black"})

	}else{

		$("header").css({"background":"rgba(0,0,0,.5)"})

		$("header .logotipo").css({"filter":"invert(0%)"})

		$(".fa-search, .fa-bars").css({"color":"white"})

	}

})

/*=============================================
MENÚ
=============================================*/

$(".fa-bars").click(function(){

	$(".menu").fadeIn("fast");

})

$(".btnClose").click(function(e){

	e.preventDefault();

	$(".menu").fadeOut("fast");

})

/*=============================================
GRID CATEGORÍAS
=============================================*/

$(".grid figure, .gridFooter figure").mouseover(function(){

	$(this).css({"background-position":"right bottom"})

})

$(".grid figure, .gridFooter figure").mouseout(function(){

	$(this).css({"background-position":"left top"})

})

$(".grid figure, .gridFooter figure").click(function(){

	var vinculo = $(this).attr("vinculo");

	window.location = vinculo;

})

/*=============================================
PAGINACIÓN
=============================================*/
var totalPaginas = Number($(".pagination").attr("totalPaginas"));
var rutaActual = $("#rutaActual").val();
var paginaActual = Number($(".pagination").attr("paginaActual"));
var rutaPagina = $(".pagination").attr("rutaPagina");

if ($(".pagination").length != 0) {
    // Validación de totalPaginas
    if (isNaN(totalPaginas) || totalPaginas <= 0) {
        totalPaginas = 1; // Valor por defecto si totalPaginas no es válido
    }

    $(".pagination").twbsPagination({
        totalPages: totalPaginas,
        startPage: paginaActual,
        visiblePages: 4,
        first: "Primero",
        last: "Ultimo",
        prev: '<i class="fas fa-angle-left"></i>',
        next: '<i class="fas fa-angle-right"></i>'
    }).on("page", function(evt, page) {
        // Construcción de la URL de manera segura
        var url = rutaActual + (rutaPagina ? rutaPagina + "/" : "") + page;
        location.href = url;
    });
}


/*=============================================
SCROLL UP
=============================================*/

$.scrollUp({
	scrollText:"",
	scrollSpeed: 2000,
	easingType: "easeOutQuint"
})

/*=============================================
DESLIZADOR DE ARTÍCULOS
=============================================*/


$(".deslizadorArticulos").jdSlider({
	wrap: ".slide-inner",
	slideShow: 3,
	slideToScroll:3,
	isLoop: true,
	responsive: [{
		viewSize: 320,
		settings:{
			slideShow: 1,
			slideToScroll: 1
		}

	}]

})

//$('.social-share').shapeShare();

/*=============================================
			REVISAR OPINIONES
=============================================*/	
$(document).ready(function () {
    const opiniones = $(".opiniones");

    if (opiniones.length === 1 && opiniones.attr("data-empty") === "true") {
        const noHayOpiniones = `
            <div class="col-12">
                <div class="alert alert-warning">No hay opiniones</div>
            </div>`;
        opiniones.html(noHayOpiniones);
    }
});
/*=============================================
			SUBIR FOTO OPINIONES
=============================================*/	
$("#fotoOpinion").change(function() {
	var imagen = this.files[0];
	//console.log("imagen", imagen);
	$(".alert").remove();

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/jpng") 
	{
		$("#fotoOpinion").val("");
		$("fotoOpinion").after('<div class="alert alert-danger">El archivo debe ser formato JPG o PNG</div>');
		
		return;
	}
	else if(imagen["size"] > 2000000)
	{
		$("#fotoOpinion").val("");
		$("fotoOpinion").after('<div class="alert alert-danger">El archivo no debe pesar más de 2MB</div>');
		
		return;
	}
	else
	{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event) 
		{
			var rutaImagen = event.target.result;
			$(".prevFotoOpinion").attr("src", rutaImagen);
		});
	}
});

/*=============================================
			BUSCADOR
=============================================*/
$(".buscador").change(function() {
    var busqueda = $(this).val();
    var expresion = /^[a-z0-9ñáéíóú ]*$/i; // Agregamos la bandera "i" para ignorar mayúsculas/minúsculas

    if (!expresion.test(busqueda)) {
        $(".buscador").val(""); // Si no cumple la validación, vacía el campo
    } else {
        // Normalizamos la búsqueda, reemplazando espacios por guiones bajos y eliminando acentos
        var evaluarBusqueda = busqueda
            .toLowerCase() // Convertir a minúsculas
            .normalize("NFD") // Descomponer caracteres acentuados
            .replace(/[\u0300-\u036f]/g, "") // Eliminar marcas de acento
            .replace(/ /g, "_") // Reemplazar espacios por guiones bajos
            .replace(/[^a-z0-9_ñ]/g, ""); // Eliminar caracteres no válidos

        var rutaBuscador = evaluarBusqueda;

        // Configuramos el evento click del botón buscar
        $(".buscar").off("click").on("click", function() {
            if ($(".buscador").val() !== "") {
                window.location = rutaActual + rutaBuscador; // Redirigimos con la ruta formateada
            }
        });
    }
});
/*=============================================
			TECLA ENTER
=============================================*/
$(document).on("keyup",".buscador", function(evento) 
{
	evento.preventDefault();
if(evento.keyCode == 13 && $(".buscador").val() != "")
{
	var busqueda = $(this).val();
    var expresion = /^[a-z0-9ñáéíóú ]*$/i; // Agregamos la bandera "i" para ignorar mayúsculas/minúsculas

		if (!expresion.test(busqueda)) 
		{
			$(".buscador").val(""); // Si no cumple la validación, vacía el campo
		} 
		else 
		{
			// Normalizamos la búsqueda, reemplazando espacios por guiones bajos y eliminando acentos
			var evaluarBusqueda = busqueda
				.toLowerCase() // Convertir a minúsculas
				.normalize("NFD") // Descomponer caracteres acentuados
				.replace(/[\u0300-\u036f]/g, "") // Eliminar marcas de acento
				.replace(/ /g, "_") // Reemplazar espacios por guiones bajos
				.replace(/[^a-z0-9_ñ]/g, ""); // Eliminar caracteres no válidos

			var rutaBuscador = evaluarBusqueda;
			window.location = rutaActual + rutaBuscador; // Redirigimos con la ruta formateada
		}
	}
});