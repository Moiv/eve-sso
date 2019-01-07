<?php
namespace eve\sso;

define('CLIENT_ID', 'client_id');		// Change this to your Client ID
define('SECRET_KEY', 'secret_key');		// Change this to your Secret Key
define('CALLBACK_URL', 'http://pi/thecorp/eve-sso/callback.php');	// Change this to the location of your callback script
define('UNIQUE_STATE', 'thecorp');		// Change this to a unique string

define('FS_TOKEN_PATH', EVE_SSO_PATH.'tokens/'); // Filesystem Path for Token storage if using FSTokenStorer class

//define('ESI_SCOPE', 'esi-corporations.read_corporation_membership.v1 esi-corporations.read_blueprints.v1');
define('ESI_SCOPE', 'publicData esi-corporations.read_corporation_membership.v1 esi-characters.read_corporation_roles.v1 esi-wallet.read_corporation_wallets.v1 esi-corporations.read_divisions.v1 esi-corporations.read_contacts.v1 esi-corporations.read_titles.v1 esi-corporations.read_blueprints.v1 esi-bookmarks.read_corporation_bookmarks.v1 esi-corporations.read_standings.v1 esi-markets.read_corporation_orders.v1 esi-corporations.read_facilities.v1 esi-corporations.read_medals.v1 esi-corporations.read_fw_stats.v1 esi-corporations.read_outposts.v1');

include_once EVE_SSO_PATH.'RequestGenerator.php';

include_once EVE_SSO_PATH.'Token.php';
include_once EVE_SSO_PATH.'AuthToken.php';
include_once EVE_SSO_PATH.'RefreshToken.php';
include_once EVE_SSO_PATH.'iTokenStorer.php';
include_once EVE_SSO_PATH.'FSTokenStorer.php';

include_once EVE_SSO_PATH.'KeyChain.php';

include_once EVE_SSO_PATH.'EveSSO.php';

?>