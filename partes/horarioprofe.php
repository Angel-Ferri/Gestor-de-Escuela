<h3>Horarios</h3>
<table border='1'>
    <tr>
        <th>Horario</th>
        <?php
        // Obtener días únicos del profesor ordenados de Lunes a Viernes
        $stmt = $conexion->prepare("
            SELECT DISTINCT h.dia 
            FROM horarios h 
            WHERE h.profesor = :dni 
            ORDER BY FIELD(h.dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes')
        ");
        $stmt->execute(['dni' => $dni]);
        $diashopro = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($diashopro as $dia) {
            echo "<th>$dia</th>";
        }
        ?>
    </tr>

    <?php
    // Obtener inicios únicos del profesor ordenados cronológicamente
    $stmt = $conexion->prepare("
        SELECT DISTINCT h.inicio 
        FROM horarios h 
        WHERE h.profesor = :dni 
        ORDER BY STR_TO_DATE(h.inicio, '%H:%i')
    ");
    $stmt->execute(['dni' => $dni]);
    $inicios = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($inicios as $inicio) {
        echo "<tr>";
        echo "<td>$inicio</td>";

        foreach ($diashopro as $dia) {
            $stmt = $conexion->prepare("
                SELECT h.curso, h.division, m.materia, h.termina 
                FROM horarios h 
                JOIN materias m ON h.materia = m.id 
                WHERE h.profesor = :dni AND h.dia = :dia AND h.inicio = :inicio
            ");
            $stmt->execute([
                'dni' => $dni,
                'dia' => $dia,
                'inicio' => $inicio
            ]);
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                echo "<td>{$fila['materia']}<br>
                      ({$inicio} - {$fila['termina']})<br>
                      Curso: {$fila['curso']} División: {$fila['division']}</td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }
    ?>
</table>
