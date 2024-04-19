<?php
session_start();

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la compra
    $usuario_id = $_SESSION['usuario']['id'];
    $total = 0;

    // Obtener productos del carrito
    $productos = $_SESSION['carrito']['productos'] ?? [];
    foreach ($productos as $id => $cantidad) {
        // Obtener el precio del producto
        $sql = $con->prepare("SELECT precio FROM productos WHERE id=?");
        $sql->execute([$id]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);

        // Calcular el subtotal
        $subtotal = $producto['precio'] * $cantidad;
        $total += $subtotal;

        // Insertar la compra en la base de datos (suponiendo una tabla 'compras')
        $sql = $con->prepare("INSERT INTO compras (usuario_id, producto_id, cantidad, subtotal) VALUES (?, ?, ?, ?)");
        $sql->execute([$usuario_id, $id, $cantidad, $subtotal]);

        // Restar la cantidad comprada del stock de productos
        $sql = $con->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
        $sql->execute([$cantidad, $id]);
    }

    // Limpiar el carrito
    unset($_SESSION['carrito']['productos']);

    // Redirigir a una página de confirmación
    header("Location: confirmacion.php");
    exit();
}

// Obtener productos del carrito para mostrar en el resumen
$productos = [];
foreach ($_SESSION['carrito']['productos'] as $id => $cantidad) {
    $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE id=?");
    $sql->execute([$id]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $producto['cantidad'] = $cantidad;
        $producto['subtotal'] = $producto['precio'] * $cantidad;
        $productos[] = $producto;
    }
}

// Calcular el total
$total = 0;
foreach ($productos as $producto) {
    $total += $producto['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Solutions - Checkout</title>
    <link rel="stylesheet" href="./css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img class="imagen" src="./imagenes/logoStechno.jpeg" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Marcas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Promociones</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-1" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                    <a href="checkout.php" class=" btn btn-primary ms-5">
                        Carrito<span id="num_cart" class="badge bg-secondary"><?php echo count($_SESSION['carrito']['productos'] ?? []); ?></span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <h1>Resumen de Compra</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <td>$<?php echo number_format($producto['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="3">Total:</th>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form method="post">
            <button type="submit" class="btn btn-primary">Confirmar Compra</button>
        </form>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
