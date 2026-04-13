<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiDematCommunication extends ImanagingApiCommunication
{
  private bool $mock_enable_on_dev_env = false;

  public function __construct(
    string $projectDir = "",
    private string $api_demat_url = "",
    private string $api_demat_login = "",
    private string $api_demat_password = "",
    ?string $dematMockDirectory = ""
  ) {
    $this->projectDir = $projectDir;
    $this->mockDir = $dematMockDirectory;
    $this->mock_enable_on_dev_env = false;
  }

  public function sendPostRequest(string $url, ?array $postData): RequestResult {
    return $this->sendRequestDemat($url, true, $postData);
  }

  public function sendGetRequest(string $url): RequestResult {
    return $this->sendRequestDemat($url, false);
  }

  private function sendRequestDemat(string $url, bool $postMode, ?array $postData = null): RequestResult {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_demat_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode((string)$result['http_code']);
      $requestResult->setData((string)$result['response']);
    }

    return $requestResult;
  }

  public function getApiDematLogin(): string
  {
    return $this->api_demat_login;
  }

  public function setApiDematLogin(string $api_demat_login): void
  {
    $this->api_demat_login = $api_demat_login;
  }

  public function getApiDematPassword(): string
  {
    return $this->api_demat_password;
  }

  public function setApiDematPassword(string $api_demat_password): void
  {
    $this->api_demat_password = $api_demat_password;
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