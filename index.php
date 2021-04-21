<?php
    include 'config/functions.php';

    $token = generateToken();
    $sesion = generateSesion($token);
    $purchaseNumber = generatePurchaseNumber();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Integraciones Niubiz</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    <br>

    <div class="container">
        <h1 class="text-center">Tokenización Web</h1>
        <hr>
        <h3>Agregar tarjeta</h3>
        <b style="padding-left:20px;">Número de pedido: </b> <?php echo $purchaseNumber; ?> <br>
        <b style="padding-left:20px;">Fecha: </b> <?php echo date("d/m/Y"); ?> <br>
        <hr>

        <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> <label for="ckbTerms">Acepto los <a href="#" target="_blank">Términos y condiciones</a></label>
        <br>
        <button class="btn btn-primary" id="frmVisaNet" onclick="openNiubiz()">Agregar tarjeta</button>

        <script src="assets/js/script.js"></script>
        <script  src="<?php echo VISA_URL_JS?>"></script>
        <script>
            function openNiubiz() {
                VisanetCheckout.configure({
                    action: '<?php echo BASE_URL;?>finalizar.php?purchaseNumber=<?php echo $purchaseNumber?>',
                    sessiontoken:'<?php echo $sesion;?>',
                    channel: 'paycard',
                    merchantid: '<?php echo VISA_MERCHANT_ID?>',
                    purchasenumber: '<?php echo $purchaseNumber?>',
                    amount: '1.00',
                    cardholdername: 'INTEGRACIONES',
                    cardholderlastname: 'NIUBIZ',
                    cardholderemail: 'integraciones.niubiz@necomplus.com',
                    expirationminutes: '5',
                    timeouturl: 'http://tokenizacion.evirtuales.com/',
                    merchantlogo:'<?php echo BASE_URL;?>assets/img/logo.png',
                    formbuttoncolor: '#D80000',
                    formbuttontext: 'Agregar tarjeta',
                    showamount: 'FALSE'
                });
                VisanetCheckout.open();
            }
        </script>

    </div>
    
</body>
</html>