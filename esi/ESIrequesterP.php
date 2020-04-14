<?php
namespace eve\esi;

use eve\sso\Token;

/**
 * ESI Request Class with persistent curl connection.
 * @link https://esi.evetech.net/ui/
 *
 * Performs requests and returns ESIresponse objects.
 */
class ESIrequesterP {
	private $_ESI_base_path = "https://esi.evetech.net/";	//ESI Base Path
	private $_route_version = "latest";						//ESI Route Version
	protected $datasource = "tranquility";					//ESI Datasource
	//protected $datasource = "singularity";				//ESI Datasource - Test Server
	protected $language = "en-us";
	//private $_auth_token = "";							//Not currently used
	//private $_refresh_token = "";							//Not currently used
	//private $requires_auth = false;						//Not currently Used
	private $_ch;											// Curl Resource


	/**
	 * Constructor - Initialise Curl Session
	 */
	public function __construct()
	{
		$this->_ch = curl_init();
	}

	/**
	 * Get the Character ID of the auth'd character in an auth token
	 * @param Token $authToken
	 * @return \eve\esi\ESIresponse
	 */
	
	function RequestAuthId($authToken)
	{
		$request = $this->_ESI_base_path . "verify/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);
		// echo "$request<br>\n";
		// echo "$token<br>\n";

		$json = $this->CurlRequest($request, $authToken);

		return new ESIresponse($json);
	}

	/**
	 * Request character information for a given Character ID
	 *
	 * @param string $id ID of character
	 * @return ESIresponse containing a stdClass object
	 */
	function RequestCharacter($id)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/characters/" . $id . "/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);

		$json = $this->CurlRequest($request);

		return new ESIresponse($json);

// 		$contents = json_decode($json);

// 		return $contents;
	}

	/**
	 * Request character portrait for a given Character ID
	 *
	 * @param string $id ID of character
	 * @return ESIresponse containing a stdClass object
	 */
	function RequestCharacterPortrait($id)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/characters/" . $id . "/portrait/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);

		$json = $this->CurlRequest($request);

		return new ESIresponse($json);

// 		$contents = json_decode($json);

// 		return $contents;
	}

	/**
	 * Request certain data about a corp - Requires EveSSO Authentication
	 *
	 * @param string $id ID of corporation to search for
	 * @param \eve\sso\AuthToken $token Authorisation Token
	 * @param string $route ESI Route to request
	 * @return ESIresponse containing an array
	 */
	function RequestCorpData($id, $token, $route)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/corporations/" . $id . "/" . strtolower($route) . "/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);
		// echo "$request<br>\n";
		// echo "$token<br>\n";

		$json = $this->CurlRequest($request, $token);

		return new ESIresponse($json);

		// $contents = json_decode($json); // Returns Returns the value encoded in json in appropriate PHP type.
		// // Values true, false and null are returned as TRUE, FALSE and NULL respectively.
		// // NULL is returned if the json cannot be decoded or if the encoded data is deeper than the recursion limit.

		// return $contents;
	}

	/**
	 * Request public information about a corp.
	 * Does not require EveSSO authorisation
	 *
	 * @param string $id ID of corporation to search for
	 * @return ESIresponse containing a stdClass object
	 */
	function RequestCorpInfo($id)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/corporations/" . $id . "/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);
		// echo "$request";

		$json = $this->CurlRequest($request);

		return new ESIresponse($json);

// 		$contents = json_decode($json);

// 		return $contents;
	}

	/**
	 * Request a list of corporation blueprints - Requires EveSSO Authentication
	 *
	 * @param string $id ID of corporation to search for
	 * @param \eve\sso\AuthToken $token Authorisation Token
	 * @return ESIresponse containing an array
	 */
	function RequestCorpBlueprints($id, $token)
	{
		return $this->RequestCorpData($id, $token, 'blueprints');
	}

	/**
	 * Request a list of corporation industry jobs - Requires EveSSO Authentication
	 *
	 * @param string $id ID of corporation to search for
	 * @param \eve\sso\AuthToken $token Authorisation Token
	 * @return ESIresponse containing an array
	 */
	function RequestCorpIndustryJobs($id, $token)
	{
		return $this->RequestCorpData($id, $token, 'industry/jobs');
	}
	
	
	/**
	 * Request a list of corporation members - Requires EveSSO Authentication
	 *
	 * @param string $id ID of corporation to search for
	 * @param \eve\sso\AuthToken $token Authorisation Token
	 * @return ESIresponse containing an array
	 */
	function RequestCorpMembers($id, $token)
	{
		return $this->RequestCorpData($id, $token, 'members');
	}

	/**
	 * Request a list of corporation structures - Requires EveSSO Authentication
	 *
	 * @param string $id ID of corporation to search for
	 * @param \eve\sso\AuthToken $token Authorisation Token
	 * @return ESIresponse containing an array
	 */
	function RequestCorpStructures($id, $token)
	{
		return $this->RequestCorpData($id, $token, 'structures');
	}


	function RequestMarketOrders($orderType, $regionId, $itemId)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/markets/" . $regionId . "/orders?";

		$query_data = array(
			'datasource' => $this->datasource,
			'order_type' => $orderType,
			'type_id' => $itemId
		);

		$request .= http_build_query($query_data);
		echo "$request";

		$json = $this->CurlRequest($request);
		$contents = json_decode($json);

		return $contents;
	}

	/**
	 *
	 * @param string $id ID of station to search for
	 * @return object containing all station related information
	 */
	function RequestStationInfo($id)
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/universe/stations/" . $id . "/?";

		$query_data = array(
			'datasource' => $this->datasource
		);

		$request .= http_build_query($query_data);
		// echo "$request";

		$json = $this->CurlRequest($request);
		$contents = json_decode($json);

		return $contents;
	}



	/**
	 * Search for entities that match a given string<br>
	 * This search function does not require EveSSO authentication.
	 *
	 * @param string $category String containing Category of search.<br>
	 * Available values : agent, alliance, character, constellation, corporation, faction, inventory_type, region, solar_system, station
	 * @param string $string String containing the name to search for
	 * @param string $strict [optional] Whether the search should be a strict match
	 * @return ESIresponse containing a stdClass object.<br>
	 * The stdClass object will have a property named the same as the $category variable supplied, which will hold all matched ID's in an array or null if no ID found
	*/
	function Search($category, $string, $strict = "false")
	{
		$request = $this->_ESI_base_path . $this->_route_version . "/search/?";

		$query_data = array (
			'categories'=> $category,
			'datasource' => $this->datasource,
			'language' => $this->language,
			'search' => $string,
			'strict' => $strict
		);
		$request .= http_build_query($query_data);

		// Search will return an empty string if search string not found.

		$json = $this->CurlRequest($request);

		$response = new ESIresponse($json);

		//if (property_exists($response, "EmptyResponse")) return array();
		//if ($response->WasSuccessful() == false) return array('error_msg' => $response->GetErrorMsg());

		//return $response->GetResponse()->$category;     // Returns an array instead of the ESIresponse object
		return $response;
	}

	/**
	 * Perform curl request.
	 * Should return a JSON string that when decoded results in either a stdClass object for single respones
	 * or an array of stdClass objects for a multiple response.
	 *
	 * @param string $request String containing URL of GET request
	 * @param string $authtokenstring String containing the auth token
	 * @return mixed curl operation result. Should be a string, with return false if something goes horribly wrong
	 */
	private function CurlRequest($request, $authtokenstring = '')
	{
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json'
		);

		if ($authtokenstring != '') $headers[] = 'Authorization: Bearer ' . $authtokenstring;

		curl_setopt($this->_ch, CURLOPT_URL, $request);
		curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($this->_ch, CURLOPT_HEADER, 0);
		// curl_setopt($ch, CURLINFO_HEADER_OUT, 1); // Request Header
		curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->_ch, CURLOPT_TIMEOUT, 10);

		$return = curl_exec($this->_ch);

		return $return;
	}

}

?>
