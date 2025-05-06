<?php
// Obtener curso y división del alumno logueado
$alumno = $conexion->query("SELECT curso, division FROM alumnos WHERE dni = '$dni'")->fetch(PDO::FETCH_ASSOC);

if ($alumno) {
    $curso = $alumno['curso'];
    $division = $alumno['division'];

    echo "<h3>Horario del Alumno - Curso $curso División $division</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Horario</th>";

    // Obtener los días de clase ordenados
    $diasQuery = $conexion->query("
        SELECT DISTINCT dia 
        FROM horarios 
        WHERE curso = '$curso' AND division = '$division' 
        ORDER BY FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes')
    ");
    $dias = $diasQuery->fetchAll(PDO::FETCH_COLUMN);

    foreach ($dias as $dia) {
        echo "<th>$dia</th>";
    }
    echo "</tr>";

    // Obtener horas únicas
    $horasQuery = $conexion->query("
        SELECT DISTINCT inicio 
        FROM horarios 
        WHERE curso = '$curso' AND division = '$division' 
        ORDER BY STR_TO_DATE(inicio, '%H:%i')
    ");
    $horas = $horasQuery->fetchAll(PDO::FETCH_COLUMN);

    foreach ($horas as $hora) {
        echo "<tr><td>$hora</td>";

        foreach ($dias as $dia) {
            // Traer datos de la clase (materia, termina, profesor)
            $claseQuery = $conexion->query("
                SELECT m.materia, h.termina, p.nombre, p.apellido 
                FROM horarios h 
                JOIN materias m ON h.materia = m.id 
                JOIN profesores p ON h.profesor = p.dni 
                WHERE h.curso = '$curso' AND h.division = '$division' 
                AND h.dia = '$dia' AND h.inicio = '$hora'
            ");
            $clase = $claseQuery->fetch(PDO::FETCH_ASSOC);

            if ($clase) {
                echo "<td>
                        <strong>{$clase['materia']}</strong><br>
                        ({$hora} - {$clase['termina']})<br>
                        Prof: {$clase['nombre']} {$clase['apellido']}
                      </td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron datos del alumno.";
}
?>

