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
  /**
   * @param $globalUrl
   * @param $url
   * @param $postMode
   * @param null $postData
   * @param bool $enabledDevMode
   * @param int $timeout
   * @return array
   */
  protected function sendRequest($globalUrl, $url, $postMode, $postData = null, $enabledDevMode = false, $timeout = 10) {
    // on va faire notre check du mode test ici pour faire le mock de l'API
    $environnement = getenv('APP_ENV');
    if (strcmp($environnement , "test") != 0 && ($enabledDevMode == false || strcmp($environnement , "dev") != 0)) {
      $ch = curl_init();
      if ($postMode) {
        $ch = curl_init($globalUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      } else {
        curl_setopt($ch, CURLOPT_URL, $globalUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // On set le timeout
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

      $resultRequest = array(
        'response' => curl_exec($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
      );
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

    $ressourcesDir = $_SERVER["DOCUMENT_ROOT"] . "/../src/Ressources/";
    $fileDirectory = $ressourcesDir . "tests/";
    $file = $fileDirectory . $fileName . ".yaml";

    if (!is_dir($ressourcesDir)) {
      mkdir($ressourcesDir);
    }
    if (!is_dir($fileDirectory)) {
      mkdir($fileDirectory);
    }

    if (file_exists($file)) {
      $data = Yaml::parseFile($file);
    } else {
      $data = Yaml::dump(array('http_code' => '200', 'response' => 'default_response | file : ' . $fileName));
      file_put_contents($file, $data);
    }

    return $data;
  }
}