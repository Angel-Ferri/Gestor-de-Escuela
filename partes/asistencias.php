<h3>Asistencia</h3>
<table border="1">
    <tr>
        <th>Fecha</th>
        <th>Presente</th>
    </tr>
        <?php foreach ($asistencias as $asistencia): ?>
    <tr>
        <td><?php echo htmlspecialchars($asistencia['fecha']); ?></td>
        <td><?php echo $asistencia['presente'] == 'Si' ? '✅' : '❌'; ?></td>
    </tr>
    <?php endforeach; ?>
</table>