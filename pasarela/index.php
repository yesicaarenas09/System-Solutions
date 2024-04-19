<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Script de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=Adv_IBq1Cp6pNKPformM5x6gPfk1Taa8kh1B0K2nFtwHuNw86fUxLGpVB3nk0T9tOJH7DJI-OK3d3ywX&currency=MXN"></script>
</head>
<body>
    <!-- Contenedor para el botón de PayPal -->
    <div id="paypal-button-container"></div>

    <!-- Script para renderizar el botón de PayPal -->
    <script>
        paypal.Buttons().render('#paypal-button-container');
    </script>
</body>
</html>
