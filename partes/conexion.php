<?php
    //Conexion a la base de datos
     $conexion = new PDO('mysql:host=localhost;dbname=gestor leo', 'root', '');
     if(!$conexion){
         echo 'Error al conectar a la base de datos';
     }
     else{
        //  echo 'Conectado a la base de datos';
     }

    // Variables generales
    // Titulo
    $tituloycss = "
    <title>Escuela</title>
    <link rel='stylesheet' href='partes/estilo.css'>
    ";

    $Usuario = "Nombre de Usuario";
    
    echo"<script>
    // Función para cambiar el texto de los encabezados
    function cambiarTexto() {
        document.getElementById('titulo').innerText = 'Gestor de Escuela Leo';
        document.getElementById('subtitulo').innerText = '';
    }

    // Cambiar el texto después de 2 minutos (120000 milisegundos)
    setTimeout(cambiarTexto, 120000);
    </script>";
?>
<!-- Inyeccion a la base -->

<script type="text/javascript">
        function showAlert() {
            alert("¡Los datos se han cargado correctamente!");
        }
</script>

<?php

?>
