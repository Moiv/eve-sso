<?php
namespace eve\sso;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';

$eveSSO = new EveSSO();

$status = $eveSSO->Init();

//$status = $eveSSO->GetSSOStatus(); // No Longer Required, Init function will return this

echo $status;

if ($status == 'code') $eveSSO->HTMLLoginButton($eveSSO->GetRequestCode());

?>