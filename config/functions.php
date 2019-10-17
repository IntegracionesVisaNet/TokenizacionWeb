<?php
    include 'config.inc.php';

    function generateToken() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => VISA_URL_SECURITY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode(VISA_USER.":".VISA_PWD)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generateSesion($amount, $token) {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD1' => VISA_MERCHANT_ID,
                    'MDD2' => "Integraciones VisaNet",
                    'MDD3' => 'paycard'
                ),
            ),
            'channel' => 'paycard',
        );
        $json = json_encode($session);
        $response = json_decode(postRequest(VISA_URL_SESSION, $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrence' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        $session = json_decode(postRequest(VISA_URL_AUTHORIZATION, $json, $token));
        return $session;
    }
	
	function generateTokenization($transactionToken, $token) {
		$merchant = VISA_MERCHANT_ID;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/card/$merchant/$transactionToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
				"Accept: */*",
                'Authorization: '.$token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function postRequest($url, $postData, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function generatePurchaseNumber(){
        $archivo = "assets/purchaseNumber.txt"; 
        $purchaseNumber = 222;
        $fp = fopen($archivo,"r"); 
        $purchaseNumber = fgets($fp, 100);
        fclose($fp); 
        ++$purchaseNumber; 
        $fp = fopen($archivo,"w+"); 
        fwrite($fp, $purchaseNumber, 100); 
        fclose($fp);
        return $purchaseNumber;
    }

    function generateAuthorizationWithToken($tokenId, $email, $amount, $token, $purchaseNumber) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'recurrent',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber
            ),
            'card' => array (
                'tokenId' => $tokenId
            ),
            'cardHolder' => array (
                'email' => $email
            )
        );
        $json = json_encode($data);
        // $session = json_decode(postRequest(VISA_URL_AUTHORIZATION, $json, $token));
        return postRequest(VISA_URL_AUTHORIZATION, $json, $token);
    }