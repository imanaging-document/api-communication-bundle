<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 11/03/2019
 * Time: 14:52
 */

namespace Imanaging\ApiCommunicationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ApiCommunicationExtension extends Extension
{
  /**
   * @param array $configs
   * @param ContainerBuilder $container
   * @throws \Exception
   */
  public function load(array $configs, ContainerBuilder $container)
  {
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    $definition = $container->getDefinition('imanaging_api_communication.api_core_communication');
    $definition->setArgument(0, $config['project_dir']);
    $definition->setArgument(1, $config['core_api_url']);
    $definition->setArgument(2, $config['core_api_token']);
    $definition->setArgument(3, $config['core_mock_dir']);

    $definition = $container->getDefinition('imanaging_api_communication.api_zeus_communication');
    $definition->setArgument(0, $config['project_dir']);
    $definition->setArgument(1, $config['zeus_api_url']);
    $definition->setArgument(2, $config['zeus_api_login']);
    $definition->setArgument(3, $config['zeus_api_password']);
    $definition->setArgument(4, $config['zeus_mock_dir']);
    $definition->setArgument(5, $config['client_traitement']);
  }

  public function getAlias()
  {
    return 'imanaging_api_communication';
  }
}