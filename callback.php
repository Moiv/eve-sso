<?php
namespace eve\sso;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';
$generator = new RequestGenerator(CLIENT_ID, SECRET_KEY);
$generator->SetCallback(CALLBACK_URL);
$generator->SetESIScope(ESI_SCOPE);
$generator->SetState(UNIQUE_STATE);

//Using default keychain with FSTokenStorer
$keychain = new KeyChain(new FSTokenStorer(FS_TOKEN_PATH));

if (!array_key_exists('code', $_GET)) die ('Do not call callback file manually');

$code = $_GET['code'];
$state = $_GET['state'];

if ($state != UNIQUE_STATE) die ('State received from sso server does not match that supplied by us');

$ch = $generator->GenerateTokenRequest($code);

$server_output = curl_exec($ch);
curl_close($ch);

$contents = json_decode($server_output);
var_dump($contents);

if (!is_object($contents)) die ('Invalid response from eve SSO server');
if ($contents->error != null) die ('Error from eve SSO server: ' . $contents->error_description);
if ($contents->access_token == null) die ('Error: No acces token received from eve SSO server');

$authToken = new AuthToken($contents->access_token);
$refreshToken = new RefreshToken($contents->refresh_token);

$authToken->SetExpiry(time() + $contents->expires_in);

$keychain->SaveToken($authToken);
$keychain->SaveToken($refreshToken);

var_dump($authToken);
var_dump($refreshToken)

?>