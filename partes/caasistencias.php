<form method="post" class="Caasistencias" onsubmit="showAlert()">
    <?php
    // Obtener el curso
    $curso = $conexion->query("SELECT curso FROM `preceptores` WHERE dni = '$dni'")->fetchColumn();

    // Obtener los alumnos según el curso
    $nomapdni = $conexion->query("SELECT * FROM `alumnos` WHERE curso = '$curso'")->fetchAll(PDO::FETCH_ASSOC);

    $fecha = date('Y-m-d'); // Devuelve la fecha actual

    // Obtener los preceptores y directivos
    $preceptora = $conexion->query("SELECT * FROM `preceptores` WHERE dni = '$dni'")->rowCount();
    $directivos = $conexion->query("SELECT * FROM `directivos` WHERE dni = '$dni'")->rowCount();
// Verificar si ya está cargado en asistencia
$consulta = $conexion->prepare("SELECT a.dni, a.apellido, a.nombre 
                                FROM alumnos a
                                WHERE a.curso = ? 
                                AND a.dni IN (SELECT dni FROM asistencia WHERE fecha = ?)");
$consulta->execute([$curso, $fecha]);
$asistencias = $consulta->fetchAll(PDO::FETCH_ASSOC);


// Inicio del envio
if (isset($_POST['carga'])) {
    // Procesar los datos de todos los alumnos
    foreach ($nomapdni as $nad) {
        // Obtener los valores de cada alumno
        $rol = $_POST['rol' . $nad['dni']] ?? '';
        $dnica = $_POST['dnialu' . $nad['dni']] ?? '';
        $asistencia = $_POST['asistencia' . $nad['dni']] ?? '';
        $tarde = $_POST['tarde' . $nad['dni']] ?? '';
        $justificado = $_POST['justificado' . $nad['dni']] ?? '';
        $fecha = date("Y-m-d");

        // Verificar que el DNI no esté vacío antes de hacer el INSERT
        if (!empty($dnica)) {
            try {
                // Preparar la consulta con marcadores para evitar inyección SQL
                $sql = "INSERT INTO `asistencia` (`dni`, `fecha`, `presente`, `rol`, `llego tarde`, `justificado`, `Prueba`) 
                        VALUES (:dni, :fecha, :presente, :rol, :tarde, :justificado, NULL)";
                
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':dni', $dnica, PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $stmt->bindParam(':presente', $asistencia, PDO::PARAM_STR);
                $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
                $stmt->bindParam(':tarde', $tarde, PDO::PARAM_STR);
                $stmt->bindParam(':justificado', $justificado, PDO::PARAM_STR);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                } else {
                    echo "Error al insertar el registro para el DNI: $dnica.";
                }
            } catch (PDOException $e) {
                echo "Error en la consulta: " . $e->getMessage();
            }
        } else {
            echo "Error: DNI vacío para el alumno " . $nad['nombre'] . " " . $nad['apellido'] . ".";
        }
    }
}
?>

<table border="1">
    <thead>
        <?php
        if (!empty($asistencias)) {
            foreach ($asistencias as $estape) {
                echo '<tr><td> Esta Cargado: Alumno: ' . $estape['apellido'] . ', ' . $estape['nombre'] . ' (DNI: ' . $estape['dni'] . ')</td></tr>';
            }
        } else {
        ?>
    </thead>
    <tr>
        <th>Rol</th>
        <th>Apellido y Nombre (DNI)</th>
        <th>¿Está Presente?</th>
        <th>¿Llegó Tarde?</th>
        <th>¿Está Justificado?</th>
        <th>Adjuntar Prueba</th>
    </tr>
    </thead>
    <tbody>
        <?php 
        $dniAsistencias = array_column($asistencias, 'dni'); // Extraer DNIs cargados
        foreach ($nomapdni as $nad): 
            $dniAlumno = $nad['dni'];
            $estaCargado = in_array($dniAlumno, $dniAsistencias);
        ?>
        <tr>
            <td>
                <select name='rol<?php echo $nad['dni']; ?>'>
                    <option>Alumno</option>
                    <option>Preceptores</option>
                    <option>Ordenanza</option>
                    <option>Profesores</option>
                </select>
            </td>
            <td>
                <p>Dni:</p><input name='dnialu<?= $nad['dni'] ?>' type='text' value='<?= $dniAlumno ?>' readonly>
                <p>Apellido:</p><input type='text' value='<?= $nad['apellido'] ?>' readonly>
                <p>Nombre:</p><input type='text' value='<?= $nad['nombre'] ?>' readonly>
            </td>
            <td>
                <label><input type='radio' class='presente' name='asistencia<?= $nad['dni'] ?>' value='presente' onclick='checkPresente(this)'> Presente</label><br>
                <label><input type='radio' class='ausente' name='asistencia<?= $nad['dni'] ?>' value='ausente' onclick='checkAusente(this)'> Ausente</label>
            </td>
            <td>
                <label><input type='radio' class='tarde-si' name='tarde<?= $nad['dni'] ?>' value='si' onclick='checkTardeSi(this)'> Sí llegó tarde</label><br>
                <label><input type='radio' class='tarde-no' name='tarde<?= $nad['dni'] ?>' value='no' onclick='checkTardeNo(this)'> No llegó tarde</label>
            </td>
            <td>
                <label><input type='radio' class='justificado-si' name='justificado<?= $nad['dni'] ?>' value='si' onclick='checkJustificadoSi(this)'> Sí está justificado</label><br>
                <label><input type='radio' class='justificado-no' name='justificado<?= $nad['dni'] ?>' value='no' onclick='checkJustificadoNo(this)'> No está justificado</label>
            </td>
            <td>
                <label>Fuera de servicio</label>
            </td>
        </tr>
        <?php 
        endforeach;
        } // Cierra el else correctamente 
        ?>
    </tbody>
</table>

    <input type="submit" value="CARGAR LOS DATOS" name="carga">
</form>

<?php

?>
