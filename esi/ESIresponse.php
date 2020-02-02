<?php
namespace eve\esi;

/**
 * ESI Response
 *
 * @author Moiv
 *
 */
class ESIresponse implements iESIresponse
{

	private $_error_msg;
	private $_json;
	private $_response;
	private $_sso_status;
	private $_success;

	/**
	 * ESI Response<br>
	 * Constructor
	 *
	 * @param string $json json string from ESI server
	 */
	public function __construct($json)
	{
		$this->_json = $json;
		$this->_response = json_decode($json);
		$this->_success = true;

		if ($this->_json == false) {
			$this->_success = false;
			$this->_error_msg = "Curl Request Failed";
			return;
		}

		if (! is_object($this->_response) && ! is_array($this->_response)) {
			$this->_success = false;
			$this->_error_msg = "Response is neither an object or an array";
			return;
		}

		// if (property_exists($this->_response,"error") && $this->_response->error != null) {
		if (is_object($this->_response) && property_exists($this->_response, "error")) {
			$this->_success = false;
			$this->_error_msg = $this->_response->error;
		}

		if (is_object($this->_response) && property_exists($this->_response, "sso_status")) {
			// print "SSO Status Exists: ".$this->_response->sso_status;
			$this->_sso_status = $this->_response->sso_status;
		}

		if (strlen($this->_json) < 4) // This means an empty response from ESI Servers - Usually after a search was not found
		{
			$this->_response->EmptyResponse = true;
		}
	}

	/**
	 * Returns JSON decoded ESI response
	 * @return mixed - Should be a \stdClass object but can have any output possible from json_decode()
	 */
	public function GetResponse()
	{
		return $this->_response;
	}

	/**
	 * Returns JSON encoded ESI response
	 *
	 * @return mixed
	 */
	public function GetResponseJSON()
	{
		return $this->_json;
	}

	/**
	 * Returns sso_status value
	 *
	 * @return mixed
	 */
	public function GetSSOstatus()
	{
		return $this->_sso_status;
	}

	/**
	 * Returns boolean indicating whether ESI result was successful
	 *
	 * @return boolean
	 */
	public function WasSuccessful()
	{
		return $this->_success;
	}

	/**
	 * Returns the error message from an unsuccessful ESI query
	 *
	 * @return string
	 */
	public function GetErrorMsg()
	{
		return $this->_error_msg;
	}

}

