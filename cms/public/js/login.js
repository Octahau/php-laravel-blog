/*==============================
        CREAR COOKIES
===============================*/
function crearCookie(nombre, valor, dias) {
    var fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
    var expires = "expires=" + fecha.toUTCString();
    document.cookie = nombre + "=" + valor + ";" + expires + ";path=/";
}
/*==============================
            COOKIES
===============================*/
$(".email_login").change(function(){
    crearCookie("email_login", $(this).val(), 1);
});