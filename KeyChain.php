<?php
namespace eve\sso;

/**
 * Key Chain to hold Client ID & Secret Key plus Auth & Refresh tokens - Currently Not Used
 * 
 * @author Moiv
 * @todo Hold Auth & Refresh Tokens in KeyChain. Use keychain in remainder of application
 */
class KeyChain
{

	// Keys
	private $ClientID = "";
	private $Secret_Key = "";

	// Tokens
	private $auth_token = null;
	private $refresh_token = null;
	
	// Token Storer
	private $storer = null;

	/**
	 * Constructor
	 * 
	 * @param iTokenStorer $storer Object implementing the iTokenStorer interface
	 */
	public function __construct(iTokenStorer $storer)
	{
		$this->storer = $storer;
		$this->loadKeys();
	}

	/**
	 * Get the Client ID
	 * @return string String containing Client ID
	 */
	public function GetClientID()
	{
		return $this->ClientID;
	}

	/**
	 * Get the Secret Key
	 * @return string String containing Secret Key
	 */
	public function GetSecretKey()
	{
		return $this->Secret_Key;
	}

	/**
	 * Get the auth token
	 * @return AuthToken Auth Token
	 */
	public function GetAuthToken()
	{
		//return $this->storer->LoadAuthToken();
		return $this->auth_token;
	}

	/**
	 * Get the refresh token
	 * @return RefreshToken Refresh Token
	 */
	public function GetRefreshToken()
	{
		//return $this->storer->LoadRefreshToken();
		return $this->refresh_token;
	}
	
	public function HasAuthToken()
	{
		if ($this->auth_token == null) return false;
		return true;
	}
	
	public function HasRefreshToken()
	{
		if ($this->refresh_token == null) return false;
		return true;
	}

	/**
 	* Save an auth or refresh token 
 	* 
 	* @param mixed $token Auth or Refresh Token
 	*/
	public function SaveToken($token)
	{
		if (!is_object($token)) return false;
		
		switch (get_class($token)) {
			case 'eve\sso\AuthToken':
				$this->storer->StoreAuthToken($token);
				break;
			case 'eve\sso\RefreshToken':
				$this->storer->StoreRefreshToken($token);
				break;
			default:
				echo "ERROR: Unknown token was passed to KeyChain->SaveToken";
		}
		
		$this->ReloadKeys();
	}
	
	
	/**
	 * Re Load keys from the storage system
	 */
	public function ReloadKeys()
	{
		$this->auth_token = $this->storer->LoadAuthToken();
		$this->refresh_token = $this->storer->LoadRefreshToken();
	}
	
	/**
	 * Internal function to load the keys from storage location
	 */
	private function loadKeys()
	{
		// Load Client ID
		$this->ClientID = CLIENT_ID;

		// Load Secret Key
		$this->Secret_Key = SECRET_KEY;
		
		$this->reloadKeys();
	}
}

