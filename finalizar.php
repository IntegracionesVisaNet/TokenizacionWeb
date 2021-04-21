<?php
    include 'config/functions.php';
    $transactionToken = $_POST["transactionToken"];
    $email = $_POST["customerEmail"];
    $purchaseNumber = $_GET["purchaseNumber"];    

    $token = generateToken();
    $data = generateTokenization($transactionToken, $token);
    $json = json_decode($data);
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

    <div class="container-fluid">
        <hr>
        <p><b>Token generado: </b> <?php echo $json->token->tokenId;?></p>
        <p><a href="<?php echo BASE_URL;?>autorizar.php">Probar una autorización</a></p>

        <hr>

        <textarea class="form-control" cols="30" rows="20"><?php echo json_encode(json_decode($data), JSON_PRETTY_PRINT);?></textarea>

    </div>

</body>
</html>