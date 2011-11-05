#!/usr/bin/env php
<?php
  // If the user passed in an argument on the command line use that as the
  // input message for the EchoService, otherwise default to "Hello from PHP"
  if (count($argv) > 1) {
    $message = $argv[1];
  } else {
    $message = "Hello from PHP";
  }

  class EchoClient {
    public function __construct() {
      // Initialize SoapClient with WSDL, set trace option to true to enable 
      // access to debug information
      $this->client = new SoapClient("http://localhost:9292/echo_service.wsdl", array("trace" => 1));
      // You can change the endpoint URL that is set in the WSDL to something else below
      // $this->client->__setLocation('http://your-url-here');
    }

    // Call Echo on the EchoService (method purposely named 'echooo' because 
    // 'echo' is a reserved word
    public function echooo($message) {
      return $this->echoRequest($message);
    }

    // Call ReverseEcho on the EchoService
    public function reverseEcho($message) {
      return $this->echoRequest($message, true);
    }

    // Send Echo (or ReverseEcho if the $reverse parameter is true) to the
    // EchoService and return the resulting message
    private function echoRequest($message, $reverse = false) {
      if ($reverse) {
        $request_name = "ReverseEcho";
      } else {
        $request_name = "Echo";
      }

      try {
        if ($reverse) {
          $response = $this->client->ReverseEcho(array("Message" => $message));
        } else {
          $response = $this->client->Echo(array("Message" => $message));
        }

        // Output the message from the response
        echo "EchoService responded to " . $request_name . ": " . $response->Message . "\n\n";
        // Output details of the request and response
        echo "The client posted the following XML message:\n";
        echo $this->client->__getLastRequest();
        echo "\n";
        echo "The client received the following XML message in response:\n";
        echo $this->client->__getLastResponse();
        echo "\n";
        // Return the message from the response
        return $response->Message;
      } catch (SoapFault $sf) {
        // In case of a SOAP fault output error details and return null
        echo "An error occurred while calling " . $request_name . " on the EchoService: " . $sf->getMessage() . "\n";
      }
    }
  }

  // Instantiate the EchoService client and call operations
  $echo = new EchoClient();
  $echo->echooo($message);
  $echo->reverseEcho($message);
?>
