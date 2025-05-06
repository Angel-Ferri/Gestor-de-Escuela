<?php

//Trae a los preceptores
$precepbarra = $conexion->query("SELECT * FROM `preceptores` WHERE dni = '$dni'")->rowCount();
//Trae a los directovos
$directibarra = $conexion->query("SELECT * FROM `directivos` WHERE dni = '$dni'")->rowCount();
//Trae a los Profesores
$profebarra = $conexion->query("SELECT * FROM `profesores` WHERE dni ='$dni'")->rowCount();


if ($precepbarra == 1) {
    // Brra de preceptores
?>        <div class="barra">
            <h3>INFORMACIÓN</h3>
            <a href="Preceptores.php"><p>Principal</p></a>
            <a href="Preceptores.php"><p>Horarios</p></a>
            <a href="#"><p>Libretas Virtual</p></a>
            <a href="Carga asistencias.php"><p>Asistencias</p></a>
            <a href="hasistencias.php"><p>Historial de asistencias</p></a>
            <a href="#"><p>Programa de los Profesores</p></a>
            <a href="Preceptores.php"><p>Reportes</p></a>
        </div>
<?php
}// Cierro el if
if ($profebarra == 1) {
    // Barra de Profesores
?>
    <div class="barra">
            <h3>INFORMACIÓN</h3>
            <a href="Profesores.php"><p>Principal</p></a>
            <a href="profehorarios.php"><p>Horarios</p></a>
            <a href="profecanota.php"><p>Cargar Notas</p></a>
            <a href="profepro.php"><p>Cargar Programa</p></a>
            <a href="progeeva.php"><p>Generador de evaluaciones</p></a>

        </div>
<?php
}

if ($directibarra == 1) {
    // Barra de directivos
?>
        <div class="barra">
            <h3>INFORMACIÓN</h3>
            <a href="Profesores.php"><p>Principal</p></a>
            <a href="profepro.php"><p>Cargar Programa</p></a>
            <a href="profecanota.php"><p>Cargar Notas</p></a>
            <a href="profehorarios.php"><p>Horarios</p></a>
        </div>
<?php
}
?>