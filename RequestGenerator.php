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
	 * @param string $client_id You Application's Client ID
	 * @param string $scope A URL encoded, space delimited list of ESI scopes you would like to request permissions for
	 * @param string $state A unique string of your choic
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
	 * Generates a cURL Session to request Token
	 *
	 * @param string $auth_code
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $auth_code);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',
		// "Authorization: Basic ".base64_encode($user.':'.$pass),
		// "Host: login.eveonline.com"."\r\n"
		// ));

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

