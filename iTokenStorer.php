<?php
namespace eve\sso;

/**
 * Interface for TokenStorer classes
 * 
 * @author Moiv
 * #todo Add method to change storage location with option to copy tokens 
 */
interface iTokenStorer
{
	/**
	 * Store Authorisation Token
	 * @param AuthToken $token Authorisation Token
	 */
	public function StoreAuthToken(AuthToken $token);


	/**
	 * Store Refresh Token
	 * @param RefreshToken $token Refresh Token
	 */
	public function StoreRefreshToken(RefreshToken $token);


	/**
	 * Retrieves Authorisation Token
	 * @return AuthToken Authorisation Token
	 */
	public function LoadAuthToken();


	/**
	 * Retrieves Refresh Token
	 * @return RefreshToken Refresh Token
	 */
	public function LoadRefreshToken();
}

