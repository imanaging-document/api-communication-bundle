declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\Entity\RequestResult;

class ApiCoreCommunication extends ImanagingApiCommunication
{
  private ?string $api_core_login = null;
  private ?string $api_core_password = null;
  private ?int $api_core_application_id = null;
  private bool $mock_enable_on_dev_env = false;

  public function __construct(
    string $projectDir = "",
    private string $api_core_type = "",
    private string $api_core_url = "",
    private string $api_core_token = "",
    private string $api_core_client_traitement = "",
    private string $api_core_annee = "",
    ?string $mock_directory = ""
  ) {
    $this->projectDir = $projectDir;
    $this->mockDir = $mock_directory;
    $this->api_core_application_id = null;
    $this->mock_enable_on_dev_env = false;
  }

  public function sendPostRequest(string $url, ?array $postData): RequestResult {
    return $this->sendRequestCore($url, true, $postData);
  }

  public function sendGetRequest(string $url): RequestResult {
    return $this->sendRequestCore($url, false);
  }

  private function sendRequestCore(string $url, bool $postMode, ?array $postData = null): RequestResult {
    $requestResult = new RequestResult($url, $postMode, $postData);

    // si pas d'erreur, on continue
    if (!$requestResult->isError()) {
      // on lance l'appel API vers Hestia
      $globalUrl = $this->api_core_url . $url;

      $requestResult->setGlobalUrl($globalUrl);

      $result = $this->sendRequest($globalUrl, $url, $postMode, $postData, $this->mock_enable_on_dev_env, $this->timeout);

      $requestResult->setHttpCode((string)$result['http_code']);
      $requestResult->setData((string)$result['response']);
    }

    return $requestResult;
  }

  public function getApiCoreLogin(): ?string
  {
    return $this->api_core_login;
  }

  public function setApiZeusLogin(?string $api_core_login): void
  {
    $this->api_core_login = $api_core_login;
  }

  public function getApiCorePassword(): ?string
  {
    return $this->api_core_password;
  }

  public function setApiCorePassword(?string $api_core_password): void
  {
    $this->api_core_password = $api_core_password;
  }

  public function getApiCoreToken(): string
  {
    return $this->api_core_token;
  }

  public function setApiCoreToken(string $api_core_token): void
  {
    $this->api_core_token = $api_core_token;
  }

  public function isMockEnableOnDevEnv(): bool
  {
    return $this->mock_enable_on_dev_env;
  }

  public function setMockEnableOnDevEnv(bool $mock_enable_on_dev_env): void
  {
    $this->mock_enable_on_dev_env = $mock_enable_on_dev_env;
  }

  public function getTypeApplication(): string {
    return $this->api_core_type;
  }

  public function getApiCoreApplicationId(): ?int {
    if (is_null($this->api_core_application_id)) {
      $this->initApplicationId();
    }
    return $this->api_core_application_id;
  }

  private function initApplicationId(): bool {
    if ($this->api_core_type == "attestation") {
      $url = '/application-attestation?token=' . hash('sha256', $this->api_core_token) . '&client_traitement=' . $this->api_core_client_traitement;
    } elseif ($this->api_core_type == "enquete") {
      $url = '/application-enquete?token=' . hash('sha256', $this->api_core_token) . '&client_traitement=' . $this->api_core_client_traitement . '&annee=' . $this->api_core_annee;
    } elseif ($this->api_core_type == "hqmc") {
      $url = '/application-hqmc?token=' . hash('sha256', $this->api_core_token) . '&client_traitement=' . $this->api_core_client_traitement;
    } else {
      return false;
    }

    $response = $this->sendGetRequest($url);
    if ($response->getHttpCode() == '200') {
      $application = json_decode((string)$response->getData());
      $this->api_core_application_id = $application->id;

      return true;
    } else {
      return false;
    }
  }
}