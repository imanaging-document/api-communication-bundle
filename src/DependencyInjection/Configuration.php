<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 11/03/2019
 * Time: 15:47
 */

namespace Imanaging\ApiCommunicationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('imanaging_api_communication');

    $rootNode
      ->children()
        ->variableNode('project_dir')->defaultValue('')->end()
        ->variableNode('zeus_api_url')->defaultValue('%env(ZEUS_API_URL)%')->end()
        ->variableNode('zeus_api_login')->defaultValue('%env(ZEUS_API_LOGIN)%')->end()
        ->variableNode('zeus_api_password')->defaultValue('%env(ZEUS_API_PASSWORD)%')->end()
        ->variableNode('zeus_mock_dir')->defaultValue('')->end()
        ->variableNode('client_traitement')->defaultValue('%env(CLIENT_TRAITEMENT)%')->end()
        ->variableNode('core_api_url')->defaultValue('%env(CORE_API_URL)%')->end()
        ->variableNode('core_api_token')->defaultValue('%env(CORE_API_TOKEN)%')->end()
        ->variableNode('core_mock_dir')->defaultValue('')->end()
      ->end()
    ;
    return $treeBuilder;
  }
}