-User
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-02-2024 a las 00:25:17
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `cc` varchar(20) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `cc`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
(1, 'nelson', 'jaramillo', 'nelsonjaramillo@gmail.com', '3156895860', '1053658956', 1, '2023-11-24 19:47:54', NULL, NULL),
(2, 'juan', 'perez', 'juanperez@hotmail.com', '3125689656', '45689532', 1, '2023-11-24 22:38:19', NULL, NULL),
(3, 'luis', 'lopez', 'luislopez@hotmail.com', '315628925', '15161063', 1, '2023-11-25 08:11:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `marca` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `categoria`, `activo`, `marca`) VALUES
(1, 'Monitor ACER Gamer 27\" Pulgadas curvo', 'El monitor Acer Nitro ED270R de 27\" con panel curvado de 1500R ofrece una experiencia de juego envolvente y espectacular con su pantalla panorámica Full HD (1920 x 1080). Diseñado específicamente para el gaming, este monitor cuenta con tecnología AMD FreeSync Premium para una reproducción suave de imágenes y una experiencia sin desgarros.\r\n\r\nCon un brillo de 250 nits, el Nitro ED270R presenta colores vibrantes y detalles nítidos en su pantalla curvada. Su tiempo de respuesta rápido de 1 ms (VRB) y una frecuencia de actualización impresionante de 165Hz garantizan una acción sin problemas y una jugabilidad fluida.', 1050000, 10, 1, 1, 'Samsung'),
(2, 'Portatiles', 'Portatiles', 1599000, 0, 1, 1, ''),
(7, 'mouse', 'gamer', 100000, 0, 1, 1, 'genius'),
(8, 'Disco duro solido Kingston', 'Disco duro en estado solido Kingston de 500gb', 95000, 0, 1, 1, 'Kingston'),
(9, 'AIO HP 205G4', '-PROCESADOR: Amd Ryzen 3 3250u a 2,6 Ghz\r\n- GRAFICOS: AMD Radeon Graphics\r\n-PANTALLA: Pantalla LCD FHD IPS panorámica de 60,45 cm (23,8\"), antirreflectante con retroiluminación WLED y 250 nits (1920 x 1080)\r\n-MEMORIA RAM: 8GB DDR4-2666 (2 SODIMM)\r\n-ALMACENAMIENTO: 1TB (1000GB) 7200 rpm Conexión Sata + Puerto M2 Disponible para SSD\r\n-CÁMARA WEB: Cámara de privacidad HP True Vision HD 720p con micrófono digital de matriz doble integrado\r\n-ALTAVOCES: Integrados Altavoces dobles de 2 W\r\n-TECLADO Y MOUSE: Teclado en español (Ñ) cableados USB color Negro\r\n-SISTEMA OPERATIVO: Windows 10 PRO\r\n-Conectividad: WiFi 5 802.11b/g/n/a/ac (1×1) - Bluetooth 4.2\r\n- Color: Negro\r\n- UNIDAD DVD: No\r\n-DIMENSIONES (An x P x Al): 54,08 × 40,94 × 20,45 cm\r\n-Peso: 5,85 kg\r\n-PUERTOS: Parte trasera: 1 toma combinada de auriculares/micrófono; 1 conector de alimentación; 1 RJ-45; 2 SuperSpeed USB con velocidad de señal de 5 Gbps; 1 salida HDMI1.4; 2 USB Type-A con velocidad de señal de 480Mbps Inferior: 1 lector de tarjetas SD 3 en 1', 2800000, 0, 1, 1, 'HP'),
(10, 'Parlante KALLEY K-SPK200TLED Negro', 'Características destacadas\r\nDisfruta de tu música favorita: Bluetooth, entrada USB y entrada Auxiliar (RCA)\r\nIncluye trí´pode y control remoto, para mayor comodidad.\r\nRadio FM, escucha tus emisoras preferidas.\r\nEntrada micrófono y luces LED, para una noche de Karaoke.\r\nManijas, para mejor desplazamiento.', 520000, 0, 1, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_cliente`) VALUES
(1, 'nelson', '$2y$10$/o.z6QXKhObtnHTViIths.NOStAtdol0.4bSLbJX8jnN7M29DFoke', 0, '528a35856dba36c7b89f9f6338a9d911', NULL, 0, 1),
(2, 'juan', '$2y$10$uQua1xxIfo5gEHhqom0TLupyj63GsDAIS7OI2bKJDGOzBdgsnx6Fq', 0, 'f7600f518def90c366692c0ab18b0fdd', NULL, 0, 2),
(3, 'luis', '$2y$10$o76jWWUctEZj54AEo1W6H.1qyrnF3ccQ//L8Vwe5zhCLGXbZuzwuO', 0, '3870be0b3c987398303acd2dc7e0b3de', NULL, 0, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
esta base de datos tiene nueve errores