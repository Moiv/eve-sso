<?php
namespace eve\sso\tests;

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './');
include EVE_SSO_PATH.'Configuration.php';

/**
 * Unit tests for phpunit 4.2
 * @author Moiv
 *
 */

use PHPUnit_Framework_TestCase as TestCase;
use eve\sso\FSTokenStorer;
use eve\sso\KeyChain;
use eve\esi\ESIresponse;

final class ESIRequesterPTest extends TestCase
{
/* 	protected $keychain;
	protected $tokenStorer;
	protected $requester; */

	protected static $tokenStorer;
	protected static $keychain;
	protected static $requester;

	public static function setUpBeforeClass()
	{
		echo "Running setUpBeforeClass\n\n";
		self::$tokenStorer = new FSTokenStorer(FS_TOKEN_PATH);
		self::$keychain = new KeyChain(self::$tokenStorer, CLIENT_ID, SECRET_KEY);
		self::$requester = new \eve\esi\ESIrequesterP();
	}


	/*
	 * @covers ESIRequesterP::RequestAuthID
	 */
	public function testRequestRequestAuthWithBadTokenExpectESIResponseWithStdClass()
	{
		$badtoken = '1234567890JSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.0987654321sicHVibGljRGF0YSIsImVzjuthdveuthazdGlvbnMucmVhZF9jb3Jwb3JhdGlvbl9tZW1iZXJzaGlwLnYxIiwiZXNpLWNvcnBvcmF0aW9ucy5yZWFkX3N0cnVjdHVyZXMudjEiLCJlc2ktY2hhcmFjdGVycy5yZWFkX2NvcnBvcmF0aW9uX3JvbGVzLnYxIiwiZXNpLXdhbGxldC5yZWFkX2NvcnBvcmF0aW9uX3dhbGxldHMudjEiLCJlc2ktY29ycG9yYXRpb25zLnJlYWRfZGl2aXNpb25zLnYxIiwiZXNpLWNvcnBvcmF0aW9ucy5yZWFkX2NvbnRhY3RzLnYxIiwiZXNpLWFzc2V0cy5yZWFkX2NvcnBvcmF0aW9uX2Fzc2V0cy52MSIsImVzaS1jb3Jwb3JhdGlvbnMucmVhZF90aXRsZXMudjEiLCJlc2ktY29ycG9yYXRpb25zLnJlYWRfYmx1ZXByaW50cy52MSIsImVzaS1ib29rbWFya3MucmVhZF9jb3Jwb3JhdGlvbl9ib29rbWFya3MudjEiLCJlc2ktY29ycG9yYXRpb25zLnJlYWRfc3RhbmRpbmdzLnYxIiwiZXNpLW1hcmtldHMucmVhZF9jb3Jwb3JhdGlvbl9vcmRlcnMudjEiLCJlc2ktY29ycG9yYXRpb25zLnJlYWRfZmFjaWxpdGllcy52MSIsImVzaS1jb3Jwb3JhdGlvbnMucmVhZF9tZWRhbHMudjEiLCJlc2ktY29ycG9yYXRpb25zLnJlYWRfZndfc3RhdHMudjEiXSwianRpIjoiZjliNjQ0YWYtZmU0OS00YTY3LWI5MzktMjM1ZGRmMmE1ZmNhIiwia2lkIjoiSldULVNpZ25hdHVyZS1LZXkiLCJzdWIiOiJDSEFSQUNURVI6RVZFOjk0NTMzNDkzIiwiYXpwIjoiMmMyZGE5NjgwNmNjNGYwZjhmNDA5ODk5NTU1MmUwNjEiLCJuYW1lIjoiTW9pdiBGYXJrZW4iLCJvd25lciI6IjR3a2dwRUdObHU0TTlSaU5PVi8wYVE2OWFtdz0iLCJleHAiOjE1ODA1NDYxODIsImlzcyI6ImxvZ2luLmV2ZW9ubGluZS5jb20ifQ.clhsp7eEHNzzIzZodb_EYDLSFzRY1b8wr6DWgaMfYDZSJiTzpOm_O--8-sw-q1KFloLN1dZ63-F4lJoivn8kCUBJJcmPOTODI85PzNh4soGDBLqPzG6plWHr90L_bDhQ-YAwrDT0xn4DN0zg91k8m4NgL84nX8Xe7ioco_wInt3AhA0SoZ532hRh_YAe7gTj6ugv5USLozSJWFvK6ah6-fd1jEEZdbHABuaOEdWlctRyVi12P9So3r7vyI6yCq-VHvbyhH7L3qfe3nXZVJiP4kZTMXuochHY61YWPUzrtFZMha1XZXAN92KgBWW6x7xcLaUde54hU4elayiDx12345';
		$test = self::$requester->RequestAuthId($badtoken);

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertFalse($test->WasSuccessful());
		$this->assertObjectHasAttribute('error', $test->GetResponse());
	}


	/*
	 * @covers ESIRequesterP::RequestCharacter
	 */
	public function testRequestCharacterExpectESIResponseWithStdClass()
	{
		$character_id ='90624194';
		//$test = $this->requester->RequestCharacter($character_id);
		$test = self::$requester->RequestCharacter($character_id);

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
	}


	/*
	 * @covers ESIRequesterP::RequestCharacterPortrait
	 */
	public function testRequestCharacterPortraitExpectESIResponseWithStdClass()
	{
		$character_id ='90624194';
// 		$test = $this->requester->RequestCharacterPortrait($character_id);
		$test = self::$requester->RequestCharacterPortrait($character_id);

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
	}


	/*
	 * @covers ESIRequesterP::RequestCorpInfo
	 */
	public function testRequestCorpInfoExpectESIResponseWithStdClass()
	{
		$corp_id = '98307344';
		// 		$test = $this->requester->RequestCharacterPortrait($character_id);
		$test = self::$requester->RequestCorpInfo($corp_id);

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
	}


	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 */
	public function testSearchForRegionExpectESIResponseWithStdClass()
	{
// 		$test = $this->requester->Search('region', 'Forge');
		$test = self::$requester->Search('region', 'Forge');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
		$this->assertInternalType('array', $test->GetResponse()->region);
	}

	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 */
	public function testSearchForCharacterExpectESIResponseWithStdClass()
	{
// 		$test = $this->requester->Search('character', 'Charles');
		$test = self::$requester->Search('character', 'Charles');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
		$this->assertInternalType('array', $test->GetResponse()->character);
	}

	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 */
	public function testSearchForNonExistingCharacterExpectESIResponseWithStdClass()
	{
// 		$test = $this->requester->Search('character', 'Charleshswtehdsfb');
		$test = self::$requester->Search('character', 'Charleshswtehdsfb');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
		$this->assertObjectHasAttribute('EmptyResponse', $test->GetResponse());
	}

	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 */
	public function testSearchForCorpExpectESIResponseWithStdClass()
	{
// 		$test = $this->requester->Search('corporation', 'Charles');
		$test = self::$requester->Search('corporation', 'Charles');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
		$this->assertInternalType('array', $test->GetResponse()->corporation);
	}

	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 */
	public function testSearchForInventoryTypeExpectESIResponseWithStdClass()
	{
		// 		$test = $this->requester->Search('corporation', 'Charles');
		$test = self::$requester->Search('inventory_type', 'Compressed');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertTrue($test->WasSuccessful());
		$this->assertInternalType('array', $test->GetResponse()->inventory_type);
	}


	/*
	 * @covers ESIRequesterP::Search
	 * @group searches
	 * @group badrequests
	 */
	public function testSearchForBadInventoryTypeExpectESIResponseWithStdClass()
	{
		// 		$test = $this->requester->Search('corporation', 'Charles');
		$test = self::$requester->Search('chacter', 'Josh');

		$this->assertInstanceOf(ESIresponse::class, $test);
		$this->assertInstanceOf(\stdClass::class, $test->GetResponse());
		$this->assertFalse($test->WasSuccessful());
		$this->assertInternalType('string', $test->GetResponse()->error);
	}



// 	echo "<br>\nSearch for Bad Corp Blueprints\n";
// 	var_dump($requester->RequestCorpData($corp_id, $badtoken, 'blueprints'));         // Search for corp info with a bad token */


}

