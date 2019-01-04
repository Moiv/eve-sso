<?php
namespace eve\sso;

//iF EVE-SSO-PATH is not defined then set to current directory
if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');

include EVE_SSO_PATH.'Configuration.php';

$eveSSO = new EveSSO();

$eveSSO->Init();

$status = $eveSSO->GetInitResponse();

if (is_string($status)) $eveSSO->HTMLLoginButton($status);
if (is_a($status, KeyChain)) $KeyChain = $status;

?>