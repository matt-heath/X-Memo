<?php
$file = "xmemolibrary.xml";
$fp = fopen($file, "rb") or die("Error - can't open the XML file");
$str = fread($fp, filesize($file));

$xml = new DOMDocument();
$xml->formatOutput = true;
$xml->preserveWhiteSpace = false;
$xml->loadXML($str) or die("Error - can't load the XML data");

$root	= $xml->documentElement;
$xmemolibrary	= $root;

$err = array();
$return = array();


$username = $_POST['username']; 
if(!empty($username)){
	strtolower($username);
}
$password = $_POST['password'];
$name = $_POST['name'];
//Checks if username, password and name fields are empty and if they are, returns an error message to display within the sweet alert
$name == '' ? $err['name'] = 'Please enter your name.' : null; 
$username == '' ? $err['username'] = 'Please enter a username.' : null;
$password == '' ? $err['password'] = 'Please enter a password.' : null;


$users = $xmemolibrary->childNodes->item(0);

foreach ($users->childNodes as $user) 
{	
	$xmlUsername = $user->childNodes->item(0)->nodeValue;
	$xmlPassword = $user->childNodes->item(1)->nodeValue;
	$xmlName = $user->childNodes->item(2)->nodeValue;

	$xmlUsername == $username ? $err['usernameFound'] = 'Username already exists.' : $usernameFound = false;
}

if(!empty($err))
{
	$return['success'] = false;
	$return['err'] = $err;
	echo json_encode($return);
}else{
		$previousUser = $users->childNodes->item(0);

		$usernameNode = $xml->createElement("username");
		$usernameValue = $xml->createTextNode($username);
		$usernameNode->appendChild($usernameValue);

		$passwordNode = $xml->createElement("password");
		$passwordValue = $xml->createTextNode($password);
		$passwordNode->appendChild($passwordValue);

		$nameNode = $xml->createElement("name");
		$nameValue = $xml->createTextNode($name);
		$nameNode->appendChild($nameValue);


		//creates new element memo, set the new ID attribute and then adds all the child nodes.
		$newUser = $xml->createElement("user");
		$newUser->appendChild($usernameNode);
		$newUser->appendChild($passwordNode);
		$newUser->appendChild($nameNode);

		$users->insertBefore($newUser,$previousUser);

		$xml->save("xmemolibrary.xml");

		$return['success'] = true;
		echo json_encode($return);
	
}


	

