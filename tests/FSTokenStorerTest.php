<?php
/**
* PHPUnit 4.2.6 Unit Tests
*/

//declare(strict_types=1);

//require_once 'PHPUnit/Autoload.php';

//require_once ('PHPUnit/Framework/TestCase.php');

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');
require_once EVE_SSO_PATH.'iTokenStorer.php';
require_once EVE_SSO_PATH.'FSTokenStorer.php';


use eve\sso\FSTokenStorer as FSTokenStorer;

use PHPUnit_Framework_TestCase as TestCase;

final class FSTokenStorerTest extends TestCase
{
	
	
    public function testCanBeCreatedFromValidDirectory()
    {
    	$TokenStorer = new FSTokenStorer('/tmp');
    	
        $this->assertInstanceOf(
            FSTokenStorer::class,
        	$TokenStorer
        );
    }
    
    /**
     * @expectedException Exception
     */
    public function testExpectExceptionFromBlankDirectory()
    {
    	new FSTokenStorer('');
    }
    
    /**
     * @expectedException Exception
     */
    public function testExpectExceptionFromUncreatableDirectory()
    {
    	new FSTokenStorer('/home/Not_A_RealUser/faildir');
    }
    
}

?>
