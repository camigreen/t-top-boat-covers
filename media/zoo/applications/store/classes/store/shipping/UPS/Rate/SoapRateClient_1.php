<?php

  //Configuration
  $access = "CCE85AD5154DDC46";
  $userid = "ttopboatcovers";
  $passwd = "admin2";
  $wsdl = $this->path->path('classes:store/shipping/UPS/Rate/WSDL/RateWS.wsdl');
  $operation = "ProcessRate";
  $endpointurl = 'https://wwwcie.ups.com/webservices/Rate';
  $outputFileName = "XOLTResult.xml";

  function processRate()
  {
      //create soap request
      $option['RequestOption'] = 'Shop';
      $request['Request'] = $option;

      $pickuptype['Code'] = '01';
      $pickuptype['Description'] = 'Daily Pickup';
      $request['PickupType'] = $pickuptype;

      $customerclassification['Code'] = '01';
      $customerclassification['Description'] = 'Classfication';
      $request['CustomerClassification'] = $customerclassification;

      $shipper['Name'] = 'Imani Carr';
      $shipper['ShipperNumber'] = '01WV66';
      $address['AddressLine'] = array
      (
          'Southam Rd',
          '4 Case Cour',
          'Apt 3B'
      );
      $address['City'] = 'Timonium';
      $address['StateProvinceCode'] = 'MD';
      $address['PostalCode'] = '21093';
      $address['CountryCode'] = 'US';
      $shipper['Address'] = $address;
      $shipment['Shipper'] = $shipper;

      $shipto['Name'] = 'Imani Imaginarium';
      $addressTo['AddressLine'] = '21 ARGONAUT SUITE B';
      $addressTo['City'] = 'ALISO VIEJO';
      $addressTo['StateProvinceCode'] = 'CA';
      $addressTo['PostalCode'] = '92656';
      $addressTo['CountryCode'] = 'US';
      $addressTo['ResidentialAddressIndicator'] = '';
      $shipto['Address'] = $addressTo;
      $shipment['ShipTo'] = $shipto;

      $shipfrom['Name'] = 'Imani Imaginarium';
      $addressFrom['AddressLine'] = array
      (
          'Southam Rd',
          '4 Case Court',
          'Apt 3B'
      );
      $addressFrom['City'] = 'Timonium';
      $addressFrom['StateProvinceCode'] = 'MD';
      $addressFrom['PostalCode'] = '21093';
      $addressFrom['CountryCode'] = 'US';
      $shipfrom['Address'] = $addressFrom;
      $shipment['ShipFrom'] = $shipfrom;

      $service['Code'] = '03';
      $service['Description'] = 'Service Code';
      $shipment['Service'] = $service;

      $packaging1['Code'] = '02';
      $packaging1['Description'] = 'Rate';
      $package1['PackagingType'] = $packaging1;
      $punit1['Code'] = 'LBS';
      $punit1['Description'] = 'Pounds';
      $packageweight1['Weight'] = '1';
      $packageweight1['UnitOfMeasurement'] = $punit1;
      $package1['PackageWeight'] = $packageweight1;

      $packaging2['Code'] = '02';
      $packaging2['Description'] = 'Rate';
      $package2['PackagingType'] = $packaging2;
      $punit2['Code'] = 'LBS';
      $punit2['Description'] = 'Pounds';
      $packageweight2['Weight'] = '2';
      $packageweight2['UnitOfMeasurement'] = $punit2;
      $package2['PackageWeight'] = $packageweight2;

      $shipment['Package'] = array(	$package1 , $package2 );
      $shipment['ShipmentServiceOptions'] = '';
      $shipment['LargePackageIndicator'] = '';
      $request['Shipment'] = $shipment;
      echo "Request.......\n";
      var_dump($request);
      echo "\n\n";
      return $request;
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

        var_dump($client->__getFunctions());
    //create soap header
    $usernameToken['Username'] = $userid;
    $usernameToken['Password'] = $passwd;
    $serviceAccessLicense['AccessLicenseNumber'] = $access;
    $upss['UsernameToken'] = $usernameToken;
    $upss['ServiceAccessToken'] = $serviceAccessLicense;

    $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',$upss);
    $client->__setSoapHeaders($header);
    

    //get response
  	$resp = $client->__soapCall($operation ,array(processRate()));

    //get status
    echo "Response Status: " . $resp->Response->ResponseStatus->Description ."\n";

    //save soap request and response to file
    $fw = fopen($outputFileName , 'w');
    fwrite($fw , "Request: \n" . $client->__getLastRequest() . "\n");
    fwrite($fw , "Response: \n" . $client->__getLastResponse() . "\n");
    fclose($fw);

  }
  catch(Exception $ex)
  {
  	print_r ($ex);
  }

?>