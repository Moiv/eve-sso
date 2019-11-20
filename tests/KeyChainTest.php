<?php
namespace eve\sso\tests;

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');
require_once EVE_SSO_PATH.'iTokenStorer.php';
require_once EVE_SSO_PATH.'FSTokenStorer.php';
require_once EVE_SSO_PATH.'KeyChain.php';

/**
 *
 * @author Mike
 *        
 */

use PHPUnit_Framework_TestCase as TestCase;
use eve\sso\FSTokenStorer;
use eve\sso\KeyChain;

final class KeyChainTest extends TestCase
{
	protected $tokenStorer;
	
	protected function setUp()
	{
		$this->tokenStorer = new FSTokenStorer('/tmp');
	}
	
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testCreatingWithoutArgumentsExpectException()
	{
		$keychain = new KeyChain();
		
		$this->assertEmpty($keychain, 'Expecting $keychain to be empty?');
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testCreatingWitgOnlyTokenStorerExpectException()
	{
		$keychain = new KeyChain($this->tokenStorer);
	}
	
	
	
}

