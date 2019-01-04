<?php
namespace eve\sso;

/**
 *
 * @author Mike
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
     * @return boolean True is expired
     */
    public function IsExpired()
    {
        return false;
    }
    
    /**
     * Get expiry time of token
     * @return int Unix timestamp of expiry time
     */
    public function GetExpiry()
    {
        return $this->expiry;
    }
    
    /**
     * Set expiry time of token
     * @param int $expiry Unix timestamp of expiry time
     */
    public function SetExpiry($expiry)
    {
        $this->expiry = $expiry;
    }
    
}

