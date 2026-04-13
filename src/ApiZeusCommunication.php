<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiZeusCommunication extends ImanagingApiCommunication
{
  private bool $mock_enable_on_dev_env = false;
  private string $api_zeus_token;

  public function __construct(
    string $projectDir = "",
    private string $api_zeus_url = "",
    private string $api_zeus_login = "",
    private string $api_zeus_password = "",
    string $api_zeus_token = "",
    ?string $mockDirectory = "",
    private string $client_traitement = ""
  ) {
    $this->projectDir = $projectDir;
    $this->mockDir = $mockDirectory;
    $this->api_zeus_token = $api_zeus_token;
    $this->mock_enable_on_dev_env = false;
  }

  public function sendPostRequest(string $url, mixed $postData): RequestResult {
    return $this->sendRequestZeus($url, true, $postData);
  }

  public function sendGetRequest(string $url): RequestResult {
    return $this->sendRequestZeus($url, false);
  }

  private function sendRequestZeus(string $url, bool $postMode, mixed $postData = null): RequestResult {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_zeus_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode((string)$result['http_code']);
      $requestResult->setData((string)$result['response']);
    }

    return $requestResult;
  }

  public function getApiZeusLogin(): string
  {
    return $this->api_zeus_login;
  }

  public function setApiZeusLogin(string $api_zeus_login): void
  {
    $this->api_zeus_login = $api_zeus_login;
  }

  public function getApiZeusPassword(): string
  {
    return $this->api_zeus_password;
  }

  public function setApiZeusPassword(string $api_zeus_password): void
  {
    $this->api_zeus_password = $api_zeus_password;
  }

  public function getApiZeusToken(): string
  {
    return hash('sha256', $this->api_zeus_token);
  }

  public function setApiZeusToken(string $api_zeus_token): void
  {
    $this->api_zeus_token = $api_zeus_token;
  }

  public function isMockEnableOnDevEnv(): bool
  {
    return $this->mock_enable_on_dev_env;
  }

  public function setMockEnableOnDevEnv(bool $mock_enable_on_dev_env): void
  {
    $this->mock_enable_on_dev_env = $mock_enable_on_dev_env;
  }

  public function getClientTraitement(): string
  {
    return $this->client_traitement;
  }
}