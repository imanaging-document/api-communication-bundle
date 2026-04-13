<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\DependencyInjection\ApiCommunicationExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiCommunicationBundle extends Bundle
{
  public function getContainerExtension(): ?ExtensionInterface
  {
    if (null === $this->extension) {
      $this->extension = new ApiCommunicationExtension();
    }

    return $this->extension;
  }
}