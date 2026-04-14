<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiCustomCommunication extends ImanagingApiCommunication
{
  private bool $mock_enable_on_dev_env = false;

  public function __construct(
    private string $api_url = "",
    private string $api_login = "",
    private string $api_password = "",
    private string $api_token = "",
    string $projectDir = "",
    ?string $coreMockDirectory = ""
  ) {
    $this->projectDir = $projectDir;
    $this->mockDir = $coreMockDirectory;
    $this->mock_enable_on_dev_env = false;
  }

  public function sendPostRequest(string $url, mixed $postData): RequestResult {
      return $this->sendRequestCustom($url, true, $postData);
  }

  public function sendGetRequest(string $url): RequestResult {
    return $this->sendRequestCustom($url, false);
  }

  private function sendRequestCustom(string $url, bool $postMode, mixed $postData = null): RequestResult {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode((int)$result['http_code']);
      $requestResult->setData((string)$result['response']);
      if ($result['curl_error'] != '') {
        $requestResult->setError(true);
        $requestResult->setLibelleError((string)$result['curl_error']);
      }
    }

    return $requestResult;
  }

  public function getProjectDir(): string
  {
    return $this->projectDir;
  }

  public function setProjectDir(string $projectDir): void
  {
    $this->projectDir = $projectDir;
  }

  public function getApiUrl(): string
  {
    return $this->api_url;
  }

  public function setApiUrl(string $api_url): void
  {
    $this->api_url = $api_url;
  }

  public function getApiToken(): string
  {
    return $this->api_token;
  }

  public function setApiToken(string $api_token): void
  {
    $this->api_token = $api_token;
  }

  public function getApiLogin(): string
  {
    return $this->api_login;
  }

  public function setApiLogin(string $api_login): void
  {
    $this->api_login = $api_login;
  }

  public function getApiPassword(): string
  {
    return $this->api_password;
  }

  public function setApiPassword(string $api_password): void
  {
    $this->api_password = $api_password;
  }

  public function getMockDirectory(): string
  {
    return (string)$this->mockDir;
  }

  public function setMockDirectory(string $mock_directory): void
  {
    $this->mockDir = $mock_directory;
  }

  public function getMockDir(): ?string
  {
    return $this->mockDir;
  }

  public function setMockDir(?string $mockDir): void
  {
    $this->mockDir = $mockDir;
  }

  public function getTimeout(): int
  {
    return $this->timeout;
  }

  public function setTimeout(int $timeout = 10): void
  {
    $this->timeout = $timeout;
  }

  public function isMockEnableOnDevEnv(): bool
  {
    return $this->mock_enable_on_dev_env;
  }

  public function setMockEnableOnDevEnv(bool $mock_enable_on_dev_env): void
  {
    $this->mock_enable_on_dev_env = $mock_enable_on_dev_env;
  }
}
