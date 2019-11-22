<?php
namespace eve\sso;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';
$generator = new RequestGenerator(CLIENT_ID, SECRET_KEY);
//$generator->SetCallback(CALLBACK_URL);
//$generator->SetESIScope(ESI_SCOPE);
//$generator->SetState(UNIQUE_STATE);

//Using default keychain with FSTokenStorer
$keychain = new KeyChain(new FSTokenStorer(FS_TOKEN_PATH), CLIENT_ID, SECRET_KEY);

if (!array_key_exists('code', $_GET)) die ('Do not call callback file manually');

$code = $_GET['code'];
$state = $_GET['state'];

if ($state != UNIQUE_STATE) die ('State received from sso server does not match that supplied by us');

$requester = new TokenRequester($keychain);

$result = $requester->RequestToken($generator->GenerateTokenRequest($code)); //This returns true on success

if ($result) {
	echo ('Authorisation was successful. Reload web page');
} else {
	echo ('Authorisation does not appear successful');
}
//Add output code here

?>
