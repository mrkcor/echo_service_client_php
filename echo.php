#!/usr/bin/env php
<?php
  if (count($argv) > 1) {
    $message = $argv[1];
  } else {
    $message = "I have nothing to say";
  }

  $wsdl = "http://localhost:9292/echo_service.wsdl";
  $client = new SoapClient($wsdl, array("trace" => 1));

  $response = $client->Echo(array("Message" => $message));
  echo "The Echo service returned: " . $response->Message . "\n\n";
  echo "The client posted the following XML message:\n";
  echo $client->__getLastRequest();
  echo "\n";
  echo "The client received the following XML message in response:\n";
  echo $client->__getLastResponse();
  echo "\n";
?>
