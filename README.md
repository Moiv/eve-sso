# eve-sso
Basic authentication system for Eve Online's SSO Implementation.

## Installation
It is recommended to place these files in a sub directory of your main php project

## Configuration
Edit the Configuration.php file and fill in the below:
```php
define('CLIENT_ID', 'client_id'); <-- Add your unique Client ID here
define('SECRET_KEY', 'secret_key'); <-- Add your unique Secret Key
define('CALLBACK_URL', 'http://pi/thefarkencorp/eve-sso/callback.php');  <-- Change this callback to the relevant location
define('UNIQUE_STATE', 'thecorp'); <-- Change this to any custom unique string. Can be left as is
```
## Usage
Refer to index.php for a basic usage example, note that this is in the same directory as eve-sso.
If you have installed eve-sso into a sub directory you must define the EVE_SSO_PATH prior to using eve-sso.
```php
//
// Existing php code
//

if (!defined('EVE_SSO_PATH')) define('EVE_SSO_PATH', './eve-sso/');

$eveSSO = new EveSSO();

$eveSSO->Init();
```
