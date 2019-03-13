<?php
/**
 * Created by PhpStorm.
 * User: PC14
 * Date: 13/03/2019
 * Time: 12:07
 */

namespace Imanaging\ApiCommunicationBundle\Controller;

use Imanaging\ApiCommunicationBundle\ApiCoreCommunication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiCoreCommunicationController extends AbstractController
{
  private $apiCoreCommunication;

  public function __construct(ApiCoreCommunication $apiCoreCommunication)
  {
    $this->apiCoreCommunication = $apiCoreCommunication;
  }

  public function index()
  {
    return $this->json([
      'api_core_login' => $this->apiCoreCommunication->getApiCoreLogin(),
      'api_core_token' => $this->apiCoreCommunication->getApiCoreToken()
    ]);
  }
}