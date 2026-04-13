<?php

declare(strict_types=1);

namespace Imanaging\ApiCommunicationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ApiCommunicationExtension extends Extension
{
  public function getContainerExtension(): ?ExtensionInterface
  {
    if (null === $this->extension) {
      $this->extension = new ApiCommunicationExtension();
    }

    return $this->extension;
  }
}