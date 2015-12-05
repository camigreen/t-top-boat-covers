<?php

//Configuration
$access = "CCE85AD5154DDC46";
$userid = "ttopboatcovers";
$passwd = "admin2";
$wsdl = $this->path->path('classes:store/shipping/UPS/Rate/WSDL/RateWS.wsdl');
$operation = "ProcessRate";
$endpointurl = 'https://wwwcie.ups.com/webservices/Rate';
$outputFileName = $this->path->path('classes:store/shipping/UPS/Rate/').'XOLTResult.xml';

function processRate($request) {
    //create soap request
    echo "Request.......\n";
    
    echo "\n\n";
    return $request;
}

try {
    echo '<pre>';
    print_r($request);
    echo "</pre>";
    $mode = array
        (
        'soap_version' => 'SOAP_1_1', // use soap 1.1 client
        'trace' => 1
    );

    // initialize soap client
    $client = new SoapClient($wsdl, $mode);

    //set endpoint url
    $client->__setLocation($endpointurl);

    //create soap header
    $usernameToken['Username'] = $userid;
    $usernameToken['Password'] = $passwd;
    $serviceAccessLicense['AccessLicenseNumber'] = $access;
    $upss['UsernameToken'] = $usernameToken;
    $upss['ServiceAccessToken'] = $serviceAccessLicense;

    $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
    $client->__setSoapHeaders($header);

    //get response
    $resp = $client->__soapCall($operation, array($request));
    echo '<pre>';
    print_r($resp);
    echo '</pre>';
    //get status
    echo "Response Status: " . $resp->Response->ResponseStatus->Description . "\n";

    //save soap request and response to file
    $fw = fopen($outputFileName, 'w');
    fwrite($fw, "Request: \n" . $client->__getLastRequest() . "\n");
    fwrite($fw, "Response: \n" . $client->__getLastResponse() . "\n");
    fclose($fw);
} catch (Exception $ex) {
    echo '<pre>';
    print_r($ex->detail);
    echo '</pre>';
}
?>
