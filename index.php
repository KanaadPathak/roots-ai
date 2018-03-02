<?php
$moistureValues = array(0.001,0.0129,0.142,0.5321,2.123,5.141);
$lightValues = array(10,13,16,45,24,76,32);
$co2Values = array(3.12,4.2,6.7,2.5);

function checkValue ($givenValue,$threshold,$thing){
	if ($givenValue < $threshold)
	{
		$speech =  "The current value of $thing is too low.";
			if ($thing == 'water') {
				$speech  = "Please add more water.";
			}

			elseif ($thing == 'light') {
				$speech = "Try moving the plant to a suitable location with enough light.";
			}
	}

	elseif ($thing > $threshold) {
		$speech = "The $thing level is too high!";
	}

	else
		$speech = "The $thing value is just correct.";
	
return $speech;
}


$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST") {
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->PlantStats;	

	switch ($text) {
		case 'moisture':
			$speech = checkValue($moistureValues[2],0.56,"moisture");
			break;
		case 'light':
			
			$speech =checkValue($lightValues[3],16,"light");
			break;
		case 'co2':
			
			$speech = checkValue($co2Values[4],0.56,"carbon-di-oxide");	
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
