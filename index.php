<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST") {
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->PlantStats;	

	switch ($text) {
		case 'moisture':
			$speech = "The current moisture in the soil is too low, please water the plant!";
			break;
		case 'light':
			$speech = "The plant is getting enough light!";
			break;
		case 'co2':
			$speech = "The carbon-di-oxide levels are sufficient in the plant.";	
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
