<?php
$moistureValues = array(0.001,0.0129,0.142,0.5321,2.123,5.141);
$lightValues = array(10,13,16,45,24,76,32);
$co2Values = array(3.12,4.2,6.7,2.5,2.4,4.6);

function checkValue ($givenValue,$threshold,$thing){
	if ($givenValue < $threshold)
	{
		$speech2 =  "The current value of $thing is "."$givenValue\n";
			if ($thing == 'moisture') {
				$speech  = "Please add more water."."$speech2";
			}

			elseif ($thing == 'light') {
				$speech = "Try moving the plant to a suitable location with enough light."."$speech2";
			}

			elseif ($thing == 'temperature'){
				$speech = "Try moving the plant to a cooler location."."$speech2";
			}
	}

	elseif ($thing > $threshold) {
		$speech = "The $thing sensor value is "."$givenValue, which is too high"."\n Please refer to the growers guide\n";
	}

	else
		$speech = "The conditions for $thing are correct, the current value for your reference is "."$givenValue";
	
return $speech;
}


$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST") {
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->PlantStats;	

	switch ($text) {
		case 'moisture':
			
			$speech = checkValue($moistureValues[0],0.56,"moisture");
			break;
		case 'light':
			$random_keys=array_rand($lightValues,3);
			$speech =checkValue($lightValues[$random_keys[0]],16,"light");
			break;
		case 'co2':
			$random_keys=array_rand($co2Values,3);
			$speech = checkValue($co2Values[$random_keys[0]],0.56,"carbon-di-oxide");	
			break;
		case 'temperature':
			$speech = checkValue(24,19,"temperature");
			break;
		case 'value':
			$speech = "Please specify what value you'd like to know, I can tell CO2, Moisture, Light and Soil Temperature values ";
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
	echo "App is currently running, GET request not accepted.";
}


?>
