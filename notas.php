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
        <h1>Notas</h1>
        <a href="index.php">Inicio</a>
        <a href="Directivos.php">Directivos</a>
        <a href="Preceptores.php">Preceptores</a>
        <a href="Profesores.php">Profesores</a>
        <a href="Alumnos.php">Alumnos</a>
    </header>
        <table>
            <tr>
                <td>Informacion Personal</td>
                <td>Nombre: </td>
                <td>Apellido: </td>
                <td>Edad: </td>
                <td>Curso</td>
                <td>Division</td>
                <td>Turno</td>
                <td>Año de Emicion</td>
                <td>2025</td>
                <td>Presentes/Dias Habiles</td>
                <td>2/5</td>

            </tr>
            <tr>
                <td>Materia</td>
                <td colspan="6">Primer Trimestre</td>
                <td colspan="6">Segundo Trimestre</td>
                <td colspan="6">Tercer Trimestre</td>
                <td>Primer Examen Regular</td>
                <td>Segundo Examen Regular</td>
            </tr>
            <tr>
                <td>Matemáticas</td>
                <td>8</td>
                <td>7</td>
                <td>9</td>
                <td>6</td>
                <td>8</td>
                <td>7.6</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>7</td>
                <td>7.4</td>
                <td>7</td>
                <td>8</td>
                <td>6</td>
                <td>9</td>
                <td>8</td>
                <td>7.6</td>
                <td>8</td>
                <td>7</td>
            </tr>
            <tr>
                <td>Lengua</td>
                <td>9</td>
                <td>8</td>
                <td>7</td>
                <td>9</td>
                <td>8</td>
                <td>8.2</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>7</td>
                <td>8</td>
                <td>7.8</td>
                <td>8</td>
                <td>9</td>
                <td>7</td>
                <td>9</td>
                <td>8</td>
                <td>8.2</td>
                <td>9</td>
                <td>8</td>
            </tr>
        </table>
</body>
</html>
