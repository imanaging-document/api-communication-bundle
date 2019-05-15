<?php

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiDematCommunication extends ImanagingApiCommunication
{
  private $api_demat_url;
  private $api_demat_login;
  private $api_demat_password;
  private $mock_enable_on_dev_env;
  private $mock_directory;

  /**
   * @param string $projectDir
   * @param string $apiDematUrl
   * @param string $apiDematLogin
   * @param string $apiDematPassword
   * @param string $dematMockDirectory
   */
  public function __construct($projectDir = "", $apiDematUrl = "", $apiDematLogin = "", $apiDematPassword = "", $dematMockDirectory = ""){
    $this->projectDir = $projectDir;
    $this->api_demat_url = $apiDematUrl;
    $this->api_demat_login = $apiDematLogin;
    $this->api_demat_password = $apiDematPassword;
    $this->mock_enable_on_dev_env = false;
    $this->mock_directory = $dematMockDirectory;
  }

  /**
   * @param $url
   * @param $postData
   * @return RequestResult
   */
  public function sendPostRequest($url, $postData) {
    return $this->sendRequestDemat($url, true, $postData);
  }

  /**
   * @param $url
   * @return RequestResult
   */
  public function sendGetRequest($url) {
    return $this->sendRequestDemat($url, false);
  }

  /**
   * @param $url
   * @param $postMode
   * @param null $postData
   * @return RequestResult
   */
  private function sendRequestDemat($url, $postMode, $postData = null) {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_demat_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env);

      $requestResult->setHttpCode($result['http_code']);
      $requestResult->setData($result['response']);
    }

    return $requestResult;
  }

  /**
   * @return array|false|string
   */
  public function getApiDematLogin()
  {
    return $this->api_demat_login;
  }

  /**
   * @param $api_demat_login
   */
  public function setApiDematLogin($api_demat_login): void
  {
    $this->api_demat_login = $api_demat_login;
  }

  /**
   * @return array|false|string
   */
  public function getApiDematPassword()
  {
    return $this->api_demat_password;
  }

  /**
   * @param array|false|string $api_demat_password
   */
  public function setApiDematPassword($api_demat_password): void
  {
    $this->api_demat_password = $api_demat_password;
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