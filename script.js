document.addEventListener("DOMContentLoaded", function () {

var formularios = document.querySelectorAll("form");

formularios.forEach(function (formulario) {

formulario.addEventListener("submit", function (evento) {

var campos = formulario.querySelectorAll("input, select");
var vacio = false;

campos.forEach(function (campo) {
if (campo.value.trim() === "") {
vacio = true;
}
});

if (vacio) {
evento.preventDefault();
alert("Completa todos los campos.");
}

});

});

});