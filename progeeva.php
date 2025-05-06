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
            

            <form method="POST" class="geeva-form" enctype="multipart/form-data">
                <h2>📝 Generador de Evaluaciones</h2>
                
                <div class="geeva-group">
                    <!-- tus otros campos -->
                    <label for="logo">Logo de la escuela (opcional):</label>
                    <input type="file" name="logo" id="logo" accept="image/*">

                </div>


                <div class="geeva-group">
                    <label class="geeva-label">Título</label>
                    <input type="text" name="titulo" class="geeva-input" required>

                <div class="geeva-group">
                    <label class="geeva-label">Materia</label>
                    <input type="text" name="materia" class="geeva-input" required>
                </div>

                <div class="geeva-group">
                    <label class="geeva-label">Profesor</label>
                    <input type="text" name="profesor" class="geeva-input" value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" readonly>
                </div>

                <div class="geeva-group">
                    <label class="geeva-label">Temas</label>
                    <input type="text" name="temas" class="geeva-input">
                </div>

                <div class="geeva-group">
                    <label class="geeva-label">Subtítulo</label>
                    <input type="text" name="subtitulo" class="geeva-input">
                </div>

                <div class="geeva-group">
                    <label class="geeva-label">Actividades</label>
                    <div id="actividades-container">
                        <textarea name="actividades[]" class="geeva-textarea" placeholder="Actividad 1" required></textarea>
                    </div>
                    <div class="geeva-add">
                        <button type="button" onclick="agregarActividad()">➕ Agregar actividad</button>
                    </div>
                </div>

                <button type="submit" class="geeva-button">Generar Evaluación</button>
            </form>
            <?php
            print_r($_POST);
            ?>
            <script>
                let contador = 2;
                function agregarActividad() {
                    const container = document.getElementById('actividades-container');
                    const textarea = document.createElement('textarea');
                    textarea.name = "actividades[]";
                    textarea.className = "geeva-textarea";
                    textarea.placeholder = "Actividad " + contador++;
                    container.appendChild(textarea);
                }
            </script>

            <?php
                //Generador de evaluaciones
                include('partes/geneeva.php');
            ?>
        </div>
    </div>
</body>
</html>
