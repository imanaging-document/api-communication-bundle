declare(strict_types=1);

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
  public function load(array $configs, ContainerBuilder $container): void
  {
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    $definition = $container->getDefinition('imanaging_api_communication.api_core_communication');
    $definition->setArguments([
      $config['project_dir'],
      $config['core_api_type'],
      $config['core_api_url'],
      $config['core_api_token'],
      $config['core_api_client_traitement'],
      $config['core_api_annee'],
      $config['core_mock_dir'],
    ]);

    $definition = $container->getDefinition('imanaging_api_communication.api_zeus_communication');
    $definition->setArguments([
      $config['project_dir'],
      $config['zeus_api_url'],
      $config['zeus_api_login'],
      $config['zeus_api_password'],
      $config['zeus_api_token'],
      $config['zeus_mock_dir'],
      $config['client_traitement'],
    ]);

    $definition = $container->getDefinition('imanaging_api_communication.api_demat_communication');
    $definition->setArguments([
      $config['project_dir'],
      $config['demat_api_url'],
      $config['demat_api_login'],
      $config['demat_api_password'],
      $config['demat_mock_dir'],
    ]);
  }

  public function getAlias(): string
  {
    return 'imanaging_api_communication';
  }
}
