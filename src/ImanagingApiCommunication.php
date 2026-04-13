<?php
declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Symfony\Component\Yaml\Yaml;

class ImanagingApiCommunication
{
  protected string $projectDir;
  protected ?string $mockDir = null;
  protected int $timeout = 10;

  /**
   * @param mixed $postData
   * @param array|null $postHttpHeader
   * @return array<string, mixed>
   */
  protected function sendRequest(string $globalUrl, string $url, bool $postMode, mixed $postData = null, bool $enabledDevMode = false, int $timeout = 10, ?array $postHttpHeader = null): array {
    // on va faire notre check du mode test ici pour faire le mock de l'API
    $environnement = getenv('APP_ENV');
    if ($environnement !== "test" && ($enabledDevMode === false || $environnement !== "dev")) {
      $ch = curl_init();
      if ($postMode) {
        $ch = curl_init($globalUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if (!is_null($postHttpHeader)){
          $postHttpHeader[] = 'Expect:';
          curl_setopt($ch, CURLOPT_HTTPHEADER, $postHttpHeader);
        } else {
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        }
      } else {
        curl_setopt($ch, CURLOPT_URL, $globalUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'Expect:'));
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // On set le timeout
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      
      // Gestion d'un proxy
      if (getenv('PROXY') === 'true') {
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXY, getenv('PROXY_URL'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      }

      $resultRequest = array(
        'response' => curl_exec($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        'curl_error' => ''
      );
      $errno = curl_errno($ch);
      if($errno !== 0) {
        $error_message = curl_strerror($errno);
        $resultRequest['curl_error'] = "cURL error ({$errno}):\n {$error_message}";
      }
      curl_close($ch);
    } else {
      // on va chercher le fichier texte correspondant
      return $this->getDataFileByParams($url, $postMode, $postData);
    }
    return $resultRequest;
  }

  /**
   * @param mixed $postData
   * @return array<string, mixed>
   */
  private function getDataFileByParams(string $url, bool $postMode, mixed $postData = null): array {
    if ($postMode) {
      $fileName = md5(json_encode($url) . json_encode($postData));
    } else {
      $fileName = md5(json_encode($url));
    }

    Utils::createRecursiveFolder($this->projectDir, (string)$this->mockDir);
    $filePath = $this->projectDir . $this->mockDir . $fileName . ".yaml";

    if (file_exists($filePath)) {
      $data = Yaml::parseFile($filePath);
    } else {
      $data = Yaml::dump(array('http_code' => '200', 'response' => 'default_response | file : ' . $fileName, 'curl_error' => ''));
      file_put_contents($filePath, $data);
      $data = Yaml::parse($data);
    }

    return (array)$data;
  }

  public function setTimeout(int $timeout = 10): void {
    $this->timeout = $timeout;
  }
}
