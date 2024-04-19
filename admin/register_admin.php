<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los campos del formulario (aquí puedes agregar tus propias validaciones)
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    // Verificar que las contraseñas coincidan
    if ($contrasena !== $confirmar_contrasena) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        // Hash de la contraseña antes de guardarla en la base de datos
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Incluir el archivo de configuración de la base de datos
        require 'config/database.php';

        try {
            // Crear una conexión a la base de datos
            $db = new Database();
            $con = $db->conectar();

            // Preparar la consulta SQL para insertar el nuevo administrador
            $sql = "INSERT INTO administradores (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)";
            $stmt = $con->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $hashed_password);

            // Ejecutar la consulta
            $stmt->execute();

            // Mostrar mensaje de éxito
            $mensaje = "Registro de administrador exitoso.";

        } catch (PDOException $e) {
            // En caso de error, mostrar mensaje de error
            $mensaje = "Error al registrar administrador: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Administrador</h1>
        <?php if (isset($mensaje)) : ?>
            <!-- Mostrar mensaje de éxito o error -->
            <div class="alert <?php echo $mensaje ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <!-- Campos del formulario para el registro de administrador -->
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
            <div class="mb-3">
                <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Administrador</button>
        </form>
    </div>
</body>
</html>
