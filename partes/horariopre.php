<?php
// Obtener el curso del preceptor
$stmtCurso = $conexion->query("SELECT curso FROM preceptores WHERE dni = '$dni'");
$cursoa = $stmtCurso->fetchColumn();

// Obtener divisiones del curso
$stmtDivisiones = $conexion->query("SELECT DISTINCT division FROM horarios WHERE curso = '$cursoa'");
$divisiones = $stmtDivisiones->fetchAll(PDO::FETCH_COLUMN);

// Iterar por cada división
foreach ($divisiones as $division) {
    echo "<h3>Horarios - Curso $cursoa División $division</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Horario</th>";

    // Obtener días únicos
    $stmtDias = $conexion->query("
        SELECT DISTINCT dia 
        FROM horarios 
        WHERE curso = '$cursoa' AND division = '$division' 
        ORDER BY FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes')
    ");
    $dias = $stmtDias->fetchAll(PDO::FETCH_COLUMN);

    foreach ($dias as $dia) {
        echo "<th>$dia</th>";
    }
    echo "</tr>";

    // Obtener horas únicas
    $stmtHoras = $conexion->query("
        SELECT DISTINCT inicio 
        FROM horarios 
        WHERE curso = '$cursoa' AND division = '$division' 
        ORDER BY STR_TO_DATE(inicio, '%H:%i')
    ");
    $horas = $stmtHoras->fetchAll(PDO::FETCH_COLUMN);

    foreach ($horas as $hora) {
        echo "<tr><td>$hora</td>";

        foreach ($dias as $dia) {
            // Traer clase con materia y profesor
            $stmtClase = $conexion->query("
                SELECT m.materia, h.termina, p.nombre, p.apellido 
                FROM horarios h 
                JOIN materias m ON h.materia = m.id 
                JOIN profesores p ON h.profesor = p.dni 
                WHERE h.curso = '$cursoa' AND h.division = '$division' 
                AND h.dia = '$dia' AND h.inicio = '$hora'
            ");
            $fila = $stmtClase->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                echo "<td>
                        <strong>{$fila['materia']}</strong><br>
                        ({$hora} - {$fila['termina']})<br>
                        Prof: {$fila['nombre']} {$fila['apellido']}
                      </td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }

    echo "</table><br>";
}
?>
