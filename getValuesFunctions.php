<?php
session_start();
$file = "xmemolibrary.xml";
$fp = fopen($file, "rb") or die("Error - can't open the XML file");
$str = fread($fp, filesize($file));

$xml = new DOMDocument();
$xml->formatOutput = true;
$xml->preserveWhiteSpace = false;
$xml->loadXML($str) or die("Error - can't load the XML data");

$root	= $xml->documentElement;
$xmemolibrary	= $root;

$title = '0';
$sender = '1';
$memoRecipient = '2';
$publishedDate = '3';
$summary = '4';
$currentUser= $_SESSION['username'];
$url = '5';


function getXMemoUsers($xmemolibrary) //gets all users and current user
{
	$count = 0;
	$usersArray = array();
	$users = $xmemolibrary->childNodes->item(0);
	foreach ($users->childNodes as $user) 
	{
		$usersArray[$count]["users"] = $user->childNodes->item(2)->nodeValue;

		if($user->childNodes->item(0)->nodeValue == $_SESSION["username"])
		{
			$usersArray[$count]["currentUser"] = $user->childNodes->item(2)->nodeValue;
		}

		$count ++;
	}
	sort($usersArray);
	return $usersArray;
}

function getMemosByDate($xmemolibrary, $publishedDate)
{
	$count = 0;
	$memoDateArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		$memoDateArray[$count]["id"] = $memo->getAttribute('id');

		//checks if date already exists in dropdown - in_array idea found on https://stackoverflow.com/questions/38054669/check-if-value-exists-in-multidimensional-array-using-array-search-and-array-col
		if(in_array($memo->childNodes->item($publishedDate)->nodeValue, array_column($memoDateArray, 'publishedDate')) == false) {
			$memoDateArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
		}else{
			$memoDateArray[$count]["publishedDate"] = NULL;
		}

		$count++;			
	}
	sort($memoDateArray);
	return $memoDateArray;
}

function getMemoID($xmemolibrary)
{
	$count = 0;
	$memoIdArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		$memoIdArray[$count]["id"] = $memo->getAttribute('id');
		$count++;
	}
	sort($memoIdArray);
	return $memoIdArray;
}


function getAllMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$allMemosArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		$allMemosArray[$count]["id"] = $memo->getAttribute('id');
		$allMemosArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
		$allMemosArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

		$recipients = $memo->childNodes->item($memoRecipient);
		$recipientCount = 0;
		
		foreach($recipients->childNodes as $recipient)
		{					
			$allMemosArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
			$recipientCount++;
		}

		$allMemosArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
		$allMemosArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
		$allMemosArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;

		$count++;
	}
	return $allMemosArray;
}

function getMemosBySender($xmemolibrary, $sender)
{
	$count = 0;
	$memosSenderArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		if(in_array($memo->childNodes->item($sender)->nodeValue, array_column($memosSenderArray, 'sender')) == false) {
			$memosSenderArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;
		}else{
			$memosSenderArray[$count]["sender"] = NULL;
		}
		$count ++;
	}
	sort($memosSenderArray);
	return $memosSenderArray;
}

function getMemosByTitle($xmemolibrary, $title)
{
	$count = 0;
	$memosTitleArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	
	foreach ($memos->childNodes as $memo) 
	{
		$memosTitleArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;

		$count++;
	}
	sort($memosTitleArray);
	return $memosTitleArray;
}

$return['date'] = getMemosByDate($xmemolibrary, $publishedDate);
$return['sender'] = getMemosBySender($xmemolibrary, $sender);
$return['users'] = getXMemoUsers($xmemolibrary);
$return['memos'] = getAllMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url);
$return['session'] = $_SESSION;
$return['memoID'] = getMemoID($xmemolibrary);
$return['title'] = getMemosByTitle($xmemolibrary, $title);
echo json_encode($return);




