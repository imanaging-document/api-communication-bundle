<?php

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiCoreCommunication extends ImanagingApiCommunication
{
  private $api_core_type;
  private $api_core_url;
  private $api_core_login;
  private $api_core_password;
  private $api_core_token;
  private $api_core_client_traitement;
  private $api_core_annee;
  private $api_core_application_id;
  private $mock_enable_on_dev_env;
  private $mock_directory;

  /**
   * @param string $projectDir
   * @param string $apiCoreUrl
   * @param string $apiCoreToken
   * @param string $coreMockDirectory
   */
  public function __construct($projectDir = "", $apiCoreType = "", $apiCoreUrl = "", $apiCoreToken = "", $apiCoreClientTraitement = "", $apiCoreAnnee = "", $coreMockDirectory = ""){
    $this->api_core_type = $apiCoreType;
    $this->api_core_url = $apiCoreUrl;
    $this->api_core_token = $apiCoreToken;
    $this->api_core_client_traitement = $apiCoreClientTraitement;
    $this->api_core_annee = $apiCoreAnnee;
    $this->mock_enable_on_dev_env = false;
    $this->api_core_application_id = null;
    $this->mock_directory = $coreMockDirectory;
    $this->projectDir = $projectDir;
  }

  /**
   * @param $url
   * @param $postData
   * @return RequestResult
   */
  public function sendPostRequest($url, $postData) {
    return $this->sendRequestCore($url, true, $postData);
  }

  /**
   * @param $url
   * @return RequestResult
   */
  public function sendGetRequest($url) {
    return $this->sendRequestCore($url, false);
  }

  /**
   * @param $url
   * @param $postMode
   * @param null $postData
   * @return RequestResult
   */
  private function sendRequestCore($url, $postMode, $postData = null) {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_core_url . $url;

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
  public function getApiCoreLogin()
  {
    return $this->api_core_login;
  }

  /**
   * @param $api_core_login
   */
  public function setApiZeusLogin($api_core_login): void
  {
    $this->api_core_login = $api_core_login;
  }

  /**
   * @return array|false|string
   */
  public function getApiCorePassword()
  {
    return $this->api_core_password;
  }

  /**
   * @param array|false|string $api_core_password
   */
  public function setApiCorePassword($api_core_password): void
  {
    $this->api_core_password = $api_core_password;
  }

  /**
   * @return array|false|string
   */
  public function getApiCoreToken()
  {
    return $this->api_core_token;
  }

  /**
   * @param array|false|string $api_core_token
   */
  public function setApiCoreToken($api_core_token): void
  {
    $this->api_core_token = $api_core_token;
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

  public function getTypeApplication() {
    return $this->api_core_type;
  }

  public function getApiCoreApplicationId() {
    if (is_null($this->api_core_application_id)) {
      $this->initApplicationId();
    }
    return $this->api_core_application_id;
  }

  private function initApplicationId() {
    if ($this->api_core_type == "attestation") {
      $url = '/application-attestation?token=' . $this->api_core_token . '&client_traitement=' . $this->api_core_client_traitement;
    } elseif ($this->api_core_type == "enquete") {
      $url = '/application-enquete?token=' . $this->api_core_token . '&client_traitement=' . $this->api_core_client_traitement . '&annee=' . $this->api_core_annee;
    } else {
      return false;
    }

    $response = $this->sendGetRequest($url);
    if ($response->getHttpCode() == '200') {
      $application = json_decode($response->getData());
      $this->api_core_application_id = $application->id;

      return true;
    } else {
      return false;
    }
  }
}