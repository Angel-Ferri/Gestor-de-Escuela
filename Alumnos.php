<?php
session_start();
include('partes/conexion.php');

// Verifica si el usuario está logueado
if (!isset($_SESSION['dni']) || !isset($_SESSION['correo'])) {
    header("Location: partes/index.php");
    exit;
}

// Obtén los datos del usuario desde la base de datos
$dni = $_SESSION['dni'];
$correo = $_SESSION['correo'];
$stmt = $conexion->prepare("SELECT * FROM alumnos WHERE dni = ?");
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
        <div class="barra">
            <h3>INFORMACIÓN</h3>
            <a href="#"><p>Información Personal</p></a>
            <a href="#"><p>Horarios</p></a>
            <a href="notas.php"><p>Notas</p></a>
            <a href="#"><p>Asistencia</p></a>
        </div>
        <div class="con-body">
                <div class="alineador">
                    <div class="subconte">
                        <?php
                            // genera la información personal
                            include('partes/informacion.php');
                        ?>
                    </div>
                    <div class="subconte">
                        <?php 
                            // genera el horario
                            include('partes/horarios.php');
                        ?>
                    </div>
                </div>
                <div class="alineador">
                    <div class="subconte">
                    <?php
                        // genera la información personal
                        include('partes/calendario.php');
                        ?>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>
