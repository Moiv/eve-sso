<?php
namespace eve\sso;

/**
 *
 * @author Moiv
 *        
 */
class EveSSO
{
	private $keychain = "";
	private $generator = "";
	private $tokenstorer = "";
	private $init_response;
	private $sso_status;

	/**
	 * Constructor
	 *
	 * @param array $options [Optional] An array containing options<br>
	 * Valid Options:<br>
	 * 'keychain'<br>
	 * 'requestgenerator'<br>
	 * 'tokenstorer'
	 */
	public function __construct(array $options = null)
	{
		if ($options == null) $options = array();

		//Use TokenStorer if supplied otherwise create a default one
// 		if (array_key_exists('tokenstorer', $options)) {
// 			$this->tokenstorer = $options['tokenstorer'];
// 		} else {
// 			$this->tokenstorer = new FSTokenStorer();
// 		}

		//Use KeyChain if supplied otherwise create a default one
		if (array_key_exists('keychain', $options)) {
			$this->keychain = $options['keychain'];
		} else {
			$this->keychain = new KeyChain(new FSTokenStorer(FS_TOKEN_PATH));
		}

		//Use RequestGenerator if supplied otherwise create a default one
		if (array_key_exists('requestgenerator', $options)) {
			$this->generator = $options['requestgenerator'];
		} else {
			$this->generator = new RequestGenerator(CLIENT_ID, SECRET_KEY);
			$this->generator->SetCallback(CALLBACK_URL);
			$this->generator->SetESIScope(ESI_SCOPE);
			$this->generator->SetState(UNIQUE_STATE);
		}
	}


	/**
	 * Initialise SSO
	 *@todo This should return either request URL or KeyChain object
	 */
	public function Init()
	{
		switch ($this->DecideOnAction()) {
			case 'code':
				$this->init_response=$this->generator->GenerateAuthoriseRequest(); //$this->ShowLoginButton($this->generator->GenerateAuthoriseRequest());
				break;
			case 'refresh':
				break;
		}
	}
	
	/**
	 * Get the response from the Initialisation
	 */
	public function GetInitResponse()
	{
	    return $this->init_response;
	}

	/**
	 * Decide which action is to be performed<br>code = Request code to begin auth<br>none = No action required<br>refresh = Refresh auth token
	 * @return string
	 */
	private function DecideOnAction()
	{
		if ($this->keychain->GetAuthToken() == null) return 'code';
		return 'code';
	}

	/**
	 * Output HTML Code to show the LOG IN with EVE Online button
	 * @param string $url URL for button to direct to
	 * @param int $size [optional] Size of buttom image
	 */
	public function HTMLLoginButton($url, $size=1)
	{
		switch ($size) {
			case 2:
				$img = 'eve-sso-login-white-large.png';
				break;
			case 3:
				$img = 'eve-sso-login-black-small.png';
				break;
			case 4:
				$img = 'eve-sso-login-white-small.png';
				break;
			default:
				$img = 'eve-sso-login-black-large.png';
				break;
		}
		echo " <A HREF = '$url'><img src = 'https://web.ccpgamescdn.com/eveonlineassets/developers/$img'></a>";
	}

}

