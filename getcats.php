<?php
	$sex = $_POST['SEX'];
	$breed = $_POST['BREED'];
	$sbreed = $_POST['SBREED'];
	$age = $_POST['AGE'];
	$location = $_POST['LOCATION'];
	$size = $_POST['SIZE'];
	$color = $_POST['COLOR'];
	$fee = $_POST['FEE'];
	$url = 'https://www.petango.com/webservices/wsadoption.asmx/AdoptableSearch';
	//speciesID 	all:0	dog:1		cat:2
	$data = array('authkey' => '[YOUR AUTHKEY HERE]', 'site' => '[YOUR SITE HERE]', 
		'speciesID' => '2', 'sex' => $sex, 'ageGroup' => $age, 'location' => $location, 'onHold' => '', 'orderBy' => 'Name', 
		'primaryBreed' => $breed, 'secondaryBreed' => '', 'specialNeeds' => '', 'noDogs' => '', 'noCats' => '', 'noKids' => '', 
		'stageID' => '');
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, true, $context);
//	header('Content-type: application/xml');
//	print_r($result);
	$pets = simplexml_load_string($result);
	$arrayRet = array();
	foreach($pets->XmlNode as $petinfo){
		$id=$petinfo->adoptableSearch->ID;
		$pic=$petinfo->adoptableSearch->Photo;
		$name=$petinfo->adoptableSearch->Name;
		$breed=$petinfo->adoptableSearch->PrimaryBreed;
		$sbreed=$petinfo->adoptableSearch->SecondaryBreed;
		$sex=$petinfo->adoptableSearch->Sex;
		$age=$petinfo->adoptableSearch->Age;
		$location=$petinfo->adoptableSearch->Location;
		array_push($arrayRet, json_encode(array((string)$id, (string)$pic, (string)$name, (string)$breed, (string)$sex, (string)$age, (string)$location)));
	}
	print_r(json_encode($arrayRet));
?>
