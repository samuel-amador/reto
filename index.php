<?php
require "config.php";

if (isset($_SESSION["usuario_id"])) {
header("Location: dashboard.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Academia de Música</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="caja">

<div class="logo">🎵</div>

<h1>Academia de Música</h1>
<p class="subtitulo">Sistema de gestión de alumnos</p>

<?php
if (isset($_GET["error"])) {
echo "<div class='error'>Correo o contraseña incorrectos.</div>";
}
?>

<form action="login.php" method="POST">

<label>Correo electrónico</label>
<input type="email" name="correo" required>

<label>Contraseña</label>
<input type="password" name="clave" required>

<button type="submit">Iniciar sesión</button>

</form>

<a href="registrarse.php" class="boton-registro">
Registrarse
</a>

</div>

<script src="script.js"></script>
</body>
</html>