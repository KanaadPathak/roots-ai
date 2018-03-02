<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST") {
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;	

	switch ($text) {
		case 'hi':
			$speech = "Hello there.";
			break;
		case 'bye':
			$speech = "Thank you for visiting";
			break;

		default:
			$speech = "Sorry I dont underatand that, Please try again";# code...
			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}


else
{
	echo "Method not allowed";
}


?>