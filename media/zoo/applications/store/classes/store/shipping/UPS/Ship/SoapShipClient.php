<?php

  //Configuration
  $access = "CCE85AD5154DDC46";
  $userid = "ttopboatcovers";
  $passwd = "admin2";
  $wsdl = $this->app->path->path('classes:store/shipping/Ship.wsdl');
  $operation = "ProcessShipment";
  $endpointurl = '/';
  $outputFileName = "XOLTResult.xml";

  function processShipment()
  {

      //create soap request
    $requestoption['RequestOption'] = 'nonvalidate';
    $request['Request'] = $requestoption;

    $shipment['Description'] = 'Ship WS test';
    $shipper['Name'] = 'T-Top Boat Covers';
    $shipper['AttentionName'] = 'Kevin Blake';
    $shipper['TaxIdentificationNumber'] = '';
    $shipper['ShipperNumber'] = '01WV66';
    $address['AddressLine'] = '4651 Franchise Street';
    $address['City'] = 'North Charleston';
    $address['StateProvinceCode'] = 'SC';
    $address['PostalCode'] = '29418';
    $address['CountryCode'] = 'US';
    $shipper['Address'] = $address;
    $phone['Number'] = '8437606101';
    $shipper['Phone'] = $phone;
    $shipment['Shipper'] = $shipper;

    $shipto['Name'] = 'Shawn Gibbons';
    $shipto['AttentionName'] = 'Shawn Gibbons';
    $addressTo['AddressLine'] = '114 St Awdry Street';
    $addressTo['City'] = 'Summerville';
    $addressTo['StateProvinceCode'] = 'SC';
    $addressTo['PostalCode'] = '29485';
    $addressTo['CountryCode'] = 'US';
    $phone2['Number'] = '8434127354';
    $shipto['Address'] = $addressTo;
    $shipto['Phone'] = $phone2;
    $shipment['ShipTo'] = $shipto;

    $shipmentcharge['Type'] = '01';
    $billshipper['AccountNumber'] = $shipper['ShipperNumber'];
    $shipmentcharge['BillShipper'] = $billshipper;
    $paymentinformation['ShipmentCharge'] = $shipmentcharge;
    $shipment['PaymentInformation'] = $paymentinformation;

    $service['Code'] = '03';
    $service['Description'] = 'Ground';
    $shipment['Service'] = $service;

    $package['Description'] = 'T-Top Boat Cover - Pioneer - 197';
    $packaging['Code'] = '02';
    $packaging['Description'] = 'Customer Supplied';
    $package['Packaging'] = $packaging;
    $unit['Code'] = 'IN';
    $unit['Description'] = 'Inches';
    $dimensions['UnitOfMeasurement'] = $unit;
//    $dimensions['Length'] = '7';
//    $dimensions['Width'] = '5';
//    $dimensions['Height'] = '2';
//    $package['Dimensions'] = $dimensions;
    $unit2['Code'] = 'LBS';
    $unit2['Description'] = 'Pounds';
    $packageweight['UnitOfMeasurement'] = $unit2;
    $packageweight['Weight'] = '26';
    $package['PackageWeight'] = $packageweight;
    $shipment['Package'] = $package;

    $labelimageformat['Code'] = 'GIF';
    $labelimageformat['Description'] = 'GIF';
    $labelspecification['LabelImageFormat'] = $labelimageformat;
    $labelspecification['HTTPUserAgent'] = 'Mozilla/4.5';
    $shipment['LabelSpecification'] = $labelspecification;
    $request['Shipment'] = $shipment;

    echo "Request.......\n";
	var_dump($request);
    echo "\n\n";
    return $request;

  }

  function processShipConfirm()
  {

    //create soap request

  }

  function processShipAccept()
  {
    //create soap request
  }

  try
  {

    $mode = array
    (
         'soap_version' => 'SOAP_1_1',  // use soap 1.1 client
         'trace' => 1
    );

    // initialize soap client
  	$client = new SoapClient($wsdl , $mode);

  	//set endpoint url
  	$client->__setLocation($endpointurl);


    //create soap header
    $usernameToken['Username'] = $userid;
    $usernameToken['Password'] = $passwd;
    $serviceAccessLicense['AccessLicenseNumber'] = $access;
    $upss['UsernameToken'] = $usernameToken;
    $upss['ServiceAccessToken'] = $serviceAccessLicense;

    $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',$upss);
    $client->__setSoapHeaders($header);

    if(strcmp($operation,"ProcessShipment") == 0 )
    {
        //get response
  	$resp = $client->__soapCall('ProcessShipment',array(processShipment()));

         //get status
        echo "Response Status: " . $resp->Response->ResponseStatus->Description ."\n";

        //save soap request and response to file
        $fw = fopen($outputFileName , 'w');
        fwrite($fw , "Request: \n" . $client->__getLastRequest() . "\n");
        fwrite($fw , "Response: \n" . $client->__getLastResponse() . "\n");
        fclose($fw);

    }
    else if (strcmp($operation , "ProcessShipConfirm") == 0)
    {
            //get response
  	$resp = $client->__soapCall('ProcessShipConfirm',array(processShipConfirm()));

         //get status
        echo "Response Status: " . $resp->Response->ResponseStatus->Description ."\n";

        //save soap request and response to file
        $fw = fopen($outputFileName , 'w');
        fwrite($fw , "Request: \n" . $client->__getLastRequest() . "\n");
        fwrite($fw , "Response: \n" . $client->__getLastResponse() . "\n");
        fclose($fw);

    }
    else
    {
        $resp = $client->__soapCall('ProcessShipeAccept',array(processShipAccept()));

        //get status
        echo "Response Status: " . $resp->Response->ResponseStatus->Description ."\n";

  	//save soap request and response to file
  	$fw = fopen($outputFileName ,'w');
  	fwrite($fw , "Request: \n" . $client->__getLastRequest() . "\n");
        fwrite($fw , "Response: \n" . $client->__getLastResponse() . "\n");
        fclose($fw);
    }

  }
  catch(Exception $ex)
  {
  	var_dump ($ex);
  }

?>
