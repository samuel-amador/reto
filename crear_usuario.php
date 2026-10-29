<?php
require "config.php";

$nombre = "Profesor Juan";
$correo = "juan@academia.com";
$clave = "123456";

$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, correo, clave)
VALUES (:nombre, :correo, :clave)";

$consulta = $conexion->prepare($sql);

$consulta->execute([
":nombre" => $nombre,
":correo" => $correo,
":clave" => $clave_cifrada
]);

echo "Usuario creado correctamente.";
?>