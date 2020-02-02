<?php
namespace eve\esi;

/**
 * Interface defining an ESI Response
 *
 * @author Moiv
 *
 */
interface iESIresponse
{
	/**
	 * Returns JSON decoded ESI response
	 * @return mixed
	 */
	public function GetResponse();

	/**
	 * Returns JSON encoded ESI response
	 * @return mixed
	 */
	public function GetResponseJSON();

	/**
	 * Returns sso_status value
	 * @return mixed
	 */
	public function GetSSOstatus();

	/**
	 * Returns boolean indicating whether ESI result was successful
	 * @return boolean
	 */
	public function WasSuccessful();

	/**
	 * Returns the error message from an unsuccessful ESI query
	 * @return string
	 */
	public function GetErrorMsg();
}
