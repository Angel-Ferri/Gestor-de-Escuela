<?php
    $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    $currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('n') - 1;
    $currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
    
    if ($currentMonth < 0) {
        $currentMonth = 11;
        $currentYear--;
    } elseif ($currentMonth > 11) {
        $currentMonth = 0;
        $currentYear++;
    }
    
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth + 1, $currentYear);

    // Datos de asistencia simulados
    $consulta = $conexion->prepare("SELECT fecha, presente FROM asistencia WHERE dni = :dni ORDER BY fecha ASC");
    $consulta->bindParam(':dni', $dni, PDO::PARAM_STR);
    $consulta->execute();
    $asistencias = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="estilo.css">
    <div class="cu-calenda">
        <div class="calendar">
            <div class="month">
                <a class="flechas" href="?month=<?= $currentMonth - 1; ?>&year=<?= $currentYear; ?>">🡸</a>
                <?= $months[$currentMonth] . " " . $currentYear; ?>
                <a class="flechas" href="?month=<?= $currentMonth + 1; ?>&year=<?= $currentYear; ?>">🡺</a>
            </div>
            <div class="days">
                <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                    <?php 
                        $currentDate = sprintf("%04d-%02d-%02d", $currentYear, $currentMonth + 1, $i);
                        $icon = "";
                        foreach ($asistencias as $asistencia) {
                            if ($asistencia['fecha'] === $currentDate) {
                                $icon = $asistencia['presente'] === 'Si' ? '✅' : '❌';
                                break;
                            }
                        }
                    ?>
                    <p class="day">
                        <?= $i; ?> <span class="icon"><?= $icon; ?></span>
                    </p>
                <?php endfor; ?>
            </div>
        </div>
    </div>
