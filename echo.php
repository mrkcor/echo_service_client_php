#!/usr/bin/env php
<?php
  if (count($argv) > 1) {
    $message = $argv[1];
  } else {
    $message = "Hello from PHP";
  }

  $wsdl = "http://localhost:9292/echo_service.wsdl";
  $client = new SoapClient($wsdl, array("trace" => 1));

  $response = $client->Echo(array("Message" => $message));
  echo "EchoService responded to Echo: " . $response->Message . "\n\n";
  echo "The client posted the following XML message:\n";
  echo $client->__getLastRequest();
  echo "\n";
  echo "The client received the following XML message in response:\n";
  echo $client->__getLastResponse();
  echo "\n";

  $response = $client->ReverseEcho(array("Message" => $message));
  echo "EchoService responded to ReverseEcho: " . $response->Message . "\n\n";
  echo "The client posted the following XML message:\n";
  echo $client->__getLastRequest();
  echo "\n";
  echo "The client received the following XML message in response:\n";
  echo $client->__getLastResponse();
  echo "\n";
?>
