<?php
declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

class Utils
{
  public static function createRecursiveFolder(string $projectDir, string $path): void
  {
    $fullPath = $projectDir . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    if (!is_dir($fullPath)) {
      mkdir($fullPath, 0777, true);
    }
  }
}