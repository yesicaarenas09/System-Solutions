<?php
// Iniciar o reanudar la sesión
session_start();

require '../config/config.php';
require '../config/database.php';

$db = new Database();
$con = $db->conectar();

// Verificar la existencia de KEY_TOKEN
if (!defined('KEY_TOKEN')) {
    die("Error: KEY_TOKEN no está definido en config.php");
}

// Verificar si existe una sesión y la variable $_SESSION['carrito']
if (!isset($_SESSION['carrito']) || !isset($_SESSION['carrito']['productos'])) {
    $_SESSION['carrito'] = array('productos' => array());
}

// Función para verificar el token
function verificaToken($id, $token)
{
    // Lógica para verificar el token, asumiendo que tienes la implementación
    return true;
}

// Verificar el tipo de solicitud y los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['token'])) {
        $id = htmlspecialchars(trim($_POST['id']));
        $token = htmlspecialchars(trim($_POST['token']));

        // Verificar el token
        if (verificaToken($id, $token)) {
            // Lógica para agregar producto al carrito
            $id_producto = $id;
            // Lógica para agregar el producto al carrito
            $_SESSION['carrito']['productos'][$id_producto] = ($_SESSION['carrito']['productos'][$id_producto] ?? 0) + 1;

            // Enviar respuesta JSON con el nuevo número de productos en el carrito
            $response = array(
                'ok' => true,
                'numero' => count($_SESSION['carrito']['productos'])
            );
            echo json_encode($response);
            die(); // Terminar la ejecución después de enviar la respuesta JSON
        } else {
            $response = array('ok' => false, 'mensaje' => 'Token inválido');
            echo json_encode($response);
            die();
        }
    } else {
        $response = array('ok' => false, 'mensaje' => 'Datos insuficientes');
        echo json_encode($response);
        die();
    }
} else {
    $response = array('ok' => false, 'mensaje' => 'Método no permitido');
    echo json_encode($response);
    die();
}
