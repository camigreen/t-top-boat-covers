<?php

      //Configuration
      $access = "CCE85AD5154DDC46";
      $userid = "ttopboatcovers";
      $passwd = "admin2";

      $accessSchemaFile = $this->path->path('classes:store/shipping/UPS/Rate/xml/AccessRequest.xsd');
      $requestSchemaFile = $this->path->path('classes:store/shipping/UPS/Rate/xml/RateRequest.xsd');
      $responseSchemaFile = $this->path->path('classes:store/shipping/UPS/Rate/xml/RateResponse.xsd');

      $endpointurl = 'https://wwwcie.ups.com/webservices/Rate';
      $outputFileName = "XOLTResult.xml";


      try
      {
         //create AccessRequest data object
         $das = SDO_DAS_XML::create("$accessSchemaFile");
    	 $doc = $das->createDocument();
         $root = $doc->getRootDataObject();
         $root->AccessLicenseNumber=$access;
         $root->UserId=$userid;
         $root->Password=$passwd;
         $security = $das->saveString($doc);

         //create RateRequest data oject
         $das = SDO_DAS_XML::create("$requestSchemaFile");
         $requestDO = $das->createDataObject('','RequestType');
         $requestDO->RequestAction='Rate';
         $requestDO->RequestOption='Rate';

         $pickuptypeDO = $das->createDataObject('','CodeType');
         $pickuptypeDO->Code = '07';
         $shipmentDO = $das->createDataObject('','ShipmentType');
         $shipperDO = $das->createDataObject('','ShipperType');
         $shipperDO->Name = 'Name';
         $shipperDO->ShipperNumber = '';
         $addressDO = $das->createDataObject('','AddressType');
         $addressDO->AddressLine1 = 'AddressLine1';
         $addressDO->City = 'City';
         $addressDO->StateProvinceCode = 'NJ';
         $addressDO->PostalCode = '07430';
         $addressDO->CountryCode = 'US';
         $shipperDO->Address = $addressDO;

         $shipToDO = $das->createDataObject('','ShipToType');
         $shipToDo->CompanyName = 'CompanyName';
         $addressToDO = $das->createDataObject('','AddressType');
         $addressToDO->AddressLine1 = 'Address Line';
         $addressToDO->City = 'Corado';
         $addressToDO->PostalCode = '00646';
         $addressToDO->CountryCode = 'PR';
         $shipToDO->Address = $addressToDO;

         $shipFromDO = $das->createDataObject('','ShipFromType');
         $shipFromDO->CompanyName = 'CompanyName';
         $addressFromDO = $das->createDataObject('','AddressType');
         $addressFromDO->AddressLine1 = 'Address Line';
         $addressFromDO->City = 'Boca Raton';
         $addressFromDO->StateProvinceCode = 'FL';
         $addressFromDO->PostalCode = '33434';
         $addressFromDO->CountryCode = 'US';
         $shipFromDO->Address = $addressFromDO;

         $serviceDO = $das->createDataObject('','CodeDescriptionType');
         $serviceDO->Code = '03';
         $packageDO = $das->createDataObject('','PackageType');
         $packagingDO = $das->createDataObject('','CodeDescriptionType');
         $packagingDO->Code = '02';
         $packagingDO->Description = 'Customer Supplied';
         $packageDO->PackagingType = $packagingDO;
         $packageweight = $das->createDataObject('','WeightType');
         $unit = $das->createDataObject('','UnitOfMeasurementType');
         $unit->Code = 'LBS';
         $packageweight->Weight = '10';
         $packageweight->UnitOfMeasurement = $unit;
         $packageDO->PackageWeight = $packageweight;

         $shipmentServiceOptionsDO = $das->createDataObject('','ShipmentServiceOptionsType');
         $onCallAirDO = $das->createDataObject('','OnCallAirType');
         $scheduleDO = $das->createDataObject('','ScheduleType');
         $scheduleDO->PickupDay = '02';
         $scheduleDO->Method = '02';
         $onCallAirDO->Schedule = $scheduleDO;
         $shipmentServiceOptionsDO->OnCallAir = $onCallAirDO;
         $shipmentDO->ShipmentServiceOptions = $shipmentServiceOptionsDO;


         $shipmentDO->Package = $packageDO;
         $shipmentDO->Service = $serviceDO;
         $shipmentDO->ShipFrom = $shipFromDO;
         $shipmentDO->ShipTo = $shipToDO;
         $shipmentDO->Shipper = $shipperDO;
         $doc = $das->createDocument();
         $root = $doc->getRootDataObject();
         $root->Request = $requestDO;
         $root->PickupType = $pickuptypeDO;
         $root->Shipment = $shipmentDO;
         $request = $das->saveString($doc);

         //create Post request
         $form = array
         (
             'http' => array
             (
                 'method' => 'POST',
                 'header' => 'Content-type: application/x-www-form-urlencoded',
                 'content' => "$security$request"
             )
         );

         //print form request
         print_r($form);


         $request = stream_context_create($form);
         $browser = fopen($endpointurl , 'rb' , false , $request);
         if(!$browser)
         {
             throw new Exception("Connection failed.");
         }

         //get response
         $response = stream_get_contents($browser);
         fclose($browser);

         if($response == false)
         {
            throw new Exception("Bad data.");
         }
         else
         {
            //save request and response to file
  	    $fw = fopen($outputFileName,'w');
            fwrite($fw , "Response: \n" . $response . "\n");
            fclose($fw);

            //get response status
            $resp = new SimpleXMLElement($response);
            echo $resp->Response->ResponseStatusDescription . "\n";
         }
      }
      catch(SDOException $sdo)
      {
      	 echo $sdo;
      }
      catch(Exception $ex)
      {
      	 echo $ex;
      }

?>

