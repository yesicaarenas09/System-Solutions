<?php
// Incluir configuración y conexión a la base de datos
require_once 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();

// Obtener id y token de la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Verificar si los parámetros están presentes
if ($id == '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    // Generar el token temporal y verificar con el token proporcionado
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        // Consultar si el producto existe y está activo
        $sql = $con->prepare("SELECT nombre, descripcion, precio, marca, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
        $sql->execute([$id]);

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $marca = $row['marca'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_imagenes = 'imagenes/productos/' . $id . '/';
            $rutaImg = $dir_imagenes . 'principal.jpeg';

            if (!file_exists($rutaImg)) {
                $rutaImg = 'imagenes/no-photo.jpeg';
            }

            $images = array();
            if (file_exists($dir_imagenes)) {
                $dir = dir($dir_imagenes);
                while (($archivo = $dir->read()) !== false) {
                    if ($archivo != 'principal.jpeg' && (strpos($archivo, 'jpeg') || strpos($archivo, 'jpg'))) {
                        $images[] = $dir_imagenes . $archivo;
                    }
                }
                $dir->close();
            }
        } else {
            echo 'Error al procesar la petición';
            exit;
        }
    } else {
        echo 'Error al procesar la petición';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sytem Solutions</title>
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
                <a href="checkout.php" class="btn btn-primary">
                    Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a>
            </div>
        </div>
    </nav>
</header>

<main class="container">
    <div class="row">
        <div class="col-md-6 order-md-1">
            <div id="carouselimagenes" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img id="caja" src="<?php echo $rutaImg; ?>" class="d-block w-100">
                    </div>

                    <?php foreach ($images as $img) { ?>
                        <div class="carousel-item">
                            <img id="caja" src="<?php echo $img; ?>" class="d-block w-100">
                        </div>
                    <?php } ?>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselimagenes"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselimagenes"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
        <div class="col-md-6 order-md-2">
            <h2><?php echo $nombre; ?></h2>

            <?php if ($descuento > 0) { ?>
                <p><del><?php echo MONEDA . number_format($precio, 0, '.', '.'); ?></del></p>
                <h2>
                    <?php echo MONEDA . number_format($precio_desc, 0, '.', '.'); ?>
                    <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                </h2>

            <?php } else { ?>
                <h2><?php echo MONEDA . number_format($precio, 0, '.', '.'); ?></h2>
            <?php } ?>

            <p class="lead">
                <?php echo $descripcion ?>
            </p>
            <div class="d-grid ms-2 gap-3 col-10 mx-auto">
                <button class="btn btn-primary" type="button">Comprar ahora</button>
                <button class="btn btn-outline-primary" type="button"
                        onclick="addProducto(<?php echo $id; ?>,'<?php echo $token_tmp; ?>')">Agregar al carrito
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

<script>
    function addProducto(id, token) {
        let url = 'clases/carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
    }
</script>

<!--
    Marko Robles
    Códigos de Programación
    2021
-->

</body>
</html>
