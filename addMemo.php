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
$return = array();

function addMemo($xmemolibrary, $newID, $xml)
{
	$memoTitle = $_POST['title'];
	$memoSender = $_POST['sender'];
	$memoRecipients = $_POST['recipients'];
	$memoDate = $_POST['date'];
	$memoURL = $_POST['url'];
	$memoSummary = $_POST['summary'];

	$memos = $xmemolibrary->childNodes->item(1);
	$previousMemo = $memos->childNodes->item(0);
	$recipientPosition;

	$title = $xml->createElement("title");
	$titleValue = $xml->createTextNode($memoTitle);
	$title->appendChild($titleValue);

	$sender = $xml->createElement("sender");
	$senderValue = $xml->createTextNode($memoSender);
	$sender->appendChild($senderValue);

	$recipientCount = 0;
	$recipients = $xml->createElement("recipients");
	foreach($memoRecipients as $recipient){
		$recipientPosition = $xml->createElement("recipient");
		$recipientValue = $xml->createTextNode($memoRecipients[$recipientCount]);
		$recipientPosition->appendChild($recipientValue);
		$recipients->appendChild($recipientPosition);

		$recipientCount++;
	}
	
	$date = $xml->createElement("date");
	$dateValue = $xml->createTextNode($memoDate);
	$date->appendChild($dateValue);

	$url = $xml->createElement("url");
	$urlValue = $xml->createTextNode($memoURL);
	$url->appendChild($urlValue);

	$summary = $xml->createElement("summary");
	$summaryValue = $xml->createTextNode($memoSummary);
	$summary->appendChild($summaryValue);

	//creates new element memo, set the new ID attribute and then adds all the child nodes.
	$newMemo = $xml->createElement("memo");
	$newMemo->setAttribute("id",$newID);
	$newMemo->appendChild($title);
	$newMemo->appendChild($sender);
	$newMemo->appendChild($recipients);
	$newMemo->appendChild($date);
	$newMemo->appendChild($summary);
	$newMemo->appendChild($url);

	$memos->insertBefore($newMemo,$previousMemo);

	$xml->save("xmemolibrary.xml");
}

//Function to increment the highest number in the xml by 1.
function incrementID($xmemolibrary)
{
    $maxNum = 0;
    $memos = $xmemolibrary->childNodes->item(1);

    foreach ($memos->childNodes as $memo) 
    { 
		$memo->getAttribute('id') > $maxNum ? $maxNum = $memo->getAttribute('id') : null;
    }
  return $maxNum+1;
}

$newID = incrementID($xmemolibrary);
addMemo($xmemolibrary, $newID, $xml);
$return['success'] = true;
echo json_encode($return);