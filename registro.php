<?php
session_start();

// Verificar si el usuario ya está logueado
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    // Si ya está logueado, redirigir a la página de inicio del usuario
    header("Location: user_dashboard.php");
    exit();
}

// Si se envió el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí deberías realizar las validaciones de los datos del formulario
    // y luego insertar los datos en la base de datos
    // Por simplicidad, aquí solo se muestra un mensaje de éxito
    $mensaje = "Registro exitoso.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales para el formulario */
        .registro-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
        }
        .registro-container h1 {
            text-align: center;
        }
        .registro-container form {
            margin-top: 20px;
        }
        .registro-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .registro-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registro-container">
            <img src="./imagenes/logo_stechno_sena.png" alt="Logo" class="img-fluid">
            <h1>Registro de Usuario</h1>
            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php } ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" name="username" placeholder="Usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" placeholder="Correo Electrónico" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" placeholder="Contraseña" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" placeholder="Teléfono" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
