<?php
$usernameFound = false;
$passwordError = false;
$username = strtolower($_POST['username']); //convert posted login form username to lowercase so it is case insensitive
$password = $_POST['password'];
$err = array();
$return = array();

//Checks if username and password fields are empty and if they are, returns an error message to display within the sweet alert in loginCheck.js
if($username == '')
{
	$err['username'] = 'Please enter a username';
}

if($password == '')
{
	$err['password'] = 'Please enter a password';
}

if(!empty($err))
{
	$return['success']	= false;
	$return['err']	= $err;
}else{
	$file = "xmemolibrary.xml";
	$fp = fopen($file, "rb") or die("Error - can't open the XML file");
	$str = fread($fp, filesize($file));

	$xml = new DOMDocument();
	$xml->formatOutput = true;
	$xml->preserveWhiteSpace = false;
	$xml->loadXML($str) or die("Error - can't load the XML data");

	$root	= $xml->documentElement;
	$xmemolibrary	= $root;
	

	$users = $xmemolibrary->childNodes->item(0);

	foreach ($users->childNodes as $user) 
	{	
		$xmlUsername 	= $user->childNodes->item(0)->nodeValue;
		$xmlPassword 	= $user->childNodes->item(1)->nodeValue;
		$xmlName 		= $user->childNodes->item(2)->nodeValue;

		if ($xmlUsername == $username) {
			$usernameFound = true;
			if($xmlPassword !== $password)
			{
				$passwordError = true;
			}
			else
			{
				session_start();
				$_SESSION["username"] = $username;
				$_SESSION["name"] = $xmlName;
			}
			break; //breaks out of the foreach loop
		}
	}

	if(!$usernameFound)
	{
		$err['username'] = 'That user does not exist.';
	}

	if($passwordError)
	{
		$err['password'] = 'Wrong password, please try again.';
	}

	if(!empty($err))
	{
		$return['success'] = false;
		$return['err'] = $err;
	}

	if(($usernameFound) && (!$passwordError))
	{
		$return['success']	= true;
		$return['message']	= 'You are logged in';

	}
}

echo json_encode($return);