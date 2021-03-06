<?php
namespace eve\sso;

/**
 * Generates Request URL's for Eve's SSO Service
 * @author Moiv
 *
 */
class RequestGenerator
{

	private $SSO_auth_base_path = "https://login.eveonline.com/v2/oauth/authorize/"; // SSO Base Path - Auth
	private $SSO_token_base_path = "https://login.eveonline.com/v2/oauth/token/"; // SSO Base Path - Tokens
	private $Client_ID = "";
	private $Secret_Key = "";
	private $Callback_URL = "";
	private $ESI_Scope = "";
	private $State = "";

	/**
	 * Constructor
	 *
	 * @param string $client_id Eve Online SSO Client ID
	 * @param string $secret_key Eve Online SSO Secret Key
	 */
	public function __construct($client_id, $secret_key)
	{
		$this->Client_ID = $client_id;
		$this->Secret_Key = $secret_key;
	}

	/**
	 * Generate an authorisation URL to login to Eve SSO
	 *
	 * @param string $uri Callback URI
	 * @param string $state A unique string of your choice
	 * @return string A string containing the request URL
	 */
	public function GenerateAuthoriseRequest($uri = '', $state = '')
	{
		if ($uri == '') $uri = $this->Callback_URL;
		if ($state == '') $state = $this->State;

		$request = $this->SSO_auth_base_path . '?';

		$query_data = array(
			'response_type' => "code",
			'redirect_uri' => $uri,
			'client_id' => $this->Client_ID,
			'scope' => $this->ESI_Scope,
			'state' => $state
		);
		$request .= http_build_query($query_data, null, '&', PHP_QUERY_RFC3986);

		return $request;
	}

	/**
	 * Generates a cURL Session to request an Auth Token
	 * @param mixed $auth_code
	 * <p>Provide a string containg a code for an initial auth token request<br>
	 * or a RefreshToken object to request a refreshed auth token</p>
	 * @return resource cURL Session
	 */
	public function GenerateTokenRequest($auth_code)
	{

		$ch = curl_init();

		$headers = array(
			// 'Content-Type: application/x-www-form-urlencoded',
			"Authorization: Basic " . base64_encode($this->Client_ID . ':' . $this->Secret_Key),
			"Host: login.eveonline.com"
		);

		curl_setopt($ch, CURLOPT_URL, $this->SSO_token_base_path);
		curl_setopt($ch, CURLOPT_POST, 1);

		if (is_string($auth_code))
		{
			//echo "Generating an auth code request";
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $auth_code); // Request Auth Token using Code
		} elseif (is_a($auth_code, 'eve\sso\RefreshToken'))
		{
			//echo "Generating an auth token from refresh token request";
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=" . $auth_code->GetValue()); // Request Auth Token using Refresh Token
		} else {
			// Invalid data passed in to function
			return false;
		}

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		return $ch;
	}

	/**
	 * Set the base path for SSO Auth Requests
	 *
	 * @param string $path Base path for SSO Auth Requests
	 */
	public function SetAuthBasePath($path)
	{
		$this->SSO_auth_base_path = $path;
	}

	/**
	 * Set the base path for SSO Token Requests
	 *
	 * @param string $path Base path for SSO Token Requests
	 */
	public function SetTokenBasePath($path)
	{
		$this->SSO_token_base_path = $path;
	}

	/**
	 * Set State Parameter
	 *
	 * @param string $scope A unique string of your choice
	 */
	public function SetCallback($callback)
	{
		$this->Callback_URL = $callback;
	}

	/**
	 * Set ESI scopes to request permissions for
	 *
	 * @param string $scope A space delimited list of ESI scopes you would like to request permissions for
	 */
	public function SetESIScope($scope)
	{
		// $this->ESI_Scope = urlencode($scope);
		$this->ESI_Scope = $scope;
	}

	/**
	 * Set State Parameter
	 *
	 * @param string $scope A unique string of your choice
	 */
	public function SetState($state)
	{
		$this->State = $state;
	}

}

