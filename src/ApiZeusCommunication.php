<?php

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiZeusCommunication extends ImanagingApiCommunication
{
  protected $api_zeus_url;
  protected $api_zeus_login;
  protected $api_zeus_password;
  protected $client_traitement;
  protected $mock_enable_on_dev_env;

  /**
   * @param string $projectDir
   * @param string $apiZeusUrl
   * @param string $apiZeusLogin
   * @param string $apiZeusPassword
   * @param string $mockDirectory
   * @param string $clientTraitement
   */
  public function __construct($projectDir = "", $apiZeusUrl = "", $apiZeusLogin = "", $apiZeusPassword = "", $apiZeusToken = "", $mockDirectory = "", $clientTraitement = ""){
    $this->projectDir =$projectDir ;
    $this->api_zeus_url =$apiZeusUrl ;
    $this->api_zeus_login = $apiZeusLogin;
    $this->api_zeus_password = $apiZeusPassword;
    $this->api_zeus_token = $apiZeusToken;
    $this->mockDir = $mockDirectory;
    $this->client_traitement = $clientTraitement;
    $this->mock_enable_on_dev_env = false;
  }

  /**
   * @param $url
   * @param $postData
   * @return RequestResult
   */
  public function sendPostRequest($url, $postData) {
    return $this->sendRequestZeus($url, true, $postData);
  }

  /**
   * @param $url
   * @return RequestResult
   */
  public function sendGetRequest($url) {
    return $this->sendRequestZeus($url, false);
  }

  /**
   * @param $url
   * @param $postMode
   * @param null $postData
   * @return RequestResult
   */
  private function sendRequestZeus($url, $postMode, $postData = null) {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_zeus_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode($result['http_code']);
      $requestResult->setData($result['response']);
    }

    return $requestResult;
  }

  /**
   * @return array|false|string
   */
  public function getApiZeusLogin()
  {
    return $this->api_zeus_login;
  }

  /**
   * @param array|false|string $api_zeus_login
   */
  public function setApiZeusLogin($api_zeus_login): void
  {
    $this->api_zeus_login = $api_zeus_login;
  }

  /**
   * @return array|false|string
   */
  public function getApiZeusPassword()
  {
    return $this->api_zeus_password;
  }

  /**
   * @param array|false|string $api_zeus_password
   */
  public function setApiZeusPassword($api_zeus_password): void
  {
    $this->api_zeus_password = $api_zeus_password;
  }

  /**
   * @return mixed|string
   */
  public function getApiZeusToken(): string
  {
    return hash('sha256', $this->api_zeus_token);
  }

  /**
   * @param mixed|string $api_zeus_token
   */
  public function setApiZeusToken(string $api_zeus_token): void
  {
    $this->api_zeus_token = $api_zeus_token;
  }

  /**
   * @return bool
   */
  public function isMockEnableOnDevEnv(): bool
  {
    return $this->mock_enable_on_dev_env;
  }

  /**
   * @param bool $mock_enable_on_dev_env
   */
  public function setMockEnableOnDevEnv(bool $mock_enable_on_dev_env): void
  {
    $this->mock_enable_on_dev_env = $mock_enable_on_dev_env;
  }

  /**
   * @return array|false|string
   */
  public function getClientTraitement()
  {
    return $this->client_traitement;
  }
}