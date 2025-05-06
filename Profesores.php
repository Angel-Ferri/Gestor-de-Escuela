<?php
session_start();
include('partes/conexion.php');

// Verifica si el usuario está logueado
if (!isset($_SESSION['dni']) || !isset($_SESSION['correo'])) {
    header("Location: index.php");
    exit;
}
// Obtén los datos del usuario desde la base de datos
$dni = $_SESSION['dni'];
$correo = $_SESSION['correo'];
$stmt = $conexion->prepare("SELECT * FROM `profesores` WHERE dni = ?");
$stmt->execute([$dni]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $tituloycss; ?>
</head>
<body>
    <header>
        <h1 id="titulo">Bienvenido al gestor</h1>
        <h2 id="subtitulo">De Escuelas Leo</h2>
        <?php echo htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellido']); ?>
    </header>
    <div class="cuerpo">
        <!-- Barra -->
        <?php include('simple/barra.php'); ?>
        <div class="con-body">
            <?php
                include('partes/informacion.php');
            ?>
            <div class="subconte">
                <h2>Reportes Directivos</h2>
                <p>Mondongo</p>
                <p>Mondongo</p>
                <p>Mondongo</p>
                <p>Mondongo</p>
            </div>
            <div class="subconte">
                <h2>Reportes Preceptores</h2>
                <p>Mondongo</p>
                <p>Mondongo</p>
                <p>Mondongo</p>
                <p>Mondongo</p>
            </div>
        </div>
    </div>
</body>
</html>
