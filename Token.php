<?php
namespace eve\sso;

/**
 *
 * @author Mike
 *        
 */
class Token
{

    private $value = "";
    
    /**
     */
    public function __construct($token)
    {
        $this->value = $token;
    }
    
    public function GetValue()
    {
        return $this->value;
    }
    
    public function SetValue($value)
    {
        
        $this->value = $value;
    }
}

