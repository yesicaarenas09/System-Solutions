<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare('SELECT id, nombre, precio FROM productos WHERE activo=1');
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// session_destroy();

print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Solutions</title>
    <link rel="stylesheet" href="./css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img class="imagen" src="./imagenes/logoStechno.jpeg" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
                    <!-- Añadir los enlaces de registro e inicio de sesión aquí -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registro de Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--Contenido-->
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php foreach($resultado as $row ): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                            $id = $row['id'];
                            $imagen = "imagenes/productos/$id/principal.jpeg";
                            if(!file_exists($imagen)){
                                $imagen = "imagenes/no-photo.jpeg";
                            }
                        ?>
                        <img src="<?php echo $imagen; ?>" class="card-img-top" alt="Imagen de producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                            <p class="card-text">$<?php echo number_format($row['precio'], 0, '.', '.'); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                </div>
                                <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>,'<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('token', token);

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart");
                    elemento.innerHTML = data.numero;
                }
            });
        }
    </script>
</body>

</html>
echo "";