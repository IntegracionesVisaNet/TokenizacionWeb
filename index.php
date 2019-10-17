<?php
    include 'config/functions.php';
    $amount = 1;
    $detallePago = 1;

    $token = generateToken();
    $sesion = generateSesion($amount, $token);
    $purchaseNumber = generatePurchaseNumber();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Integraciones VisaNet</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    <br>

    <div class="container">
        <h1 class="text-center">Tokenización Web</h1>
        <hr>
        <h3>Información del pago</h3>
        <b style="padding-left:20px;">Importe a pagar: </b> S/. <?php echo $amount; ?> <br>
        <b style="padding-left:20px;">Número de pedido: </b> <?php echo $purchaseNumber; ?> <br>
        <b style="padding-left:20px;">Concepto: </b> <?php echo $detallePago; ?> <br>
        <b style="padding-left:20px;">Fecha: </b> <?php echo date("d/m/Y"); ?> <br>
        <hr>
        <!-- <h3>Realiza el pago</h3> -->
        <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> <label for="ckbTerms">Acepto los <a href="https://portal.miraflores.gob.pe/as/tyc.html" target="_blank">Términos y condiciones</a></label>
        <form id="frmVisaNet" action="http://localhost:8082/tokenizacion_web/finalizar.php?amount=<?php echo $amount;?>&purchaseNumber=<?php echo $purchaseNumber?>">
            <script src="<?php echo VISA_URL_JS?>" 
                data-sessiontoken="<?php echo $sesion;?>"
                data-channel="paycard"
                data-merchantid="<?php echo VISA_MERCHANT_ID?>"
                data-merchantname="INTEGRACIONES VISANET"
                data-purchasenumber="<?php echo $purchaseNumber;?>"
                data-amount="<?php echo $amount; ?>"
                data-cardholdername="INTEGRACIONES"
                data-cardholderlastname="VISANET"
                data-expirationminutes="5"
                data-timeouturl="http://localhost:8082/tokenizacion_web"
            ></script>
        </form>
    </div>
    
</body>
<script src="assets/js/script.js"></script>
</html>