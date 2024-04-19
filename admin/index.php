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
                <a href="checkout.php" class="btn btn-primary ms-5">
                    Carrito<span id="num_cart" class="badge bg-secondary"><?php echo count($_SESSION['carrito']['productos'] ?? []); ?></span>
                </a>
                <!-- Enlace al Registro -->
                <a href="registro.php" class="nav-link">Registro</a>
                <!-- Enlace al Inicio de Sesión -->
                <a href="login.php" class="nav-link">Iniciar Sesión</a>
            </div>
        </div>
    </nav>
</header>
