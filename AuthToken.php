<?php
namespace eve\sso;

/**
 * Authorisation Token
 * @author Moiv
 *        
 */
class AuthToken extends Token
{

	private $expiry = 0;

	/**
	 */
	public function __construct($token)
	{
		parent::__construct($token);
	}

	/**
	 * Check whether token is expired
	 *
	 * @return boolean True if expired
	 */
	public function IsExpired()
	{
		return ($this->expiry < time());
	}

	/**
	 * Get expiry time of token
	 *
	 * @return int Unix timestamp of expiry time
	 */
	public function GetExpiry()
	{
		return $this->expiry;
	}

	/**
	 * Set expiry time of token
	 *
	 * @param int $expiry
	 *        	Unix timestamp of expiry time
	 */
	public function SetExpiry($expiry)
	{
		$this->expiry = $expiry;
	}

}

