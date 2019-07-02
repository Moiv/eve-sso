<?php
/**
* PHPUnit 4.2.6 Unit Tests
*/

//declare(strict_types=1);

//require_once 'PHPUnit/Autoload.php';

//require_once ('PHPUnit/Framework/TestCase.php');

use eve\sso\FSTokenStorer as FSTokenStorer;

use PHPUnit_Framework_TestCase as TestCase;

final class FSTokenStorerTest extends TestCase
{
    public function testCanBeCreatedFromValidDirectory()
    {
        $this->assertInstanceOf(
            FSTokenStorer::class
        );
    }
}

?>
