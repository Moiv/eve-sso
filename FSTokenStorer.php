<?php
namespace eve\sso;

/**
 * Filesystem Token Storer
 * 
 * @author Moiv
 * 
 */
class FSTokenStorer implements iTokenStorer
{
	private $_storagePath = '';
	private $_authTokenName = 'auth.tkn';
	private $_refreshTokenName = 'refresh.tkn';

	/**
	 * Constructor
	 * 
	 * @param string $path Path to directory where keys can be stored<br>
	 * Make sure this is a secure location, particularly on a shared server
	 * Refresh Tokens never expire so they must remain secure
	 */
	public function __construct($path = "")
	{
		if ($path == "") throw new \Exception('Storage Path was empty');
		$this->_storagePath = $path;
		$path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		$this->CreatePath($this->_storagePath);
	}

	/**
	 * Store Authorisation Token
	 * @param AuthToken $token Authorisation Token
	 */
	public function StoreAuthToken(AuthToken $token)
	{
		$s = serialize($token);
		if (!$fp = fopen($this->_storagePath.$this->_authTokenName, "w")) return false;
		fwrite($fp, $s);
		fclose($fp);
	}

	/**
	 * Store Refresh Token
	 * @param RefreshToken $token Refresh Token
	 */
	public function StoreRefreshToken(RefreshToken $token)
	{
		$s = serialize($token);
		if (!$fp = fopen($this->_storagePath.$this->_refreshTokenName, "w")) return false;
		fwrite($fp, $s);
		fclose($fp);
	}

	/**
	 * Retrieves Authorisation Token
	 * @return AuthToken Authorisation Token 
	 */
	public function LoadAuthToken()
	{
		$filename = $this->_storagePath.$this->_authTokenName;
		
		if (!is_readable($filename)) return null;
		
		$s = implode("", @file($filename));
		$a = unserialize($s);
		
		if ($a == false) return null;
		
		return $a;
	}

	/**
	 * Retrieves Refresh Token
	 * @return RefreshToken Refresh Token
	 */
	public function LoadRefreshToken()
	{
		$filename = $this->_storagePath.$this->_refreshTokenName;
		
		if (!is_readable($filename)) return null;
		
		$s = implode("", @file($filename));
		$a = unserialize($s);
		
		if ($a == false) return null;
		
		return $a;
	}

	/**
	 * Check that storage path is writable
	 */
	private function CheckPathWritable()
	{
		
	}

	/**
	 * Checks if path exists and attempts to create it
	 * @return bool Boolean if path exists
	 */
	private function CreatePath()
	{
		if (!file_exists($this->_storagePath)) mkdir($this->_storagePath);

		return file_exists($this->_storagePath);
	}

}

?>
