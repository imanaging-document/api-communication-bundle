<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 13/03/2019
 * Time: 13:44
 */

namespace Imanaging\ApiCommunicationBundle\Tests\Controller;


use Imanaging\ApiCommunicationBundle\ApiCommunicationBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class ApiCoreCommunicationControllerTest extends TestCase
{
  public function testIndex(){
    $kernel = new KnpULoremIpsumControllerKernel();
    $client = new Client($kernel);
    $client->request('GET', '/api-communication/core/');
    $this->assertSame(200, $client->getResponse()->getStatusCode());
  }
}

class KnpULoremIpsumControllerKernel extends Kernel
{
  use MicroKernelTrait;

  public function __construct()
  {
    parent::__construct('test', true);
  }

  public function registerBundles()
  {
    return [
      new ApiCommunicationBundle(),
      new FrameworkBundle(),
    ];
  }

  public function getCacheDir()
  {
    return __DIR__.'/../cache/'.spl_object_hash($this);
  }

  /**
   * @param RouteCollectionBuilder $routes
   * @throws \Symfony\Component\Config\Exception\LoaderLoadException
   */
  protected function configureRoutes(RouteCollectionBuilder $routes)
  {
    $routes->import(__DIR__.'/../../src/Resources/config/routes.xml', '/api-communication');
  }

  protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
  {
    $c->loadFromExtension('framework', [
      'secret' => 'F00',
    ]);
  }
}