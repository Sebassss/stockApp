<?php
//guardo posición de menú en la variable session
 $_SESSION['menu'] = "abm_articulos";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo</title>


    <script src="core/Grid/Grid.js"></script>

</head>

<body>

<div class="box box-primary">
    <section class="content-header">
        <h1>Administración de artículos</h1>
    </section>

    <section class="content">
        <div id="table"  ></div>
    </section>
</div>
</body>

</html>

<script src="core/abm.articulos.js"></script>
