<?php
// Definición de constantes
define("KEY_TOKEN", "SYSTEM.123");
define("MONEDA", "$");

// Iniciar sesión
session_start();

// Contar productos en el carrito
$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>
