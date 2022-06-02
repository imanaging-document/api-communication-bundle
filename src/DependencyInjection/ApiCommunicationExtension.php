<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 11/03/2019
 * Time: 14:52
 */

namespace Imanaging\ApiCommunicationBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ApiCommunicationExtension extends Extension
{
  /**
   * @param array $configs
   * @param ContainerBuilder $container
   * @throws Exception
   */
  public function load(array $configs, ContainerBuilder $container)
  {
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    $definition = $container->getDefinition('imanaging_api_communication.api_core_communication');
    $definition->setArgument(0, $config['project_dir']);
    $definition->setArgument(1, $config['core_api_type']);
    $definition->setArgument(2, $config['core_api_url']);
    $definition->setArgument(3, $config['core_api_token']);
    $definition->setArgument(4, $config['core_api_client_traitement']);
    $definition->setArgument(5, $config['core_api_annee']);
    $definition->setArgument(6, $config['core_mock_dir']);

    $definition = $container->getDefinition('imanaging_api_communication.api_zeus_communication');
    $definition->setArgument(0, $config['project_dir']);
    $definition->setArgument(1, $config['zeus_api_url']);
    $definition->setArgument(2, $config['zeus_api_login']);
    $definition->setArgument(3, $config['zeus_api_password']);
    $definition->setArgument(4, $config['zeus_api_token']);
    $definition->setArgument(5, $config['zeus_mock_dir']);
    $definition->setArgument(6, $config['client_traitement']);

    $definition = $container->getDefinition('imanaging_api_communication.api_demat_communication');
    $definition->setArgument(0, $config['project_dir']);
    $definition->setArgument(1, $config['demat_api_url']);
    $definition->setArgument(2, $config['demat_api_login']);
    $definition->setArgument(3, $config['demat_api_password']);
    $definition->setArgument(4, $config['demat_mock_dir']);
  }

  public function getAlias() : string
  {
    return 'imanaging_api_communication';
  }
}
