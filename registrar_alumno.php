<?php
require "config.php";

if (!isset($_SESSION["usuario_id"])) {
header("Location: index.php");
exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$instrumento = trim($_POST["instrumento"] ?? "");
$nivel = trim($_POST["nivel"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$stock = trim($_POST["stock"] ?? "");

$errores = [];

if ($nombre == "") {
$errores[] = "Indica el nombre del alumno.";
}

if ($instrumento == "") {
$errores[] = "Indica el instrumento del alumno.";
}

if ($nivel == "") {
$errores[] = "Selecciona el nivel del alumno.";
}

if ($correo == "") {
$errores[] = "Indica el correo del alumno.";
}

if ($stock == "") {
$errores[] = "Indica el stock del alumno.";
}

if ($stock != "" && !ctype_digit($stock)) {
$errores[] = "El stock debe ser un número entero.";
}

if ($stock != "" && ctype_digit($stock) && $stock < 0) {
$errores[] = "El stock no puede ser negativo.";
}

if (count($errores) > 0) {
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Error | Academia de Música</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<main class="tarjeta">

<h2>No se pudo registrar el alumno</h2>

<?php
foreach ($errores as $error) {
echo "<p class='error'>" . $error . "</p>";
}
?>

<a href="dashboard.php">Volver al panel</a>

</main>

</body>
</html>

<?php
exit;
}

$sql = "INSERT INTO alumnos (nombre, instrumento, nivel, correo, stock)
VALUES (:nombre, :instrumento, :nivel, :correo, :stock)";

$consulta = $conexion->prepare($sql);

$consulta->execute([
":nombre" => $nombre,
":instrumento" => $instrumento,
":nivel" => $nivel,
":correo" => $correo,
":stock" => $stock
]);

header("Location: dashboard.php");
exit;
?>