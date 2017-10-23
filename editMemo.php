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

function editMemo($xmemolibrary, $xml)
{
	$memos = $xmemolibrary->childNodes->item(1);

	foreach ($memos->childNodes as $memo) 
	{
		if($memo->getAttribute('id') == $_POST['id'])
		{
			$memo->getElementsByTagName("summary")->item(0)->nodeValue = $_POST['summary'];
			$memo->getElementsByTagName("url")->item(0)->nodeValue = $_POST['url'];
			$memo->getElementsByTagName("title")->item(0)->nodeValue = $_POST['title'];

			$xml->save("xmemolibrary.xml");
			return true;
		}
	}
}

if(editMemo($xmemolibrary, $xml)){
	$return['success'] = editMemo($xmemolibrary, $xml);
	echo json_encode($return);
}else{
	$return['success'] = false;
	echo json_encode($return);
}
