<?php

/*
echo pageHeader("Service Account Access");

putenv('GOOGLE_APPLICATION_CREDENTIALS=maintenanceapp-47fd37d3fda6.json');

$clientService = new Google_Client();

if ($credentials_file = checkServiceAccountCredentialsFile()) {
  // set the location manually
  $clientService->setAuthConfig($credentials_file);
} elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
  // use the application default credentials
  $clientService->useApplicationDefaultCredentials();
} else {
  echo missingServiceAccountDetailsWarning();
  return;
}

$clientService->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile','https://www.googleapis.com/auth/gmail.readonly'));
*/

public static function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

public static function getJwtAssertion($private_key_file)
{

    $json_file = file_get_contents($private_key_file);
    $info = json_decode($json_file);
    $private_key = $info->{'private_key'};

    //{Base64url encoded JSON header}
    $jwtHeader = self::base64url_encode(json_encode(array(
        "alg" => "RS256",
        "typ" => "JWT"
    )));

    //{Base64url encoded JSON claim set}
    $now = time();
    $jwtClaim = self::base64url_encode(json_encode(array(
        "iss" => $info->{'client_email'},
        "scope" => "https://www.googleapis.com/auth/analytics.readonly",
        "aud" => "https://www.googleapis.com/oauth2/v4/token",
        "exp" => $now + 3600,
        "iat" => $now
    )));

    $data = $jwtHeader.".".$jwtClaim;

    // Signature
    $Sig = '';
    openssl_sign($data,$Sig,$private_key,'SHA256');
    $jwtSign = self::base64url_encode($Sig);

    //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
    $jwtAssertion = $data.".".$jwtSign;
    return $jwtAssertion;
}

public static function getGoogleAccessToken($private_key_file)
{

    $result = [
        'success' => false,
        'message' => '',
        'token' => null
    ];

    if (Cache::has('google_token')) {
        $result['token'] = Cache::get('google_token');
        $result['success'] = true;
        return $result;
    }

    if(!file_exists($private_key_file)){
        $result['message'] = 'Google json key file missing!';
        return $result;

    }

    $jwtAssertion = self::getJwtAssertion($private_key_file);

    try {

        $client = new Client([
            'base_uri' => 'https://www.googleapis.com',
        ]);
        $payload = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwtAssertion
        ];

        $response = $client->request('POST', 'oauth2/v4/token', [
            'form_params' => $payload
        ]);

        $data = json_decode($response->getBody());
        $result['token'] = $data->access_token;
        $result['success'] = true;

        $expiresAt = now()->addMinutes(58);
        Cache::put('google_token', $result['token'], $expiresAt);

    } catch (RequestException $e) {
          $result['message'] = $e->getMessage();
    }


    return $result;

}

?>
