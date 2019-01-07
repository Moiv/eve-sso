# eve-sso
Basic authentication system for Eve Online's SSO Implementation.<br>
For documentation of Eve Onlines's SSO implementation refer here (https://docs.esi.evetech.net/docs/sso/)

## Installation
It is recommended to place these files in a sub directory of your main php project

## Configuration
Edit the Configuration.php file and fill in the below:
```php
define('CLIENT_ID', 'client_id'); <-- Add your unique Client ID here
define('SECRET_KEY', 'secret_key'); <-- Add your unique Secret Key
define('CALLBACK_URL', 'http://pi/thecorp/eve-sso/callback.php');  <-- Change this callback to the relevant location
define('UNIQUE_STATE', 'thecorp'); <-- Change this to any custom unique string. Can be left as is
```
## Usage
Refer to index.php for a basic usage example, note that index.php is in the same directory as eve-sso.
If you have installed eve-sso into a sub directory you must define the EVE_SSO_PATH prior to using eve-sso.

See below for an example of using it in an existing php project, with eve-sso in a sub directory
```php
//
// Existing php code
//

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './eve-sso/');

$eveSSO = new EveSSO();

$eveSSO->Init();
```
