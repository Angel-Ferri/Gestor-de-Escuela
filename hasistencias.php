<?php
session_start();
include('partes/conexion.php');

// Verifica si el usuario está logueado
if (!isset($_SESSION['dni']) || !isset($_SESSION['correo'])) {
    header("Location: partes/Login.php");
    exit;
}

$dni = $_SESSION['dni'];

// Obtiene los datos del usuario y el curso si es preceptor
$stmt = $conexion->prepare("SELECT * FROM preceptores WHERE dni = :dni");
$stmt->execute([':dni' => $dni]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$curso = $usuario['curso'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
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
        <?php include('simple/barra.php'); ?>
        <div class="con-body">
            <?php if ($curso): ?>
                <div class="contedehas">
                    <h2>Registro de Asistencias</h2>
                    <div class="search">
                        <form role="search" method="post">
                            <p>Ingresar el DNI del alumno</p>
                            <input type="search" name="busdni" placeholder="Cargar el DNI del alumno" />
                            <p>Ingresar la fecha</p>
                            <input type="date" name="busfecha">
                            <button type="submit" name="busca">Buscar</button>
                        </form>
                    </div>
                    <div class='tabla-container'>
                        <table class='historialdeasistencias-tabla'>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>Fecha</th>
                                <th>Presente</th>
                            </tr>

                            <?php
                            $query = "SELECT a.nombre, a.apellido, asi.dni, asi.fecha, asi.presente 
                                      FROM alumnos a 
                                      LEFT JOIN asistencia asi ON a.dni = asi.dni 
                                      WHERE a.curso = :curso";
                            $params = [':curso' => $curso];

                            if (isset($_POST['busca'])) {
                                //Variables declaras
                                $busdni = $_POST['busdni'] ?? null;
                                $busfech = $_POST['busfecha'] ?? null;
                                // Si dni exite
                                if (!empty($busdni)) {
                                    $query .= " AND asi.dni = :dni";
                                    $params[':dni'] = $busdni;
                                }
                                //Si fecha existe
                                if (!empty($busfech)) {
                                    $query .= " AND asi.fecha = :fecha";
                                    $params[':fecha'] = $busfech;
                                }
                            }

                            $stmt = $conexion->prepare($query);
                            $stmt->execute($params);
                            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($resultados) {
                                foreach ($resultados as $row) {
                                    // Variables declaradas de caracteristicas
                                    $nombre = $row['nombre'];
                                    $apellido = $row['apellido'];
                                    $dnial = $row['dni'];
                                    $fecha = $row['fecha'];
                                    $presente = $row['presente'];
                                    // Estado de Carga
                                    $estado = ($presente == 'presente') ? 
                                        "<span class='historialdeasistencias-presente'>✅ Presente</span>" : 
                                        "<span class='historialdeasistencias-ausente'>❌ Ausente</span>";
                                    // Impresion de las caracteristicas
                                    echo "<tr>
                                            <td>{$nombre}</td>
                                            <td>{$apellido}</td>
                                            <td>{$dnial}</td>
                                            <td>{$fecha}</td>
                                            <td>{$estado}</td>
                                          </tr>";
                                }
                            } // Solo muestra cuando no se encuentra nada 
                            else {
                                echo "<tr><td colspan='5'>No se encontraron registros.</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p>No tienes acceso a esta sección.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
