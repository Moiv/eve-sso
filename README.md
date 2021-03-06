# eve-sso
Basic authentication system for Eve Online's SSO Implementation.<br>
For documentation of Eve Onlines's SSO implementation refer here (https://docs.esi.evetech.net/docs/sso/)

## Installation
It is recommended to place these files in a sub directory of your main php project

## Configuration
Rename Configuration.sample.php to Configuration.php file and fill in the below:
```php
define('CLIENT_ID', 'client_id'); <-- Change to your unique Client ID
define('SECRET_KEY', 'secret_key'); <-- Change to your unique Secret Key
define('CALLBACK_URL', 'http://pi/thecorp/eve-sso/callback.php');  <-- Change this callback to the relevant location
define('UNIQUE_STATE', 'thecorp'); <-- Change this to any custom unique string. Can be left as is
```
## Usage
Refer to index.php for a basic usage example, note that the sample index.php is in the same directory as eve-sso.
If you have installed eve-sso into a sub directory you must define the EVE_SSO_PATH prior to using eve-sso in your existing code.

See below for an example of using it in an existing php project, with eve-sso in a sub directory
```php
//
// Existing php code
//

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './eve-sso/');
include EVE_SSO_PATH.'Configuration.php';

$eveSSO = new /eve/sso/EveSSO();

$eveSSO->Init();
```
