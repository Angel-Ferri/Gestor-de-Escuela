<?php
  include('partes/conexion.php');  
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

        <a href="index.php">Inicio</a>
        <a href="Directivos.php">Directivos</a>
        <a href="Preceptores.php">Preceptores</a>
        <a href="Profesores.php">Profesores</a>
        <a href="Alumnos.php">Alumnos</a>
    </header>
    <main>
    <div class="izquierdabody">
        <h3>Sistema de Gestión Escolar LEO</h3>
        <p>El sistema de gestión escolar LEO permite a cada institución educativa que lo utilice acceder a datos administrativos de manera eficiente. Ha sido diseñado pensando en la comodidad de estudiantes, profesores, preceptores y directivos.</p>
        
        <h3>Beneficios</h3>
        
        <h4>Estudiantes</h4>
        <p>Este gestor permite a cada estudiante acceder a sus datos personales, así como consultar sus notas, asistencias y horarios de clases.</p>
        
        <h4>Preceptores</h4>
        <p>Los preceptores pueden acceder a sus datos personales, gestionar las notas de los alumnos, monitorear asistencias y crear horarios tanto para estudiantes como para profesores.</p>
        
        <h4>Profesores</h4>
        <p>Los docentes pueden acceder a sus datos personales y gestionar las calificaciones de sus alumnos.</p>
        
        <h4>Directivos</h4>
        <p>Los directivos tienen acceso a sus datos personales y pueden supervisar la gestión de preceptores, profesores y alumnos.</p>
    </div>
    <div class="derechabody">
        <!-- Login -->
        <div class="login"> 
            <h3>Iniciar sesión</h3>
    <!-- Se compara el DNI y el correo -->
            <form method="POST" >
                <label for="dni">DNI</label>
                <input type="text" name="dni" id="dni" required>
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" required>
                <label for="clave">Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" required>
                <input type="submit" value="Ingresar">
            </form>
                <?php 
                include('partes/Login.php'); 
                ?>
            </div>    
        </div>
    </main>
</body>
</body>
</html>