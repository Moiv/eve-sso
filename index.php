<?php
namespace eve\sso;

use eve\esi\ESIresponse;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';

$eveSSO = new EveSSO();

$status = $eveSSO->Init();

if ($status == 'code') $eveSSO->HTMLLoginButton($eveSSO->GetRequestCode()); // You can change this to anything or remove completely
if ($status == 'refresh') echo 'You have an expired Auth Token that needs refreshing'; // You can change this to anything or remove completely
if ($status == 'authd') echo 'Congratulations, you have been authenticated & have a valid Auth Token'; // You can change this to anything or remove completely


// ESI Examples Below
$esi = new \eve\esi\ESIrequesterP();

$response = $esi->Search('inventory_type', 'Compressed');				// Search for items containing the word 'Compressed'
$itemIds = $response->GetResponse()->inventory_type;

$response = $esi->Search('corporation', 'Caldari Provisions', true);	// Search for a corporation called 'Caldari Provisions'
$corpID = $response->GetResponse()->corporation[0];

$response = $esi->RequestCorpInfo($corpID);								// Request corp info on the corpID from the above query

// Display results
echo "<pre>\n";
print_r($itemIds);
print_r("\nCorp ID: ".$corpID."\n\n");
print_r($response->GetResponse());
echo "</pre>";

?>