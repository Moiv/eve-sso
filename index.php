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

// $keychain = new KeyChain();
// $generator = new RequestGenerator(CLIENT_ID, SECRET_KEY);
// $generator->SetCallback(CALLBACK_URL);
// $generator->SetESIScope(ESI_SCOPE);
// $generator->SetState(UNIQUE_STATE);

// switch (DecideOnAction())
// {
//     case 'code':
//         ShowLoginButton($generator->GenerateAuthoriseRequest());
//         break;
//     case 'refresh':
//         break;
// }



// Functions

/**
 * Output HTML Code to show the LOG IN with EVE Online button
 * @param string $url URL for button to direct to
 */
// function ShowLoginButton($url)
// {
//     echo " <A HREF = '$url'><img src = 'https://web.ccpgamescdn.com/eveonlineassets/developers/eve-sso-login-black-large.png'></a>";
//     //https://web.ccpgamescdn.com/eveonlineassets/developers/eve-sso-login-black-large.png
//     //https://web.ccpgamescdn.com/eveonlineassets/developers/eve-sso-login-white-large.png
// }

/**
 * Decide which action is to be performed<br>code = Request code to begin auth<br>none = No action required<br>refresh = Refresh auth token
 * @return string
 */
// function DecideOnAction()
// {
//     return 'code';
// }

?>