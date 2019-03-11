<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 28/06/2017
 * Time: 12:45
 */

namespace Imanaging\ApiCommunicationBundle;

use App\Entity\RequestResult;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiZeusCommunication extends ImanagingApiCommunication
{
  protected $api_zeus_url;
  protected $api_zeus_login;
  protected $api_zeus_password;
  protected $client_traitement;
  protected $mock_enable_on_dev_env;

  /**
   */
  public function __construct(){
    $this->client_traitement = getenv('CLIENT_TRAITEMENT');
    $this->api_zeus_url = getenv('ZEUS_API_URL');
    $this->api_zeus_login = getenv('ZEUS_API_LOGIN');
    $this->api_zeus_password = getenv('ZEUS_API_PASSWORD');
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

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env);

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