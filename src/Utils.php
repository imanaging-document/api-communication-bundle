<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 19/03/2019
 * Time: 14:08
 */

namespace Imanaging\ApiCommunicationBundle;


class Utils
{
  /**
   * @param $projectDir
   * @param $path
   */
  public static function createRecursiveFolder($projectDir, $path){
    $currentDir = $projectDir;
    $parts = explode('/', $path);
    foreach ($parts as $part){
      $currentDir .= '/'.$part;
      if (!is_dir($currentDir)){
        mkdir($currentDir);
      }
    }
  }
}