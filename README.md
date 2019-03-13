ApiCommunicationBundle
============

This bundle allows different imanaging-document applications to communicate with each other.

This bundle can't be used outside an imanaging-document application.

Install the bundle with:

```console
$ composer require imanaging-document/api-communication-bundle
```

Configuration
----------------------------------

You have to create a ```config/packages/imanaging_api_communication.yaml``` file:
```yaml
imanaging_api_communication:
    zeus_api_url: ~
    zeus_api_login: ~
    zeus_api_password: ~
    client_traitement: ~
    core_api_url: ~
    core_api_token: ~
```

Usage in services
----------------------------------
Add a new argument to your service in your ```config/services.yaml``` file:
```yaml
login:
    class: App\Service\MyBeautifulService
    arguments: [..., '@api_zeus_communication', ...]
```

Get the ApiZeusCommunication in your this way :
```php
private ...
private $apiZeusCommunication;
private ...

/**
 * ...
 * @param ApiZeusCommunication $apiZeusCommunication
 * ...
 */
public function __construct(..., ApiZeusCommunication $apiZeusCommunication, ...){
  ...
  $this->apiZeusCommunication = $apiZeusCommunication;
  ...
}
```

Examples
----------------------------------

GET example :
```php
$url = '/my-beautiful-get-url';
$response = $this->apiZeusCommunication->sendGetRequest($url);

if ($response->getHttpCode() === 200) {
  // SOME LOGIC
}
```

POST example :
```php
$postData = array(
  '...' => '...',
  'my_post_key' => $myPostValue,
  '...' => '...',
);

$url = '/my-beautiful-post-url';
$response = $this->apiZeusCommunicationService->sendPostRequest($url, $postData);

if ($response->getHttpCode() === 201) {
  // SOME LOGIC
}
```