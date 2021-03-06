<?php
namespace eve\sso;

/**
 * Eve-sso main class and API
 * 
 * @author Moiv
 *        
 */
class EveSSO
{
	private $keychain = "";
	private $generator = "";
	private $tokenstorer = "";
	private $sso_status;

	/**
	 * Constructor
	 *
	 * @param array $options [Optional] An array containing options<br>
	 * Valid Options:<br>
	 * 'keychain'<br>
	 * 'requestgenerator'
	 */
	public function __construct(array $options = null)
	{
		if ($options == null) $options = array();

		$this->data['hasValidAuthToken'] = false;

		//Use KeyChain if supplied otherwise create a default one
		if (array_key_exists('keychain', $options)) {
			if (is_a($options['keychain'], 'eve\sso\KeyChain')) $this->keychain = $options['keychain'];
		} else {
			$this->keychain = new KeyChain(new FSTokenStorer(FS_TOKEN_PATH), CLIENT_ID, SECRET_KEY);
		}

		//Use RequestGenerator if supplied otherwise create a default one
		if (array_key_exists('requestgenerator', $options)) {
			if (is_a($options['requestgenerator'], 'eve\sso\RequestGenerator')) $this->generator = $options['requestgenerator'];
		} else {
			$this->generator = new RequestGenerator(CLIENT_ID, SECRET_KEY);
			$this->generator->SetCallback(CALLBACK_URL);
			$this->generator->SetState(UNIQUE_STATE);
			if (defined('ESI_SCOPE')) $this->generator->SetESIScope(ESI_SCOPE);

		}
	}

	/**
	 * Initialise SSO
	 * @return string Will return 1 of 3 responses:<br>
	 * 'code' An Authorise Request URL will be required to get an auth token<br>
	 * 'refresh' A new auth token will be required using the currently store refresh token<br>
	 * 'authd' The current auth token is still valid and no action is required
	 */
	public function Init()
	{
		$status = $this->GetSSOStatus();
		
		// Automatically try to refresh once if required
		if ($status == 'refresh')
		{
			$this->RefreshAuthToken();
			$status = $this->GetSSOStatus();
		}
		
		return $status;
	}
	
	/**
	 * Get the current SSO Status
	 * @return string Will return 1 of 3 responses:<br>
	 * 'code' An Authorise Request URL will be required to get an auth token<br>
	 * 'refresh' A new auth token will be required using the currently store refresh token<br>
	 * 'authd' The current auth token is still valid and no action is required
	 */
	public function GetSSOStatus()
	{
		switch ($this->sso_status = $this->DecideOnAction()) {
			case 'code':
				//echo "We need an auth token using a request code<br>\n";
				break;
			case 'refresh':
				//echo "We need a new auth token using the refresh token<br>\n";
				break;
			case 'authd':
				//echo "We have a valid auth token, no action required<br>\n";
				break;
		}
		
		return $this->sso_status;
	}

	
	/**
	 * Get the current auth token
	 * @return string Auth token string
	 */
	public function GetAuthTokenString()
	{
		if ($token = $this->keychain->GetAuthToken())
		{
			return $token->GetValue();
		} else {
			return null;
		}

	}
	
	
	/**
	 * Get the auth token request URL
	 * @param string $uri [Optional] Callback URI
	 * @param string $state [Optional] A unique string of your choice
	 * @return string Auth token request URL
	 */
	public function GetRequestCode($uri = '', $state = '')
	{
		return $this->generator->GenerateAuthoriseRequest($uri, $state);
	}


	/**
	 * Output HTML Code to show the LOG IN with EVE Online button
	 * @param string $url URL for button to direct to
	 * @param int $size [optional] Size of button image:<br> 1 = Large Black (Default), 2 = Large White, 3 = Small Black, 4 = Small White
	 * @param bool $echo [optional] Set to false to suppress echoing the HTML code 
	 * @return string containing HTML code
	 */
	public function HTMLLoginButton($url, $size=1, $echo = true)
	{
		switch ($size) {
			case 2:
				$img = 'eve-sso-login-white-large.png';
				break;
			case 3:
				$img = 'eve-sso-login-black-small.png';
				break;
			case 4:
				$img = 'eve-sso-login-white-small.png';
				break;
			default:
				$img = 'eve-sso-login-black-large.png';
				break;
		}
		$string = " <A HREF = '$url'><img src = 'https://web.ccpgamescdn.com/eveonlineassets/developers/$img'></a>";
		
		if ($echo) echo $string;
		return $string;
	}
	
	/**
	 * Refresh the auth token
	 * @return bool True on refresh success
	 */
	public function RefreshAuthToken()
	{
		$this->keychain->ReloadKeys();
		$refreshtoken = $this->keychain->GetRefreshToken();
		
		if ($refreshtoken != null)
		{
			$requester = new TokenRequester($this->keychain);
			
			$success = $requester->RequestToken($this->generator->GenerateTokenRequest($refreshtoken));
		}
		
		return $success;
	}
	
	
	/**
	 * Decide which action is to be performed<br>code = Request code to begin auth<br>none = No action required<br>refresh = Refresh auth token
	 * @return string
	 */
	private function DecideOnAction()
	{
		$authToken = $this->keychain->GetAuthToken();
		$refreshToken = $this->keychain->GetRefreshToken();
		
		if ($authToken != null)
		{
			if ($authToken->IsExpired() == false) return 'authd';	// We have an auth token and it's valid
			if ($authToken->IsExpired() == true && $refreshToken != null) return 'refresh';		// We have an auth token but it's expired
		}
		
		if ($refreshToken != null) return 'refresh'; // We didnt have an auth token but we do have a refresh token
		
		return 'code';	// No other conditions met. We need to authorise using a code
	}

}
?>
