<?php
// Procesar los datos del formulario de registro de vendedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los campos del formulario (aquí puedes agregar tus propias validaciones)
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Por simplicidad, aquí solo se muestra un mensaje de éxito
    $mensaje = "Registro de vendedor exitoso. Datos recibidos:<br>Nombre: $nombre<br>Correo: $correo<br>Contraseña: $contrasena";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vendedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Vendedor</h1>
        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <!-- Campos del formulario para el registro de vendedor -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Vendedor</button>
        </form>
    </div>
</body>
</html>
