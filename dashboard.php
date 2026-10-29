<?php
require "config.php";

if (!isset($_SESSION["usuario_id"])) {
header("Location: index.php");
exit;
}

$errores = [];
$guardado = false;

$nombre = "";
$instrumento = "";
$nivel = "";
$correo = "";
$stock = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nombre = trim($_POST["nombre"] ?? "");
$instrumento = trim($_POST["instrumento"] ?? "");
$nivel = trim($_POST["nivel"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$stock = trim($_POST["stock"] ?? "");

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

if (count($errores) == 0) {

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

$guardado = true;

$nombre = "";
$instrumento = "";
$nivel = "";
$correo = "";
$stock = "";
}
}

$alumnos = $conexion->query("SELECT * FROM alumnos ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel | Academia de Música</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header>
<h1>Academia de Música</h1>

<div>
<span>Hola, <?php echo $_SESSION["usuario_nombre"]; ?></span>
<a href="logout.php">Cerrar sesión</a>
</div>
</header>

<main>

<section class="tarjeta">

<h2>Registrar alumno</h2>

<?php
if ($guardado) {
echo "<div class='correcto'>Alumno registrado correctamente.</div>";
}

if (count($errores) > 0) {

foreach ($errores as $error) {
echo "<div class='error'>" . $error . "</div>";
}
}
?>

<form action="dashboard.php" method="POST">

<label for="nombre">Nombre</label>
<input 
    type="text" 
    id="nombre" 
    name="nombre"
    value="<?php echo $nombre; ?>">

<label for="instrumento">Instrumento</label>
<input 
    type="text" 
    id="instrumento" 
    name="instrumento"
    value="<?php echo $instrumento; ?>">

<label for="nivel">Nivel</label>
<select id="nivel" name="nivel">

<option value="">Selecciona</option>

<option value="Principiante"
<?php
if ($nivel == "Principiante") {
echo "selected";
}
?>
>
Principiante
</option>

<option value="Intermedio"
<?php
if ($nivel == "Intermedio") {
echo "selected";
}
?>
>
Intermedio
</option>

<option value="Avanzado"
<?php
if ($nivel == "Avanzado") {
echo "selected";
}
?>
>
Avanzado
</option>

</select>

<label for="correo">Correo</label>
<input 
    type="email" 
    id="correo" 
    name="correo"
    value="<?php echo $correo; ?>">

<label for="stock">Stock</label>
<input 
    type="number" 
    id="stock" 
    name="stock" 
    min="0"
    value="<?php echo $stock; ?>">

<button type="submit">Guardar</button>

</form>

</section>

<section class="tarjeta">

<h2>Alumnos registrados</h2>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Instrumento</th>
<th>Nivel</th>
<th>Correo</th>
<th>Stock</th>
</tr>

<?php
foreach ($alumnos as $alumno) {

echo "<tr>";
echo "<td>" . $alumno["id"] . "</td>";
echo "<td>" . $alumno["nombre"] . "</td>";
echo "<td>" . $alumno["instrumento"] . "</td>";
echo "<td>" . $alumno["nivel"] . "</td>";
echo "<td>" . $alumno["correo"] . "</td>";
echo "<td>" . $alumno["stock"] . "</td>";
echo "</tr>";

}
?>

</table>

</section>

</main>

<script src="script.js"></script>
</body>
</html>