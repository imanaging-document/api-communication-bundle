<?php
/**
 * Created by PhpStorm.
 * User: Antonin
 * Date: 29/07/2018
 * Time: 19:51
 */

namespace Imanaging\ApiCommunicationBundle;

use Symfony\Component\Yaml\Yaml;

class ImanagingApiCommunication
{
  protected $projectDir;
  protected $mockDir;

  /**
   * @param $globalUrl
   * @param $url
   * @param $postMode
   * @param null $postData
   * @param bool $enabledDevMode
   * @param int $timeout
   * @param null $postHttpHeader
   * @return array
   */
  protected function sendRequest($globalUrl, $url, $postMode, $postData = null, $enabledDevMode = false, $timeout = 10, $postHttpHeader = null) {
    // on va faire notre check du mode test ici pour faire le mock de l'API
    $environnement = getenv('APP_ENV');
    if (strcmp($environnement , "test") != 0 && ($enabledDevMode == false || strcmp($environnement , "dev") != 0)) {
      $ch = curl_init();
      if ($postMode) {
        $ch = curl_init($globalUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if (!is_null($postHttpHeader)){
          curl_setopt($ch, CURLOPT_HTTPHEADER, $postHttpHeader);
        }
      } else {
        curl_setopt($ch, CURLOPT_URL, $globalUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // On set le timeout
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

      $resultRequest = array(
        'response' => curl_exec($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        'curl_error' => ''
      );
      if($errno = curl_errno($ch)) {
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

  private function getDataFileByParams($url, $postMode, $postData = null) {
    if ($postMode) {
      $fileName = md5(json_encode($url) . json_encode($postData));
    } else {
      $fileName = md5(json_encode($url));
    }

    Utils::createRecursiveFolder($this->projectDir, $this->mockDir);
    $filePath = $this->projectDir . $this->mockDir . $fileName . ".yaml";

    if (file_exists($filePath)) {
      $data = Yaml::parseFile($filePath);
    } else {
      $data = Yaml::dump(array('http_code' => '200', 'response' => 'default_response | file : ' . $fileName, 'curl_error' => ''));
      file_put_contents($filePath, $data);
    }

    return $data;
  }
}