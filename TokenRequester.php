<?php
namespace eve\sso;

/**
 * This class requests the tokens from the eve-sso servers
 * 
 * @author Moiv
 *        
 */
class TokenRequester
{

	private $_keychain = null;
	private $_RequestTokenFailMessage = "";
	
	/** Constructor
	 * @param KeyChain $keychain Requires a valid KeyChain object to function
	 */
	public function __construct(KeyChain $keychain)
	{
		$this->_keychain = $keychain;
	}
	
	/**
	 * Get the failure message from a failed RequestToken call
	 * @return string Failure Message
	 */
	public function GetRequestTokenFailMessage() {
		return $this->_RequestTokenFailMessage;
	}
	
	/**
	 * Request auth token from SSO server & store in the keychain
	 * @param resource $ch cURL session with token request
	 * @return bool Returns true on success
	 */
	public function RequestToken($ch)
	{
		$this->_RequestTokenFailMessage = ''; // Clear fail message
		
		$server_output = curl_exec($ch);
		//$info = curl_getinfo($ch);	// For testing purposes only
		curl_close($ch);
		
		$contents = json_decode($server_output);
		
		//var_dump($info);		// For testing purposes only
		//var_dump($contents);	// For testing purposes only
		
		//@todo Handle errors more elegantly
		if (!is_object($contents)) {
			$this->_RequestTokenFailMessage = 'Invalid response from eve SSO server';
			return false;
		}
		if (property_exists($contents,"error") && $contents->error != null) {
			$this->_RequestTokenFailMessage = 'Error from eve SSO server: ' . $contents->error_description;
			return false;
		}
		if ($contents->access_token == null) {
			$this->_RequestTokenFailMessage = 'Error: No access token received from eve SSO server';
			return false; 
		}
		
		$authToken = new AuthToken($contents->access_token);
		$refreshToken = new RefreshToken($contents->refresh_token);
		
		$authToken->SetExpiry(-1 + time() + $contents->expires_in);
		
		$this->_keychain->SaveToken($authToken);
		$this->_keychain->SaveToken($refreshToken);
		
		return true;
	}
}

?>