<?php
require "config.php";

$correo = $_POST["correo"];
$clave = $_POST["clave"];

$sql = "SELECT * FROM usuarios WHERE correo = :correo";

$consulta = $conexion->prepare($sql);
$consulta->execute([":correo" => $correo]);

$usuario = $consulta->fetch();

if ($usuario && password_verify($clave, $usuario["clave"])) {

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["usuario_nombre"] = $usuario["nombre"];

header("Location: dashboard.php");
exit;

} else {
header("Location: index.php?error=1");
exit;
}
?>