<?php
require "config.php";

$mensaje = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nombre = trim($_POST["nombre"]);
$correo = trim($_POST["correo"]);
$clave = $_POST["clave"];
$confirmar = $_POST["confirmar"];

if ($nombre == "" || $correo == "" || $clave == "" || $confirmar == "") {

$mensaje = "Completa todos los campos.";
$tipo = "error";

} elseif ($clave != $confirmar) {

$mensaje = "Las contraseñas no coinciden.";
$tipo = "error";

} elseif (strlen($clave) < 6) {

$mensaje = "La contraseña debe tener al menos 6 caracteres.";
$tipo = "error";

} else {

$verificar = $conexion->prepare(
"SELECT id FROM usuarios WHERE correo = :correo"
);

$verificar->execute([":correo" => $correo]);

if ($verificar->fetch()) {

$mensaje = "Ese correo ya está registrado.";
$tipo = "error";

} else {

$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, correo, clave)
VALUES (:nombre, :correo, :clave)";

$consulta = $conexion->prepare($sql);

$consulta->execute([
":nombre" => $nombre,
":correo" => $correo,
":clave" => $clave_cifrada
]);

$mensaje = "Cuenta creada correctamente. Ya puedes iniciar sesión.";
$tipo = "correcto";
}
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrarse | Academia de Música</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="caja">

<div class="logo">🎵</div>

<h1>Crear cuenta</h1>
<p class="subtitulo">Regístrate para usar el sistema</p>

<?php
if ($mensaje != "") {

if ($tipo == "error") {
echo "<div class='error'>" . $mensaje . "</div>";
} else {
echo "<div class='correcto'>" . $mensaje . "</div>";
}
}
?>

<form action="registrarse.php" method="POST">

<label>Nombre completo</label>
<input type="text" name="nombre" required>

<label>Correo electrónico</label>
<input type="email" name="correo" required>

<label>Contraseña</label>
<input type="password" name="clave" required>

<label>Confirmar contraseña</label>
<input type="password" name="confirmar" required>

<button type="submit">Registrarme</button>

</form>

<a href="index.php" class="boton-registro">
Ya tengo cuenta
</a>

</div>

<script src="script.js"></script>
</body>
</html>