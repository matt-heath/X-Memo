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

//Assigns the element index of particular elements to a variable to be used within functions.
$title = '0';
$sender = '1';
$memoRecipient = '2';
$publishedDate = '3';
$summary = '4';
$url = '5';


//The following functions return values based on the selected dropdown type and value.
function getMemosByID($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$memosIdArray = array();

	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		if($memo->getAttribute('id') == $_POST['name'])
		{
			$memosIdArray[$count]["id"] = $memo->getAttribute('id');
			$memosIdArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
			$memosIdArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

			$recipients = $memo->childNodes->item($memoRecipient);

			$recipientCount = 0;
			
			foreach($recipients->childNodes as $recipient)
			{					
				$memosIdArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
				$recipientCount++;
			}

			$memosIdArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
			$memosIdArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
			$memosIdArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;

			$count++;
		}
	}	
	sort($memosIdArray);
	return $memosIdArray;
}

function getMemosByTitle($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$memosTitleArray = array();

	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		if($memo->childNodes->item($title)->nodeValue == $_POST['name'])
		{
			$memosTitleArray[$count]["id"] = $memo->getAttribute('id');
			$memosTitleArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
			$memosTitleArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

			$recipients = $memo->childNodes->item($memoRecipient);

			$recipientCount = 0;
			
			foreach($recipients->childNodes as $recipient)
			{					
				$memosTitleArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
				$recipientCount++;
			}

			$memosTitleArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
			$memosTitleArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
			$memosTitleArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;

			$count++;
		}
	}
	sort($memosTitleArray);
	return $memosTitleArray;
}

function getMemosByDate($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$memosDateArray = array();

	$memos = $xmemolibrary->childNodes->item(1);

	foreach($memos->childNodes as $memo)
	{
		if($memo->childNodes->item(3)->nodeValue == $_POST['name'])
		{
			$memosDateArray[$count]["id"] = $memo->getAttribute('id');
			$memosDateArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
			$memosDateArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

			$recipients = $memo->childNodes->item($memoRecipient);

			$recipientCount = 0;
			
			foreach($recipients->childNodes as $recipient)
			{					
				$memosDateArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
				$recipientCount++;
			}

			$memosDateArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
			$memosDateArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
			$memosDateArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;

			$count++;				
		}
	}
	return $memosDateArray;
}

function retrieveSenderMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$memosSenderArray = array();
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		if($memo->childNodes->item($sender)->nodeValue == $_POST['name'])
		{
			$memosSenderArray[$count]["id"] = $memo->getAttribute('id');
			$memosSenderArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
			$memosSenderArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

			$recipients = $memo->childNodes->item($memoRecipient);
			$recipientCount = 0;

			foreach($recipients->childNodes as $recipient)
			{					
				$memosSenderArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
				$recipientCount++;
			}

			$memosSenderArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
			$memosSenderArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
			$memosSenderArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;
			
			$count++;
		}
	}

	return $memosSenderArray;
}

function retrieveRecipientMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url)
{
	$count = 0;
	$memosRecipientArray = array();
	
	$memos = $xmemolibrary->childNodes->item(1);
	foreach ($memos->childNodes as $memo) 
	{
		$recipientsMatches = $memo->childNodes->item($memoRecipient);
		foreach ($recipientsMatches->childNodes as $recipientsMatch) 
		{
			if($recipientsMatch->childNodes->item(0)->nodeValue == $_POST['name'])
			{
				$memosRecipientArray[$count]["id"] = $memo->getAttribute('id');
				$memosRecipientArray[$count]["title"] = $memo->childNodes->item($title)->nodeValue;
				$memosRecipientArray[$count]["sender"] = $memo->childNodes->item($sender)->nodeValue;

				$recipients = $memo->childNodes->item($memoRecipient);
				$recipientCount = 0;

				foreach($recipients->childNodes as $recipient)
				{					
					$memosRecipientArray[$count]["recipients"][$recipientCount] = $recipient->childNodes->item(0)->nodeValue;
					$recipientCount++;
				}

				$memosRecipientArray[$count]["publishedDate"] = $memo->childNodes->item($publishedDate)->nodeValue;
				$memosRecipientArray[$count]["summary"] = $memo->childNodes->item($summary)->nodeValue;
				$memosRecipientArray[$count]["url"] = $memo->childNodes->item($url)->nodeValue;

				$count++;
			}
		}
	}
	return $memosRecipientArray;
}

//goes to specific function based on type passed in from retrieveUserMemos.js
$_POST['type'] == 'memoID' ? $return['success'] = true && $return['memos'] = getMemosByID($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url) : null; 

$_POST['type'] == 'title' ? $return['success'] = true && $return['memos'] = getMemosByTitle($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url) : null; 

$_POST['type'] == 'date' ? $return['success'] = true && $return['memos'] = getMemosByDate($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url) : null; 

$_POST['type'] == 'sender' ? $return['success'] = true && $return['memos'] = retrieveSenderMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url) : null; 

$_POST['type'] == 'recipient' ? $return['success'] = true && $return['memos'] = retrieveRecipientMemos($xmemolibrary, $title, $sender, $memoRecipient, $publishedDate, $summary, $url) : null; 

echo json_encode($return);