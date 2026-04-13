<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle;

use Imanaging\ApiCommunicationBundle\DependencyInjection\ApiCommunicationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

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