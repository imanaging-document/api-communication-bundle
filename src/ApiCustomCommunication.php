<?php

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiCustomCommunication extends ImanagingApiCommunication
{
  private $api_url;
  private $api_token;
  private $api_login;
  private $api_password;
  private $mock_enable_on_dev_env;
  private $mock_directory;

  /**
   * @param string $apiUrl
   * @param string $apiLogin
   * @param string $apiPassword
   * @param string $apiToken
   * @param string $projectDir
   * @param string $coreMockDirectory
   */
  public function __construct($apiUrl = "", $apiLogin = "", $apiPassword = "", $apiToken = "", $projectDir = "", $coreMockDirectory = ""){
    $this->api_url = $apiUrl;
    $this->api_token = $apiLogin;
    $this->api_login = $apiPassword;
    $this->api_password = $apiToken;
    $this->mock_directory = $coreMockDirectory;
    $this->projectDir = $projectDir;
    $this->mock_enable_on_dev_env = false;
  }

  /**
   * @param $url
   * @param $postData
   * @return RequestResult
   */
  public function sendPostRequest($url, $postData) {
      return $this->sendRequestCustom($url, true, $postData);
  }

  /**
   * @param $url
   * @return RequestResult
   */
  public function sendGetRequest($url) {
    if ($this->api_url)
    return $this->sendRequestCustom($url, false);
  }

  /**
   * @param $url
   * @param $postMode
   * @param null $postData
   * @return RequestResult
   */
  private function sendRequestCustom($url, $postMode, $postData = null) {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode($result['http_code']);
      $requestResult->setData($result['response']);
    }

    return $requestResult;
  }

  /**
   * @return string
   */
  public function getProjectDir(): string
  {
    return $this->projectDir;
  }

  /**
   * @param string $projectDir
   */
  public function setProjectDir(string $projectDir): void
  {
    $this->projectDir = $projectDir;
  }

  /**
   * @return null
   */
  public function getApiUrl()
  {
    return $this->api_url;
  }

  /**
   * @param null $api_url
   */
  public function setApiUrl($api_url): void
  {
    $this->api_url = $api_url;
  }

  /**
   * @return null
   */
  public function getApiToken()
  {
    return $this->api_token;
  }

  /**
   * @param null $api_token
   */
  public function setApiToken($api_token): void
  {
    $this->api_token = $api_token;
  }

  /**
   * @return null
   */
  public function getApiLogin()
  {
    return $this->api_login;
  }

  /**
   * @param null $api_login
   */
  public function setApiLogin($api_login): void
  {
    $this->api_login = $api_login;
  }

  /**
   * @return null
   */
  public function getApiPassword()
  {
    return $this->api_password;
  }

  /**
   * @param null $api_password
   */
  public function setApiPassword($api_password): void
  {
    $this->api_password = $api_password;
  }

  /**
   * @return string
   */
  public function getMockDirectory(): string
  {
    return $this->mock_directory;
  }

  /**
   * @param string $mock_directory
   */
  public function setMockDirectory(string $mock_directory): void
  {
    $this->mock_directory = $mock_directory;
  }

  /**
   * @return mixed
   */
  public function getMockDir()
  {
    return $this->mockDir;
  }

  /**
   * @param mixed $mockDir
   */
  public function setMockDir($mockDir): void
  {
    $this->mockDir = $mockDir;
  }

  /**
   * @return mixed
   */
  public function getTimeout()
  {
    return $this->timeout;
  }

  /**
   * @param mixed $timeout
   */
  public function setTimeout($timeout = 10): void
  {
    $this->timeout = $timeout;
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
}