<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLEADOS</title>
    <link rel="stylesheet" href="assets/css/bulma.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css" type="css">
    <script src="https://kit.fontawesome.com/fa2f67eb8b.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include_once("./views/nav-bar.php"); ?>
    <div class="container">
        <?php include_once("./views/tabla-empleados.php"); ?>
        <?php include_once("./views/formulario-empleado.php"); ?>
        <?php include_once("./views/detalle-empleado.php"); ?>
    </div>

    <script src="assets/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/empleado.js?<?=uniqid()?>"></script>

</body>
</html>