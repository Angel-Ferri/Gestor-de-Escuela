<?php
session_start();
include('partes/conexion.php');

// Verifica si el usuario está logueado
if (!isset($_SESSION['dni']) || !isset($_SESSION['correo'])) {
    header("Location: partes/Login.php");
    exit;
}

// Obtén los datos del usuario desde la base de datos
$dni = $_SESSION['dni'];
$correo = $_SESSION['correo'];
$stmt = $conexion->prepare("SELECT * FROM `preceptores` WHERE dni = ?");
$stmt->execute([$dni]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Consulta para obtener las fechas y asistencias
$consulta = $conexion->query("SELECT fecha, presente FROM asistencia WHERE dni = '$dni' ORDER BY fecha ASC");
$asistencias = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
        <?php  include('simple/barra.php'); ?>
        <div class="con-body">
        <div class="alineador">
                    <div class="subconte">
                        <h3>Informacion Personal</h3>
                        <?php
                            include('partes/informacion.php');
                        ?>
                    </div>
                    <div class="subconte">
                        <h3>Horarios</h3>
                        <?php
                            include('partes/horariopre.php');
                        ?>
                    </div>
                </div>
                <div class="alineador">
                    <div class="subconte">
                        <h3>Reportes de Direccion</h3>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                    </div>
                    <div class="subconte">
                        <h3>Reportes de Profesores</h3>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                        <p>Mondongo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
