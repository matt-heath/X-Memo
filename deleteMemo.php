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

function deleteMemo($xmemolibrary, $xml)
{

	$memos = $xmemolibrary->childNodes->item(1);

	foreach ($memos->childNodes as $memo) 
	{
    $memo->getAttribute('id') == $_POST['id'] ? $memos->removeChild($memo) : null;
	}
  $xml->save("xmemolibrary.xml");
  return true;
}

if(deleteMemo($xmemolibrary, $xml)){
  $return['success'] = deleteMemo($xmemolibrary, $xml);
  echo json_encode($return);
}else{
  $return['success'] = false;
  echo json_encode($return);
}

