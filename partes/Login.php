<?php
session_start(); 

if (isset($_POST['dni']) && isset($_POST['correo']) && isset($_POST['contraseña'])) {
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Consulta y busca en la columna donde exista los datos
    $stmt = $conexion->prepare("
        SELECT 'Alumnos' AS tipo, dni, correo FROM alumnos WHERE dni = ? AND correo = ? AND `password` = ?
        UNION 
        SELECT 'Profesores' AS tipo, dni, correo FROM profesores WHERE dni = ? AND correo = ? AND `password` = ?
        UNION 
        SELECT 'Preceptores' AS tipo, dni, correo FROM preceptores WHERE dni = ? AND correo = ? AND `password` = ?
        UNION 
        SELECT 'Directivos' AS tipo, dni, correo FROM directivos WHERE dni = ? AND correo = ? AND `password` = ?
    ");
    $stmt->execute([$dni, $correo, $contraseña, $dni, $correo, $contraseña, $dni, $correo, $contraseña, $dni, $correo, $contraseña]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION['dni'] = $usuario['dni'];
        $_SESSION['correo'] = $usuario['correo'];
        header("Location: " . $usuario['tipo'] . ".php");
        exit;
    } else {
        echo "<script>window.alert('Credenciales incorrectas');</script>";
    }
}
?>
