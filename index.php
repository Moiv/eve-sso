<?php
namespace eve\sso;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';

$eveSSO = new EveSSO();

$status = $eveSSO->Init();

if ($status == 'code') $eveSSO->HTMLLoginButton($eveSSO->GetRequestCode()); // You can change this to anyhing or remove completely

?>