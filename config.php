<?php
session_start();

$servidor = "localhost";
$base_datos = "academia_musica";
$usuario = "root";
$clave = "";

try {
$conexion = new PDO(
"mysql:host=$servidor;dbname=$base_datos;charset=utf8mb4",
$usuario,
$clave
);

$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error) {
die("Error de conexión: " . $error->getMessage());
}
?>