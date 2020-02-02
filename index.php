<?php
namespace eve\sso;

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

$itemIds = $esi->Search('inventory_type', 'Compressed');        // Search for items containing the word 'Compressed'

$corpID = $esi->Search('corporation', 'Your Corp Name', true);  // Set this to your corp name. 

$memberIds = $esi->RequestCorpData($corpID, $eveSSO->GetAuthTokenString(), 'Members');  // This will only work if EveSSO Authentication has been successful
?>