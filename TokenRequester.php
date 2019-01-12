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
	
	/** Constructor
	 * @param KeyChain $keychain Requires a valid KeyChain object to function
	 */
	public function __construct(KeyChain $keychain)
	{
		$this->_keychain = $keychain;
	}
	
	
	/**
	 * Request auth token from SSO server & store in the keychain
	 * @param resource $ch cURL session with token request
	 */
	public function RequestToken($ch)
	{
		
		$server_output = curl_exec($ch);
		//$info = curl_getinfo($ch);	// For testing purposes only
		curl_close($ch);
		
		$contents = json_decode($server_output);
		
		//var_dump($info);		// For testing purposes only
		//var_dump($contents);	// For testing purposes only
		
		//@todo Handle errors more elegantly
		if (!is_object($contents)) die ('Invalid response from eve SSO server');
		if ($contents->error != null) die ('Error from eve SSO server: ' . $contents->error_description);
		if ($contents->access_token == null) die ('Error: No access token received from eve SSO server');
		
		$authToken = new AuthToken($contents->access_token);
		$refreshToken = new RefreshToken($contents->refresh_token);
		
		$authToken->SetExpiry(-1 + time() + $contents->expires_in);
		
		$this->_keychain->SaveToken($authToken);
		$this->_keychain->SaveToken($refreshToken);
	}
}

?>