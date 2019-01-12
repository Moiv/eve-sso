<?php
namespace eve\sso;

/**
 *
 * @author Mike
 *        
 */
class TokenRequester
{

	private $_keychain = null;
	
	/**
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
		$info = curl_getinfo($ch); 
		curl_close($ch);
		
		$contents = json_decode($server_output);
		
		var_dump($info);
		var_dump($contents);
		
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