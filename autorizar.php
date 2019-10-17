<?php
    if (isset($_POST["token"]) && isset($_POST["email"]) && isset($_POST["amount"])) {
        include 'config/functions.php';
        $tokenId = $_POST["token"];
        $email = $_POST["email"];
        $amount = $_POST["amount"];

        $token = generateToken();
        $purchaseNumber = generatePurchaseNumber();
        $authorizationWithToken = generateAuthorizationWithToken($tokenId, $email, $amount, $token, $purchaseNumber);
        // echo json_encode($authorizationWithToken);
        echo "<h1 class='container'>Respuesta</h1>"."<br>";
        echo "<textarea class='container form-control' cols='30' rows='20'>".json_encode(json_decode($authorizationWithToken), JSON_PRETTY_PRINT)."</textarea>";
    }
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
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" name="token" id="token" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="amount">Importe</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                <br>
                    <button class="btn btn-primary">Generar</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>